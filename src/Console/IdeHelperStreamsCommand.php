<?php /** @noinspection PhpVoidFunctionResultUsedInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionGenerator;
use Laradic\Generators\Doc\Doc\Doc;
use Laradic\Generators\Doc\DocChainExecutor;
use Pyro\IdeHelper\DocBlocks\EntryDomainsDocBlocks;
use Pyro\IdeHelper\ExampleGenerators\ExampleGenerator;
use Pyro\IdeHelper\Overrides\ModelDocGenerator;
use Pyro\IdeHelper\PhpToolbox\GenerateStreamsToolbox;

class IdeHelperStreamsCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'ide-helper:streams
                                                {--out= : output path}
                                                {--addon= : addon namespace or slug}
                                                {--all : Experimental}
                                                {--models}
                                                {--examples}
                                                {--toolbox}
                                                {--docblocks}';

    protected $description = '';

    protected $hidden = true;

    protected function createExecutor()
    {
        $executor = resolve(DocChainExecutor::class);
        return $executor;
    }

    protected function validate()
    {
        $required = [ 'models', 'examples', 'toolbox', 'docblocks', 'all' ];
        $options  = array_keys(array_filter($this->input->getOptions()));
        $valid    = count(array_intersect($required, $options)) > 0;
        if ( ! $valid) {
            $this->error('You need to add at least one of the options: ' . implode(', ', $required));
            return false;
        }
        return true;
    }

    public function handle(CompletionGenerator $options, StreamRepositoryInterface $streams, AddonCollection $addons)
    {
        if ( ! $this->validate()) {
            return;
        }
        /** @var \Anomaly\Streams\Platform\Addon\Addon|null $addon */
        $addon = $this->option('addon');
        if ($addon && $addons->has($addon)) {
            $addon = $addons->get($addon);
        }

//        if ($this->option('models')) {
//            $modelDocGenerator = new ModelDocGenerator(app('files'));
//            $modelDocGenerator
//                ->setReset(true)
//                ->setKeepText(true)
//                ->setWriteModelMagicWhere(true)
//                ->setWrite(true);
//
//            $executor = $this->createExecutor();
//            $executor->transform();
//            $models = collect($executor->getRegistry()->getClasses())->map->getReflection()->filter->isSubclassOf(Model::class);
//            foreach ($models as $className => $class) {
//                $this->line("  - Generating model '{$className}' completions...'", null, 'v');
//                $modelDocGenerator->generateForModel($className);
//            }
//            return;
//        }

        if ($this->option('docblocks') || $this->option('all')) {
            $this->line('<options=bold>Generating docblocks...</>');
            $executor = $this->createExecutor();
            if ($addon) {
                $namespace = (new \ReflectionClass($addon))->getNamespaceName();
                $items     = [
                    (new EntryDomainsDocBlocks())->setInclude([ $namespace ]),
                ];
            } else {
                $items = config('pyro.ide-helper.docblock.generators');
                if ( ! is_array($items) && is_callable($items)) {
                    $items = $this->laravel->call($items);
                }
            }
            $executor->appendToChain($items);
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

            $this->line('<options=bold>Generating model docblocks...</>');
            $modelDocGenerator = new ModelDocGenerator(app('files'));
            $modelDocGenerator
                ->setReset(true)
                ->setKeepText(true)
                ->setWriteModelMagicWhere(true)
                ->setWrite(true);
            $models = collect($executor->getRegistry()->getClasses())->map->getReflection()->filter->isSubclassOf(Model::class);
            foreach ($models as $className => $class) {
                $this->line("  - {$className}", null, 'v');
                $modelDocGenerator->generateForModel($className);
            }
        }

        if ($this->option('examples') || $this->option('all')) {
            $this->line('<options=bold>Generating examples...</>');
            /** @var ExampleGenerator $generator */
            $generator = $this->laravel->make(ExampleGenerator::class);
            $generator->on('generated', fn($name, $path) => $this->line(" - Generated '{$name}' at {$path}", null, 'v'));
            $generator->on('copied', fn($path) => $this->line(" - Copied {$path}", null, 'v'));
            $generator->generate();
        }

        if ($this->option('toolbox') || $this->option('all')) {
            $this->line('<options=bold>Generating toolbox completions...</>');
            $this->line('  - Generating stream classes completions...', null, 'v');
            $excludes = config('pyro.ide-helper.toolbox.streams.exclude', []);

            if ($addon) {
                $streamItems = $streams->findAllByNamespace($addon->getSlug());
            } else {
                $streamItems = $streams->all();
            }
            foreach ($streamItems as $stream) {
                $name = $stream->getNamespace() . '::' . $stream->getSlug();
                if (Str::startsWith($stream->getBoundEntryModelName(), $excludes)) {
                    $this->line("     <warning>></warning> Skipped stream '{$name}' completions...", null, 'vv');
                    continue;
                }
                try {
                    $this->dispatchNow(new GenerateStreamsToolbox($stream));
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
