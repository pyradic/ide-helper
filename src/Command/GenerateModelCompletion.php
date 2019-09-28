<?php

namespace Pyradic\IdeHelper\Command;

use Pyradic\Platform\Console\IdeHelperModelsCommand;
use Symfony\Component\Console\Output\BufferedOutput;

class GenerateModelCompletion extends IdeHelperModelsCommand
{
    public function generateForModel($class)
    {
        $this->output = new BufferedOutput();
        $this->laravel = app();
        return $this->generateDocs([$class]);
    }


}
