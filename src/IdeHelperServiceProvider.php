<?php

namespace Pyro\IdeHelper;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Barryvdh\Reflection\DocBlock\Tag;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Laradic\Generators\Doc\Tags\MixinTag;
use Laradic\Idea\Command\ResolveSourceFolders;
use Laradic\Support\FS;
use Pyro\IdeHelper\Console\IdeHelperAllCommands;
use Pyro\IdeHelper\Console\IdeHelperMetaCommand;
use Pyro\IdeHelper\Console\IdeHelperModelsCommand;
use Pyro\IdeHelper\Console\IdeHelperStreamsCommand;
use Pyro\IdeHelper\ExampleGenerators\ExampleGenerator;
use Pyro\IdeHelper\Metas\AddonsMeta;
use Pyro\IdeHelper\Overrides\FieldTypeParser;

class IdeHelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/pyro.ide-helper.php', 'pyro.ide-helper');
        $this->registerProviders();
        $this->registerCommands();
        $this->registerExampleGenerator();
        $this->registerResolveSourceFolders();
        Tag::registerTagHandler('mixin', MixinTag::class);

        $this->app->booted(function () {
            if (env('INSTALLED')) {
                $this->app->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
            }
        });
    }

    public function boot(Repository $config)
    {
        $this->publishes([ dirname(__DIR__) . '/config/pyro.ide-helper.php' => config_path('pyro.ide-helper.php') ], [ 'config', 'ide-helper' ]);
        $this->overrideConfigs();
        $this->overrideCommands();
    }

    protected function registerProviders()
    {
        $this->app->register(\Laradic\Support\SupportServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Laradic\Idea\IdeaServiceProvider::class);
    }

    protected function registerCommands()
    {
        $this->app->singleton('command.ide.streams', IdeHelperStreamsCommand::class);
        $this->app->singleton('command.ide.all', IdeHelperAllCommands::class);
        $this->commands('command.ide.streams');
        $this->commands('command.ide.all');
    }

    protected function registerResolveSourceFolders()
    {
        ResolveSourceFolders::extend(function ($match) {
            /** @var ResolveSourceFolders $this */
            if ($match[ 'hasPackageJson' ]) {
                $pkgName = str_replace('/', '\\', $match[ 'pkg' ][ 'name' ]);
                if ($match[ 'pkg' ]->has('pyro')) {
                    $this->addFolder(path_join($match[ 'packagePath' ], $match[ 'pkg' ][ 'pyro.srcPath' ]), $pkgName, false, $match);
                }
            }

            if (FS::isDirectory($match[ 'viewsPath' ])) {
                if (isset($pkgName)) {
                    $prefix = $pkgName . '.views';
                } else {
                    $prefix = $match[ 'composer' ]->collect('autoload.psr-4', [])->keys()->first() . 'views';
                }
                if (isset($prefix)) {
                    $this->addFolder($match[ 'viewsPath' ], $prefix, false, $match);
                }
            }
        });
    }

    protected function registerExampleGenerator()
    {
        $this->app->bind(ExampleGenerator::class, function ($app) {
            $namespace  = config('pyro.ide-helper.examples.namespace');
            $outputPath = config('pyro.ide-helper.examples.output_path');
            $generators = config('pyro.ide-helper.examples.generators');
            $files      = config('pyro.ide-helper.examples.files');
            $files      = array_map(fn($file) => __DIR__ . '/../resources/examples/' . $file, $files);

            return new ExampleGenerator($namespace, $outputPath, $generators, $files);
        });
    }

    protected function overrideCommands()
    {
        $this->app->singleton('command.ide-helper.models', IdeHelperModelsCommand::class);
        $this->app->singleton('command.ide-helper.meta', function ($app) {
          return  new IdeHelperMetaCommand($app[ 'files' ], $this->createLocalViewFactory(), $app[ 'config' ]);
        });
    }

    protected function overrideConfigs()
    {
        $config = resolve(Repository::class);
        $config->push('ide-helper.ignored_models', 'Anomaly\Streams\Platform\Model\Search\SearchItemsEntryModel');
        $config->push('ide-helper.ignored_models', EloquentModel::class);
        $config->set('ide-helper.force_fqn', true);
        $config->set('ide-helper.include_class_docblocks', true);
        $config->set('ide-helper.write_model_external_builder_methods', false);
        $config->set('ide-helper.write_model_relation_count_properties', false);

        $metas = $config->get('laradic.idea.meta.metas', []);
        unset($metas[ \Laradic\Idea\Metas\ViewMeta::class ]);
        unset($metas[ \Laradic\Idea\Metas\ConfigMeta::class ]);
        $metas[ AddonsMeta::class ] = [];
        $config->set('laradic.idea.meta.metas', $metas);
        $config->set('laradic.idea.toolbox.generators', $config->get('pyro.ide-helper.toolbox.generators'));
    }

    /**
     * @return Factory
     */
    public function createLocalViewFactory()
    {
        $resolver = new EngineResolver();
        $resolver->register('php', function () {
            return new PhpEngine($this->app[ 'files' ]);
        });
        $finder  = new FileViewFinder($this->app[ 'files' ], [ __DIR__ . '/../resources/views' ]);
        $factory = new Factory($resolver, $finder, $this->app[ 'events' ]);
        $factory->addExtension('php', 'php');

        return $factory;
    }
}
