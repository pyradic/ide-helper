<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Laradic\Idea\Command\FindAllViews;
use Pyro\IdeHelper\Examples\ConfigExamples;
use Pyro\IdeHelper\Examples\FormBuilderExamples;

class GenerateViewExamples extends AbstractGenerator
{
    public function handle()
    {
        /** @var array<array{view:string, namespace:string, file:\SplFileInfo, path:string, directory:string, pathName:string, type:string}> $views */
        $views     = dispatch_now(new FindAllViews([]));
        $viewNames = array_map(fn($view) => "'" . $view[ 'view' ] . "',", $views->all());
        $viewNames = implode(PHP_EOL, $viewNames);

        $result = <<<EOF
<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class ViewExamples
{
    public static function names()
    {
        return [
        {$viewNames}
        ]
    }

    public static function views(){
        return array_combine(static::names(), static::names());
    }
}
EOF;

        $this->write($result);

        return $result;
    }
}
