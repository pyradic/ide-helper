<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class IdeHelperAllCommands extends Command
{
    protected $signature = 'ide-helper:all {--addon=}';

    protected $description = 'Shorthand command that compiles all streams, then calling all ide helping commands there are.';

    public function handle()
    {
        $addon = $this->option('addon');
        if($addon){
            $this->call('ide-helper:models',['--write' => true],true);
            $this->call('ide-helper:streams', [ '--docblocks' => true ],true);
            $this->call('ide-helper:streams', [ '--toolbox' => true ],true);
            $this->call('ide-helper:streams', [ '--models' => true ],true);
        } else {
            $this->warn('Its best to run a "composer dump-autoload" before running this command!!');
            $this->call('streams:compile');
            $this->call('ide-helper:eloquent');
            $this->call('ide-helper:models', [ '--write' => true ], true);
            $this->call('ide-helper:generate');
            $this->call('ide-helper:meta');
            $this->call('idea:completion');
            $this->call('idea:meta');
            $this->call('idea:toolbox');
            $this->call('ide-helper:streams', [ '--docblocks' => true ], true);
            $this->call('ide-helper:streams', [ '--examples' => true ], true);
            $this->call('ide-helper:streams', [ '--toolbox' => true ], true);
            $this->call('ide-helper:streams', [ '--models' => true ], true);
        }
    }

    public function call($command, array $arguments = [], $supportsAddon=false)
    {
        $args  = $_SERVER[ 'argv' ];
        $first = array_first($args, fn($arg) => Str::startsWith($arg, '-v'));
        if ($first) {
            if ( ! array_key_exists('-vvv', $arguments)) {
                $arguments[ '-vvv' ] = true;
            }
        }
        if($supportsAddon && $this->option('addon')){
            $arguments['--addon'] = $this->option('addon');
        }
        $this->getOutput()->writeln("<options=bold>Calling $command </> with arguments " . implode(',', array_keys($arguments)));
        parent::call($command, $arguments);
    }

}
