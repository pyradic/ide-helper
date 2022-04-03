<?php

namespace Pyro\IdeHelper\Overrides;

use Pyro\IdeHelper\Console\IdeHelperModelsCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ModelDocGenerator extends IdeHelperModelsCommand
{
    public function generateForModel($class, ?OutputInterface $output = null)
    {
        $this->output = $output ?? new BufferedOutput();
        $this->laravel = app();
        return $this->generateDocs([$class]);
    }


    public function setWrite(bool $write)
    {
        $this->write=$write;
        return $this;
    }

    public function setFiles(\Illuminate\Filesystem\Filesystem $files): ModelDocGenerator
    {
        $this->files = $files;
        return $this;
    }

    public function setFilename(string $filename): ModelDocGenerator
    {
        $this->filename = $filename;
        return $this;
    }

    public function setWriteModelMagicWhere($write_model_magic_where)
    {
        $this->write_model_magic_where = $write_model_magic_where;
        return $this;
    }

    public function setProperties(array $properties): ModelDocGenerator
    {
        $this->properties = $properties;
        return $this;
    }

    public function setMethods(array $methods): ModelDocGenerator
    {
        $this->methods = $methods;
        return $this;
    }

    public function setDirs(array $dirs): ModelDocGenerator
    {
        $this->dirs = $dirs;
        return $this;
    }

    public function setReset($reset)
    {
        $this->reset = $reset;
        return $this;
    }

    public function setKeepText($keep_text)
    {
        $this->keep_text = $keep_text;
        return $this;
    }

    public function setNullableColumns(bool $nullableColumns): ModelDocGenerator
    {
        $this->nullableColumns = $nullableColumns;
        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return array<string,{type:string, comment:string, arguments: array}>
     */
    public function getMethods()
    {
        return $this->methods;
    }

}
