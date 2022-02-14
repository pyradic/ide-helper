<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\Doc\Doc\Doc;
use Laradic\Generators\Doc\DocChainExecutor;
use Pyro\IdeHelper\Command\GenerateAddonCollectionExamples;
use Pyro\IdeHelper\Command\GenerateFieldTypeExamples;
use Pyro\IdeHelper\Command\GeneratePermissionsExamples;
use Pyro\IdeHelper\Command\GenerateRoutesExamples;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateStreamMeta;
use Symfony\Component\Process\Process;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide-helper:streams
                                                {--out= : output path}
                                                {--models}
                                                {--examples}
                                                {--toolbox}
                                                {--docblocks}
                                                {--clean}
                                                {--pick}';

    protected $description = '';

    protected $hidden = true;

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

    protected function createExecutor()
    {
        $executor = resolve(DocChainExecutor::class);
        $items    = config('pyro.ide-helper.docblock.generators');
        if ( ! is_array($items) && is_callable($items)) {
            $items = $this->laravel->call($items);
        }
        $executor->appendToChain($items);
        return $executor;
    }

    protected function spawnCall($args)
    {
        $phpBin = $_SERVER[ 'argv' ][ 0 ];
        $out    = $this->getOutput();

        $verbosity = $out->isVerbose() ? '-v' : '';
        $verbosity = $out->isVeryVerbose() ? '-vv' : $verbosity;
        $verbosity = $out->isDebug() ? '-vvv' : $verbosity;
        $args      = Arr::wrap($args);
        $process   = new Process(array_merge([ $phpBin, 'artisan', $verbosity ], $args));
        $process
            ->setIdleTimeout(120)
            ->setTimeout(120)
            ->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo $buffer;
                } else {
                    echo $buffer;
                }
            });
//        $this->line(exec("{$phpBin} artisan {$verbosity} {$args}"));
    }

    public function handle(CompletionGenerator $options, StreamRepositoryInterface $streams)
    {

        if ($this->option('models')) {
            $modelDocGenerator = new ModelDocGenerator(app('files'));
            $modelDocGenerator
                ->setReset(true)
                ->setKeepText(true)
                ->setWriteModelMagicWhere(true)
                ->setWrite(true);

            $executor = $this->createExecutor();
            $executor->transform();
            $models = collect($executor->getRegistry()->getClasses())->map->getReflection()->filter->isSubclassOf(Model::class);
            foreach ($models as $className => $class) {
                $this->line("  - Generating model '{$className}' completions...'", null, 'v');
                $modelDocGenerator->generateForModel($className);
            }
            return;
        }
        if ($this->option('docblocks')) {
            $executor = $this->createExecutor();
            $executor->transform();
            $executor->getSerializer()->on('write', function (Doc $classDoc) {
                $name = $classDoc->getReflection()->getName();
                $this->line("     <info>></info> {$name}", null, 'vv');
            });
            $executor->on('call', function ($item) {
                $class = get_class($item);
                $this->line(" - {$class}", null, 'v');
            });
            $executor->run();
            return;
        }

//        $this->line('<options=bold>Generating idea completions...</>');
//        $this->spawnCall('idea:completion');

//        $this->line('<options=bold>Generating model completions...</>');
//        $this->spawnCall('ide-helper:streams --models');
//        $this->line('<options=bold>Generating docblock completions...</>');
//        $this->spawnCall('ide-helper:streams --docblocks');

        $options->before(function ($pipe) {
            $class = get_class($pipe);
            $this->line("  - Generating {$class}", null, 'v');
        });

        if($this->option('examples')) {
            // examples
            $this->line('<options=bold>Generating examples...</>');
            $namespace = 'Pyro\\IdeHelper\\Examples';
            $this->line('  - GenerateAddonCollectionExamples', null, 'v');
            dispatch_now(new GenerateAddonCollectionExamples(__DIR__ . '/../../resources/examples/AddonCollectionExamples.php', $namespace));
            $this->line('  - GenerateFieldTypeExamples', null, 'v');
            dispatch_now(new GenerateFieldTypeExamples(__DIR__ . '/../../resources/examples/FieldTypeExamples.php', $namespace));
            $this->line('  - GenerateRouteExamples', null, 'v');
            dispatch_now(new GenerateRoutesExamples(__DIR__ . '/../../resources/examples/RoutesExamples.php', $namespace));
            $this->line('  - GeneratePermissionsExamples', null, 'v');
            dispatch_now(new GeneratePermissionsExamples(__DIR__ . '/../../resources/examples/PermissionsExamples.php', $namespace));
        }

        if($this->option('toolbox')) {
            // toolbox
            $this->line('<options=bold>Generating toolbox completions...</>');
            $this->line('  - Generating stream classes completions...', null, 'v');
            $excludes = config('pyro.ide-helper.toolbox.streams.exclude', []);
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

            $this->call('ide:toolbox');
        }

        $this->info('Streams completion generated');
    }

}
