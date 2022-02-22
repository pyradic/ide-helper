<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $this->call('ide-helper:streams', [ '--docblocks' => true ]);
        $this->call('ide-helper:streams', [ '--examples' => true ]);
        $this->call('ide-helper:streams', [ '--toolbox' => true ]);
        $this->call('ide-helper:streams', [ '--models' => true ]);
    }

    public function call($command, array $arguments = [])
    {
        $args  = $_SERVER[ 'argv' ];
        $first = array_first($args, fn($arg) => Str::startsWith($arg, '-v'));
        if ($first) {
            if ( ! array_key_exists('-vvv', $arguments)) {
                $arguments[ '-vvv' ] = true;
            }
        }
        $this->getOutput()->writeln("<options=bold>Calling $command </> with arguments " . implode(',', array_keys($arguments)));
        parent::call($command, $arguments);
    }

}
