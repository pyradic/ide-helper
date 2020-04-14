<?php

namespace Pyro\IdeHelper;

use Barryvdh\Reflection\DocBlock\Tag;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Laradic\Generators\DocBlock\Tags\MixinTag;
use Laradic\Idea\Command\ResolveSourceFolders;
use Laradic\Support\FS;
use Pyro\IdeHelper\Console\IdeHelperModelsCommand;
use Pyro\IdeHelper\Console\IdeHelperStreamsCommand;
use Pyro\IdeHelper\Metas\AddonsMeta;
use Pyro\IdeHelper\Overrides\FieldTypeParser;

class IdeHelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/pyro.ide.php', 'pyro.ide');
        $this->app->register(\Laradic\Support\SupportServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Laradic\Idea\IdeaServiceProvider::class);

        Tag::registerTagHandler('mixin', MixinTag::class);

        $this->app->singleton('command.ide.streams', function ($app) {
            $command = new IdeHelperStreamsCommand();
//            $command->addCompletions([
//                new AddonCollectionsCompletion([ 'get' ]),
//                AddonServiceProviderCompletion::class,
//                AuthCompletion::class,
//                new EntryDomainsCompletion(config('pyro.ide.toolbox.streams.exclude', [])),
//                FormBuilderCompletion::class,
//                MigrationCompletion::class,
////                ModuleCompletion::class,
//                RequestCompletion::class,
//                TableBuilderCompletion::class,
//            ]);
            return $command;
        });
        $this->commands('command.ide.streams');

        ResolveSourceFolders::extend(function($match){
            /** @var ResolveSourceFolders $this */
            if ($match[ 'hasPackageJson' ]) {
                $pkgName = str_replace('/', '\\', $match['pkg'][ 'name' ]);
                if ($match['pkg']->has('pyro')) {
                    $this->addFolder(path_join($match[ 'packagePath' ], $match['pkg'][ 'pyro.srcPath' ]), $pkgName, false, $match);
                }
            }

            if (FS::isDirectory($match[ 'viewsPath' ])) {
                if(isset($pkgName)) {
                    $prefix = $pkgName . '.views';
                } else {
                    $prefix = $match[ 'composer' ]->collect('autoload.psr-4', [])->keys()->first() . 'views';
                }
                if(isset($prefix)) {
                    $this->addFolder($match[ 'viewsPath' ], $prefix , false, $match);
                }
            }
        });
    }

    public function boot(Repository $config)
    {
        $this->publishes([dirname(__DIR__).'/resources/examples' =>resource_path('ide-helper')],['ide-helper']);
        $metas = $config->get('laradic.idea.meta.metas', []);
        unset($metas[ \Laradic\Idea\Metas\ViewMeta::class ]);
        unset($metas[ \Laradic\Idea\Metas\ConfigMeta::class ]);
        $metas[AddonsMeta::class] = [];
        $config->set('laradic.idea.meta.metas', $metas);

        $this->app->singleton('command.ide-helper.models', IdeHelperModelsCommand::class);
        $this->app->booted(function () {
            if (env('INSTALLED')) {
                $this->app->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
            }
        });
    }

    public function ser()
    {

    }
}
