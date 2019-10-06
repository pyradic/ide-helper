<?php

namespace Pyradic\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Pyradic\IdeHelper\Command\GenerateCompletion;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;
    protected $signature = 'ide:streams';
    protected $description = '';

    public function handle()
    {
        $this->dispatchNow(new GenerateCompletion(false));
        $this->info('Streams completion generated');
    }
}
