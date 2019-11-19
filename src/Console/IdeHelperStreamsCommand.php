<?php

namespace Pyro\IdeHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Generators\DocBlock\ProcessedClassDefinition;
use Laradic\Idea\PhpToolbox\GenerateToolboxViews;
use Pyro\IdeHelper\Completion\AddonServiceProviderCompletion;
use Pyro\IdeHelper\Completion\AuthCompletion;
use Pyro\IdeHelper\Completion\EntryDomainsCompletion;
use Pyro\IdeHelper\Completion\FormBuilderCompletion;
use Pyro\IdeHelper\Completion\ModuleCompletion;
use Pyro\IdeHelper\Completion\RequestCompletion;
use Pyro\IdeHelper\Completion\TableBuilderCompletion;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateToolboxAddonCollections;
use Pyro\IdeHelper\PhpToolbox\GenerateToolboxConfig;

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
//        $this->call('streams:compile', ['--quiet' => true]);
        $this->line('Generating completions...');
        $this->getLaravel()->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);

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
            $generated->getResults()->filter(function (ClassDefinition $doc) use ($modelDocGenerator) {
                if ($doc->getReflection()->isSubclassOf(Model::class)) {
                    $modelDocGenerator->generateForModel($doc->getReflectionName());
                }
            });
        }

        $this->dispatchNow(new GenerateToolboxAddonCollections());
        $this->dispatchNow(new GenerateToolboxConfig());
        $this->dispatchNow(new GenerateToolboxViews());

        $this->info('Streams completion generated');
    }
}
