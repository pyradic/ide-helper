<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\Completion\ProcessedCompletions;
use Laradic\Generators\Doc\Doc\ClassDoc;
use Laradic\Generators\Doc\DocChainExecutor;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Idea\PhpToolbox\GenerateRoutesMeta;
use Laradic\Idea\PhpToolbox\GenerateViewsMeta;
use Pyro\IdeHelper\Command\GenerateAddonCollectionExamples;
use Pyro\IdeHelper\Command\GenerateFieldTypeExamples;
use Pyro\IdeHelper\Command\GenerateRoutesExamples;
use Pyro\IdeHelper\DocBlocks\AddonCollectionDocBlocks;
use Pyro\IdeHelper\DocBlocks\AddonServiceProviderDocBlocks;
use Pyro\IdeHelper\DocBlocks\AuthDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryDomainsDocBlocks;
use Pyro\IdeHelper\DocBlocks\FormBuilderDocBlocks;
use Pyro\IdeHelper\DocBlocks\MigrationDocBlocks;
use Pyro\IdeHelper\DocBlocks\ModuleDocBlocks;
use Pyro\IdeHelper\DocBlocks\RequestDocBlocks;
use Pyro\IdeHelper\DocBlocks\ControlPanelDocBlocks;
use Pyro\IdeHelper\DocBlocks\TableBuilderDocBlocks;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateAddonCollectionsMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateConfigMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateStreamMeta;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide-helper:streams
                                                {--out= : output path}
                                                {--clean}
                                                {--pick}';

    protected $description = '';

//
//    public $completions = [];
//
//    public function getCompletions()
//    {
//        return $this->completions;
//    }
//
//    public function setCompletions(array $completions)
//    {
//        $this->completions = $completions;
//    }
//
//    public function addCompletions($completions)
//    {
//        $completions       = Arr::wrap($completions);
//        $this->completions = array_merge($this->completions, $completions);
//    }

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
        }

        $generate = [
            'examples'    => true,
            'models'      => true,
            'toolbox'     => true,
            'docblocks'   => true,
        ];

        if ($this->option('pick')) {
            $generators = $this->select('Pick generators', array_keys($generate), true);
            foreach ($generate as $key => $value) {
                $generate[ $key ] = in_array($key, $generators);
            }
        }

        if ($generate[ 'examples' ]) {
            $this->line('<options=bold>Generating examples...</>');
            $namespace = 'Pyro\\IdeHelper\\Examples';
            $this->line('  - GenerateAddonCollectionExamples', null, 'v');
            dispatch_now(new GenerateAddonCollectionExamples(__DIR__ . '/../../resources/examples/AddonCollectionExamples.php', $namespace));
            $this->line('  - GenerateFieldTypeExamples', null, 'v');
            dispatch_now(new GenerateFieldTypeExamples(__DIR__ . '/../../resources/examples/FieldTypeExamples.php', $namespace));
            $this->line('  - GenerateRouteExamples', null, 'v');
            dispatch_now(new GenerateRoutesExamples(__DIR__ . '/../../resources/examples/RoutesExamples.php', $namespace));
        }

        $executor = resolve(DocChainExecutor::class);
        $executor->appendToChain([
            AddonCollectionDocBlocks::class,
            AddonServiceProviderDocBlocks::class,
            AuthDocBlocks::class,
            new EntryDomainsDocBlocks(),
            FormBuilderDocBlocks::class,
            MigrationDocBlocks::class,
            ModuleDocBlocks::class,
            RequestDocBlocks::class,
            ControlPanelDocBlocks::class,
            TableBuilderDocBlocks::class,
        ]);
        $executor->transform();

        if ($generate[ 'models' ]) {
            $this->line('<options=bold>Generating model completions...</>');
            $modelDocGenerator = new ModelDocGenerator(app('files'));
            $modelDocGenerator
                ->setReset(true)
                ->setKeepText(true)
                ->setWriteModelMagicWhere(true)
                ->setWrite(true);

            collect($executor->getRegistry()->getClasses())->filter(function (ClassDoc $doc) use ($modelDocGenerator) {
                if ($doc->getReflection()->isSubclassOf(Model::class)) {
                    $this->line("  - Generating model '{$doc->getReflection()->getName()}' completions...'", null, 'v');
                    $modelDocGenerator->generateForModel($doc->getReflection()->getName());
                }
            });
        }

        if ($generate[ 'docblocks' ]) {
            $this->line('<options=bold>Generating docblock completions...</>');
            $executor->run();
        }

        if ($generate[ 'toolbox' ]) {
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
            $this->line('  - Generating route completions...', null, 'v');
            $this->dispatchNow(new GenerateRoutesMeta());
        }

        $this->info('Streams completion generated');
    }

}
