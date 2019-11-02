<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\DocBlock\ProcessedClassDoc;
use Pyro\IdeHelper\Completion\AddonServiceProviderCompletion;
use Pyro\IdeHelper\Completion\AuthCompletion;
use Pyro\IdeHelper\Completion\EntryDomainsCompletion;
use Pyro\IdeHelper\Completion\FormBuilderCompletion;
use Pyro\IdeHelper\Completion\ModuleCompletion;
use Pyro\IdeHelper\Completion\RequestCompletion;
use Pyro\IdeHelper\Completion\TableBuilderCompletion;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateAddonCollectionToolboxMetadata;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide-helper:streams {--out= : output path} {--clean}';
    protected $description = '';

    public $completions = [];

    public function getCompletions()
    {
        return $this->completions;
    }

    public function setCompletions(array $completions)
    {
        $this->completions = $completions;
    }

    public function addCompletions($completions)
    {
        $completions = Arr::wrap($completions);
        $this->completions = array_merge($this->completions,$completions);
    }

    public function handle(CompletionGenerator $generator)
    {
        $this->line('Compiling streams...');
        $this->call('streams:compile', ['--quiet' => true]);
        $this->line('Generating completions...');

        $generated         = $generator
            ->append($this->completions)
            ->generate();
        $modelDocGenerator = new ModelDocGenerator(app('files'));
        if($this->option('clean')){
            $generated->cleanSourceFiles();
        } elseif ($this->option('out')) {
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

        $this->dispatchNow(new GenerateAddonCollectionToolboxMetadata());

        $this->info('Streams completion generated');
    }
}
