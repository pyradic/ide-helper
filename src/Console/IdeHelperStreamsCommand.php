<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Laradic\Idea\CompletionGenerator;
use Pyro\IdeHelper\Completion\AddonServiceProviderCompletion;
use Pyro\IdeHelper\Completion\EntryDomainsCompletion;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide:streams {--out= : output path}';

    protected $description = '';

    public function handle(CompletionGenerator $generator)
    {
        $generated = $generator
            ->append([
                EntryDomainsCompletion::class,
                AddonServiceProviderCompletion::class,
            ])
            ->generate();
        if($this->option('out')) {
            $generated->writeToCompletionFile($this->option('out'));
        } else {
            $generated->writeToSourceFiles();;
        }
        $this->info('Streams completion generated');
    }
}
