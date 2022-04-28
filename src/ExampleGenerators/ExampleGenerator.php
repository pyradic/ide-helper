<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Support\Facades\File;
use Symfony\Component\Filesystem\Path;

class ExampleGenerator
{
    use FiresCallbacks;

    protected string $namespace;

    protected string $outputPath;

    protected array $generators;

    protected array $files;

    public function __construct(
        string $namespace,
        string $outputPath,
        array  $generators,
        array  $files
    )
    {
        $this->namespace  = $namespace;
        $this->outputPath = $outputPath;
        $this->generators = $generators;
        $this->files      = $files;
    }

    public function generate()
    {
        if ( ! File::exists($this->outputPath) || ! File::isDirectory($this->outputPath)) {
            File::makeDirectory($this->outputPath, 0755, true);
        }
        $prefix = "\n\n/* THIS FILE HAS BEEN GENERATED AUTOMATICALLY. DO NOT MODIFY */\n\n";
        foreach ($this->generators as $generatorClass) {
            $name = last(explode('\\', $generatorClass));
            $name = str_replace('Generate', '', $name);
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
