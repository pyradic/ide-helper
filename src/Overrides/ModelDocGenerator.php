<?php

namespace Pyro\IdeHelper\Overrides;

use Pyro\IdeHelper\Console\IdeHelperModelsCommand;
use Symfony\Component\Console\Output\BufferedOutput;

class ModelDocGenerator extends IdeHelperModelsCommand
{
    public function generateForModel($class)
    {
        $this->output = new BufferedOutput();
        $this->laravel = app();
        return $this->generateDocs([$class]);
    }


    public function setWrite(bool $write)
    {
        $this->write=$write;
        return $this;
    }
}
