<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Filesystem\Path;

class ExampleGenerator
{
    use FiresCallbacks;

    public function __construct(
        protected string $namespace,
        protected string $outputPath,
        protected array  $generators,
        protected array  $files
    )
    {
    }

    public function generate()
    {
        File::ensureDirectoryExists($this->outputPath);
        $prefix = "\n\n/* THIS FILE HAS BEEN GENERATED AUTOMATICALLY. DO NOT MODIFY */\n\n";
        foreach ($this->generators as $generatorClass) {
            $name = last(explode('\\', $generatorClass));
            $name = Str::remove('Generate', $name);
            $path = Path::join($this->outputPath, $name . '.php');
            /** @var AbstractGenerator $generator */
            $generator = new $generatorClass($path, $this->namespace);
            $generator->setPrefix($prefix);
            dispatch_now($generator);
            $this->fire('generated', compact('name', 'path'));
        }
        foreach ($this->files as $filePath) {
            $content   = File::get($filePath);
            $namespace = "{$prefix} namespace {$this->namespace};";
            $content   = str_replace('namespace Pyro\IdeHelper\Examples;', $namespace, $content);
            $path      = Path::join($this->outputPath, Path::getFilenameWithoutExtension($filePath) . '.php');
            File::put($path, $content);
            $this->fire('copied', compact('path'));
        }
    }

}
