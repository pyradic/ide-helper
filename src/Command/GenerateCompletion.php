<?php

namespace Pyradic\IdeHelper\Command;

use Laradic\Idea\GeneratedCompletion;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Entry\EntryModel;

class GenerateCompletion
{
    use DispatchesJobs;

    protected $toFile;

    public function __construct($toFile)
    {
        $this->toFile = $toFile;
    }


    public function handle()
    {
        $model       = resolve(GenerateModelCompletion::class);
        $processed   = $this->dispatchNow(new ProcessAllStreams());
        $processed[] = $this->dispatchNow(new ProcessAddonServiceProvider());

        foreach ($processed as $result) {
            /** @var \Laradic\Generators\DocBlock\Result $result */
            if ($result->getClass()->isSubclassOf(EntryModel::class)) {
                $output = $model->generateForModel($result->getClass()->getName());
                preg_match_all('/\/\*\*[\w\W]*?\*\//', $output, $matches);
                $result->setDoc(last($matches[0]));
            }
        }

        $generated = new GeneratedCompletion($processed);

        if ($this->toFile === false) {
            $generated->writeToSourceFiles();
        } else {
            $content = $generated->combineForCompletionFile();
            $path    = path_is_relative($this->toFile) ? base_path($this->toFile) : $this->toFile;
            file_put_contents($path, $content, LOCK_EX);
        }
    }
}
