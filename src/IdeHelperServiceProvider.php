<?php

namespace Pyro\IdeHelper;

use Illuminate\Support\ServiceProvider;
use Pyro\IdeHelper\Completion\AddonCollectionsCompletion;
use Pyro\IdeHelper\Completion\AddonServiceProviderCompletion;
use Pyro\IdeHelper\Completion\AuthCompletion;
use Pyro\IdeHelper\Completion\EntryDomainsCompletion;
use Pyro\IdeHelper\Completion\FormBuilderCompletion;
use Pyro\IdeHelper\Completion\ModuleCompletion;
use Pyro\IdeHelper\Completion\RequestCompletion;
use Pyro\IdeHelper\Completion\TableBuilderCompletion;
use Pyro\IdeHelper\Console\IdeHelperModelsCommand;
use Pyro\IdeHelper\Console\IdeHelperStreamsCommand;
use Pyro\IdeHelper\Overrides\FieldTypeParser;

class IdeHelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(\Laradic\Support\SupportServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Laradic\Idea\IdeaServiceProvider::class);

        $this->app->singleton('command.ide.streams', function () {
            $command = new IdeHelperStreamsCommand();
            $command->addCompletions([
                new AddonCollectionsCompletion(['get']),
                AddonServiceProviderCompletion::class,
                AuthCompletion::class,
                EntryDomainsCompletion::class,
                FormBuilderCompletion::class,
                ModuleCompletion::class,
                RequestCompletion::class,
                TableBuilderCompletion::class,
            ]);
            return $command;
        });
        $this->commands('command.ide.streams');
    }

    public function boot()
    {
        $this->app->singleton('command.ide-helper.models', IdeHelperModelsCommand::class);
        if (env('INSTALLED')) {
            $this->app->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
        }
    }
}
