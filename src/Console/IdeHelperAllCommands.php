<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;

class IdeHelperAllCommands extends Command
{
    protected $signature = 'ide-helper:all';

    protected $description = '';

    public function handle()
    {
        $this->call('streams:compile');
        $this->call('ide-helper:eloquent');
        $this->call('ide-helper:models',['--write' => true]);
        $this->call('ide-helper:generate');
        $this->call('ide-helper:meta');
        $this->call('idea:completion');
        $this->call('idea:meta');
        $this->call('idea:toolbox');
        $this->call('ide-helper:streams', ['--docblocks' => true]);
        $this->call('ide-helper:streams', ['--examples' => true]);
        $this->call('ide-helper:streams', ['--toolbox' => true]);
        $this->call('ide-helper:streams', ['--models' => true]);

    }
}
