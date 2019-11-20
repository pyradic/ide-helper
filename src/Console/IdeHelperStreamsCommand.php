<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Idea\PhpToolbox\GenerateToolboxViews;
use Pyro\IdeHelper\Completion\EntryDomainsCompletion;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateStreamMeta;
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
        $completions       = Arr::wrap($completions);
        $this->completions = array_merge($this->completions, $completions);
    }

    public function out(int $level, string $text, string $prefixColor = null)
    {
        $prefix = "<fg={$prefixColor}>";

        if($level === 0){
            $this->line("<options=bold>{$text}</>");
        } elseif($level === 1){

            $this->line("{$text}");
        } elseif($level === 1){
            $this->line("{$prefix} -</> {$text}");
        }elseif($level === 2){
            $this->line("{$prefix} ></> {$text}");
        }
    }

    public function handle(CompletionGenerator $generator, StreamRepositoryInterface $streams)
    {
        $this->getLaravel()->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
        $this->warn('Consider compiling streams before running this command');

        $generator->before(function($pipe){
            $class = get_class($pipe);
            $this->line("  - Generating {$class}",null,'v');
        });

        if ($this->option('clean')) {
            $this->line('<options=bold>Cleaning all files...</>');
            $generator->append($this->completions)->generate()->cleanSourceFiles();
            return $this->info('Cleaned all files');
        }

        $this->line('<options=bold>Generating docblock completions...</>');
        $generated = $generator->append($this->completions)->generate();

        if ($this->option('out')) {
            $generated->writeToCompletionFile($this->option('out'));
            return $this->info('Created completion file');
        }

        $generated->writeToSourceFiles();

        $this->line('<options=bold>Generating model completions...</>');
        $modelDocGenerator = new ModelDocGenerator(app('files'));
        $modelDocGenerator
            ->setReset(true)
            ->setKeepText(true)
            ->setWriteModelMagicWhere(true)
            ->setWrite(true);

        $generated->getResults()->filter(function (ClassDefinition $doc) use ($modelDocGenerator) {
            if ($doc->getReflection()->isSubclassOf(Model::class)) {
                $this->line("  - Generating model '{$doc->getReflectionName()}' completions...'",null,'v');
                $modelDocGenerator->generateForModel($doc->getReflectionName());
            }
        });

        $this->line('<options=bold>Generating toolbox completions...</>');
        $this->line('  - Generating stream classes completions...',null,'v');
        $excludes = config('pyro.ide.toolbox.streams.exclude', []);
        foreach ($streams->all() as $stream) {
            $name = $stream->getNamespace() . '::' . $stream->getSlug();
            if(Str::startsWith($stream->getBoundEntryModelName(),$excludes)){
                $this->line("     <warning>></warning> Skipped stream '{$name}' completions...",null,'vv');
                continue;
            }
            try {
                $this->dispatchNow(new GenerateStreamMeta($stream));
                $this->line("     <info>></info> Generated stream '{$name}' completions", null, 'vv');
            } catch (\Exception $e){
                $this->line("<fg=red;options=bold>Error generating {$name}</> <fg=red>{$e->getMessage()}</>",null,'vv');
            }
        }
        $this->line('  - Generating addon collections completions...',null,'v');
        $this->dispatchNow(new GenerateToolboxAddonCollections());
        $this->line('  - Generating config completions...',null,'v');
        $this->dispatchNow(new GenerateToolboxConfig());
        $this->line('  - Generating view completions...',null,'v');
        $this->dispatchNow(new GenerateToolboxViews());

        $this->info('Streams completion generated');
    }
}
