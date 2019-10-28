<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Laradic\Generators\DocBlock\ProcessedClassDoc;
use Laradic\Idea\CompletionGenerator;
use Pyro\IdeHelper\Completion\AddonServiceProviderCompletion;
use Pyro\IdeHelper\Completion\AuthCompletion;
use Pyro\IdeHelper\Completion\EntryDomainsCompletion;
use Pyro\IdeHelper\Completion\FormBuilderCompletion;
use Pyro\IdeHelper\Completion\ModuleCompletion;
use Pyro\IdeHelper\Completion\RequestCompletion;
use Pyro\IdeHelper\Completion\TableBuilderCompletion;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide:streams {--out= : output path}';

    public static $completions = [
        EntryDomainsCompletion::class,
        FormBuilderCompletion::class,
        ModuleCompletion::class,
        AddonServiceProviderCompletion::class,
        TableBuilderCompletion::class,
        AuthCompletion::class,
        RequestCompletion::class
    ];

    protected $description = '';

    public function handle(CompletionGenerator $generator)
    {
        $this->call('streams:compile');

        $generated         = $generator
            ->append(static::$completions)
            ->generate();
        $modelDocGenerator = new ModelDocGenerator(app('files'));
        if ($this->option('out')) {
            $generated->writeToCompletionFile($this->option('out'));
        } else {
            $generated->writeToSourceFiles();
            $modelDocGenerator->setWrite(true);
            $generated->getResults()->filter(function (ProcessedClassDoc $doc) use ($modelDocGenerator) {
                if ($doc->getClass()->isSubclassOf(Model::class)) {
                    $modelDocGenerator->generateForModel($doc->getClass());
                    //$doc->setDoc($newDoc);
//                $this->line('generated for model '.$doc->getClass()->getName());
                }
            });
        }
        $this->info('Streams completion generated');
    }
}
