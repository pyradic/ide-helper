<?php

namespace Pyradic\IdeHelper;

use Illuminate\Support\ServiceProvider;
use Pyradic\IdeHelper\Console\IdeHelperStreamsCommand;

class IdeHelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IdeHelperStreamsCommand::class);
        $this->commands(IdeHelperStreamsCommand::class);;
    }
}
