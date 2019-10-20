<?php

namespace Pyro\IdeHelper;

use Illuminate\Support\ServiceProvider;
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

        $this->app->singleton(IdeHelperStreamsCommand::class);
        $this->commands(IdeHelperStreamsCommand::class);
    }

    public function boot()
    {
        $this->app->singleton('command.ide-helper.models', IdeHelperModelsCommand::class);
        $this->app->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);

    }
}
