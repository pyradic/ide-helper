<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\Doc\Doc\ClassDoc;
use Laradic\Generators\Doc\Doc\Doc;
use Laradic\Generators\Doc\DocBlock;
use Laradic\Generators\Doc\DocChainExecutor;
use Laradic\Idea\PhpToolbox\GenerateRoutesMeta;
use Laradic\Idea\PhpToolbox\GenerateViewsMeta;
use Pyro\IdeHelper\Command\GenerateAddonCollectionExamples;
use Pyro\IdeHelper\Command\GenerateFieldTypeExamples;
use Pyro\IdeHelper\Command\GeneratePermissionsExamples;
use Pyro\IdeHelper\Command\GenerateRoutesExamples;
use Pyro\IdeHelper\DocBlocks\AddonCollectionDocBlocks;
use Pyro\IdeHelper\DocBlocks\AddonServiceProviderDocBlocks;
use Pyro\IdeHelper\DocBlocks\AuthDocBlocks;
use Pyro\IdeHelper\DocBlocks\ControlPanelDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryDomainsDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryModelDocBlocks;
use Pyro\IdeHelper\DocBlocks\ExtensionDocBlocks;
use Pyro\IdeHelper\DocBlocks\FieldTypeDocBlocks;
use Pyro\IdeHelper\DocBlocks\FormBuilderDocBlocks;
use Pyro\IdeHelper\DocBlocks\MigrationDocBlocks;
use Pyro\IdeHelper\DocBlocks\ModuleDocBlocks;
use Pyro\IdeHelper\DocBlocks\RequestDocBlocks;
use Pyro\IdeHelper\DocBlocks\TableBuilderDocBlocks;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateAddonCollectionsMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateConfigMeta;
use Pyro\IdeHelper\PhpToolbox\GeneratePermissionsMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateStreamMeta;
use Symfony\Component\Process\Process;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide-helper:streams
                                                {--out= : output path}
                                                {--models}
                                                {--docblocks}
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

    protected function createExecutor()
    {
        $executor = resolve(DocChainExecutor::class);
        $executor->appendToChain(config('pyro.ide-helper.docblock.generators'));
        return $executor;
    }

    protected function spawnCall($args)
    {
        $phpBin = $_SERVER[ '_' ];
        $out    = $this->getOutput();

        $verbosity = $out->isVerbose() ? '-v' : '';
        $verbosity = $out->isVeryVerbose() ? '-vv' : $verbosity;
        $verbosity = $out->isDebug() ? '-vvv' : $verbosity;
        $process   = new Process("{$phpBin} artisan {$verbosity} {$args}");
        $process->run(function ($type, $buffer) {
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
        /*
         * We run this shell command another 2 times.
         * First we spawn a process for generating the docblocks for models (using the barryvdh/laravel-ide-helper)
         * After that we spawn a process for generating the other docblocks.
         *
         * This ensures the the php reflection for classes --dockblocks are
         */
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

        $this->getLaravel()->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
        $this->warn('It\'s advised to compile the streams before running this command by running <options=bold>php artisan streams:compile</>');

        $this->line('<options=bold>Generating model completions...</>');
        $this->spawnCall('ide-helper:streams --models');
        $this->line('<options=bold>Generating docblock completions...</>');
        $this->spawnCall('ide-helper:streams --docblocks');

        $options->before(function ($pipe) {
            $class = get_class($pipe);
            $this->line("  - Generating {$class}", null, 'v');
        });

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

        foreach (config('pyro.ide-helper.toolbox.generators') as $generatorConfig) {
            $generatorConfig = collect($generatorConfig);
            $this->line("  - Generating {$generatorConfig->pull('description')}...", null, 'v');
            $class    = $generatorConfig->pull('class');
            $instance = new $class;
            foreach ($generatorConfig as $key => $value) {
                $methodName = Str::camel('set_' . $key);
                if (method_exists($instance, $methodName)) {
//                    $params = Arr::wrap($value);
                    call_user_func([ $instance, $methodName ], $value);
                }
            }
        }

        $this->info('Streams completion generated');
    }

}
