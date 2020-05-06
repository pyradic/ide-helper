<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\Doc\Doc\ClassDoc;
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
        $executor->appendToChain([
            AddonCollectionDocBlocks::class,
            AddonServiceProviderDocBlocks::class,
            AuthDocBlocks::class,
            new EntryDomainsDocBlocks(),
            EntryModelDocBlocks::class,
            FieldTypeDocBlocks::class,
            FormBuilderDocBlocks::class,
            MigrationDocBlocks::class,
            ExtensionDocBlocks::class,
            ModuleDocBlocks::class,
            RequestDocBlocks::class,
            ControlPanelDocBlocks::class,
            TableBuilderDocBlocks::class,
        ]);
        return $executor;
    }

    protected function spawnCall($args)
    {
        $phpBin = $_SERVER[ '_' ];
        $out=$this->getOutput();

        $verbosity = $out->isVerbose() ? '-v' : '';
        $verbosity = $out->isVeryVerbose() ? '-vv' : $verbosity;
        $verbosity = $out->isDebug() ? '-vvv' : $verbosity;
        $process = new Process("{$phpBin} artisan {$verbosity} {$args}");
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo $buffer;
            } else {
                echo $buffer;
            }
        });
//        $this->line(exec("{$phpBin} artisan {$verbosity} {$args}"));
    }

    public function handle(CompletionGenerator $generator, StreamRepositoryInterface $streams)
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
            foreach($models as $className => $class){
                $this->line("  - Generating model '{$className}' completions...'", null, 'v');
                $modelDocGenerator->generateForModel($className);
            }
            return;
        }
        if ($this->option('docblocks')) {
            $executor = $this->createExecutor();
            $executor->transform();
            $executor->run();
            return;
        }



        $this->getLaravel()->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
        $this->warn('It\'s advised to compile the streams before running this command by running <options=bold>php artisan streams:compile</>');

        $this->line('<options=bold>Generating model completions...</>');
        $this->spawnCall('ide-helper:streams --models');
        $this->line('<options=bold>Generating docblock completions...</>');
        $this->spawnCall('ide-helper:streams --docblocks');

        $generator->before(function ($pipe) {
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
        $this->line('  - Generating permission completions...', null, 'v');
        $this->dispatchNow(new GeneratePermissionsMeta());

        $this->info('Streams completion generated');
    }

}
