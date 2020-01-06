<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\Completion\ProcessedCompletions;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Idea\PhpToolbox\GenerateViewsMeta;
use Laradic\Support\MultiBench;
use Pyro\IdeHelper\Command\GenerateAddonCollectionExamples;
use Pyro\IdeHelper\Command\GenerateFieldTypeExamples;
use Pyro\IdeHelper\Command\GenerateRoutesExamples;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateAddonCollectionsMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateConfigMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateStreamMeta;
use Pyro\Platform\Console\RouteListCommand;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide-helper:streams
                                                {--out= : output path}
                                                {--clean}
                                                {--pick}';

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

        if ($level === 0) {
            $this->line("<options=bold>{$text}</>");
        } elseif ($level === 1) {

            $this->line("{$text}");
        } elseif ($level === 1) {
            $this->line("{$prefix} -</> {$text}");
        } elseif ($level === 2) {
            $this->line("{$prefix} ></> {$text}");
        }
    }

    public function handle(CompletionGenerator $generator, StreamRepositoryInterface $streams)
    {
        $this->getLaravel()->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
        $this->warn('- You might need to run this command twice (fixing this issue is on the todo list)');
        $this->warn('- Consider compiling streams before running this command');

        $generator->before(function ($pipe) {
            $class = get_class($pipe);
            $this->line("  - Generating {$class}", null, 'v');
        });

        if ($this->option('clean')) {
            return $this->warn('Not implemented');
//            $this->line('<options=bold>Cleaning all files...</>');
//            $generator->append($this->completions)->generate()->cleanSourceFiles();
//            return $this->info('Cleaned all files');
        }

        $generate = [
            'completions' => true,
            'models'      => true,
            'toolbox'     => true,
        ];

        if ($this->option('pick')) {
            $generators = $this->select('Pick generators', array_keys($generate), true);
            foreach($generate as $key=>$value){
                $generate[$key] = in_array($key, $generators);
            }
//            $this->completions = $this->select('Pick completions', array_map(function($item){ return is_object($item) ? get_},$this->completions), true);
        }



        $this->line('<options=bold>Generating examples...</>');
        $namespace = 'Pyro\\IdeHelper\\Examples';
        $this->line('  - GenerateAddonCollectionExamples', null, 'v');
        dispatch_now(new GenerateAddonCollectionExamples(__DIR__ . '/../../resources/examples/AddonCollectionExamples.php', $namespace));
        $this->line('  - GenerateFieldTypeExamples', null, 'v');
        dispatch_now(new GenerateFieldTypeExamples(__DIR__ . '/../../resources/examples/FieldTypeExamples.php', $namespace));
        $this->line('  - GenerateRouteExamples', null, 'v');
        dispatch_now(new GenerateRoutesExamples(__DIR__ . '/../../resources/examples/RoutesExamples.php', $namespace));

        if($generate['completions']) {
            $this->line('<options=bold>Generating completions...</>');
            MultiBench::on('completions')->start(true);
            $generated = $generator->append($this->completions)->generate();
            MultiBench::on('completions')->stop(true)->dump();

            $this->line('<options=bold>Writing completions to file(s)...</>');
            if ($this->option('out')) {
                $generated->writeToCompletionFile($this->option('out'));
            } else {
                $generated->writeToSourceFiles();
            }

            if($generate['models']) {
                $this->line('<options=bold>Generating model completions...</>');
                $modelDocGenerator = new ModelDocGenerator(app('files'));
                $modelDocGenerator
                    ->setReset(true)
                    ->setKeepText(true)
                    ->setWriteModelMagicWhere(true)
                    ->setWrite(true);

                $generated->getResults()->filter(function (ClassDefinition $doc) use ($modelDocGenerator) {
                    if ($doc->getReflection()->isSubclassOf(Model::class)) {
                        $this->line("  - Generating model '{$doc->getReflectionName()}' completions...'", null, 'v');
                        $modelDocGenerator->generateForModel($doc->getReflectionName());
                    }
                });
            }
        }
        if($generate['toolbox']) {
            $this->line('<options=bold>Generating toolbox completions...</>');
            $this->line('  - Generating stream classes completions...', null, 'v');
            $excludes = config('pyro.ide.toolbox.streams.exclude', []);
            foreach ($streams->all() as $stream) {
                $name = $stream->getNamespace() . '::' . $stream->getSlug();
                if (Str::startsWith($stream->getBoundEntryModelName(), $excludes)) {
                    $this->line("     <warning>></warning> Skipped stream '{$name}' completions...", null, 'vv');
                    continue;
                }
                try {
                    $this->dispatchNow(new GenerateStreamMeta($stream));
                    $this->line("     <info>></info> Generated stream '{$name}' completions", null, 'vv');
                }
                catch (\Exception $e) {
                    $this->line("<fg=red;options=bold>Error generating {$name}</> <fg=red>{$e->getMessage()}</>", null, 'vv');
                }
            }
            $this->line('  - Generating addon collections completions...', null, 'v');
            $this->dispatchNow(new GenerateAddonCollectionsMeta());
            $this->line('  - Generating config completions...', null, 'v');
            $this->dispatchNow(new GenerateConfigMeta());
            $this->line('  - Generating view completions...', null, 'v');
            $this->dispatchNow(new GenerateViewsMeta());
        }
        $this->info('Streams completion generated');
    }

    protected function pick()
    {

        $steps = [
            'docblocks'                 => function (ProcessedCompletions $generated) {
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
                        $this->line("  - Generating model '{$doc->getReflectionName()}' completions...'", null, 'v');
                        $modelDocGenerator->generateForModel($doc->getReflectionName());
                    }
                });
            },
            'toolbox.streams'           => function ($generated) {
                $this->line('  - Generating stream classes completions...', null, 'v');
                $excludes = config('pyro.ide.toolbox.streams.exclude', []);
                foreach (resolve(StreamRepositoryInterface::class)->all() as $stream) {
                    $name = $stream->getNamespace() . '::' . $stream->getSlug();
                    if (Str::startsWith($stream->getBoundEntryModelName(), $excludes)) {
                        $this->line("     <warning>></warning> Skipped stream '{$name}' completions...", null, 'vv');
                        continue;
                    }
                    try {
                        $this->dispatchNow(new GenerateStreamMeta($stream));
                        $this->line("     <info>></info> Generated stream '{$name}' completions", null, 'vv');
                    }
                    catch (\Exception $e) {
                        $this->line("<fg=red;options=bold>Error generating {$name}</> <fg=red>{$e->getMessage()}</>", null, 'vv');
                    }
                }
            },
            'toolbox.addon_collections' => function () {
                $this->line('  - Generating addon collections completions...', null, 'v');
                $this->dispatchNow(new GenerateAddonCollectionsMeta());
            },
            'toolbox.config'            => function () {
                $this->line('  - Generating config completions...', null, 'v');
                $this->dispatchNow(new GenerateConfigMeta());
            },
            'toolbox.views'             => function () {
                $this->line('  - Generating view completions...', null, 'v');
                $this->dispatchNow(new GenerateViewsMeta());
            },
        ];

        if ($this->option('pick')) {
            $picked = $this->select('Select generators', array_keys($steps), true);
            foreach ($picked as $key) {
//                $steps[$key]($generated);
            }
            $this->info('Streams completion generated');
        }
    }
}
