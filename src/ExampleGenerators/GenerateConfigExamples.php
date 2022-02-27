<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class GenerateConfigExamples extends AbstractGenerator
{
    public function handle(Repository $config, Application $application, AddonCollection $addons, Filesystem $fs)
    {
        $items  = array_keys(Arr::dot($config->all()));
        $keys   = implode(PHP_EOL, array_map(fn($key) => "'{$key}',", $items));
        $values = implode(PHP_EOL, array_map(fn($key) => "null => '{$key}',", $items));

        $result = <<<EOF
<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class ConfigExamples
{
    public static function keys()
    {
        return [
        {$keys}
        ];
    }
    public static function values()
    {
        return [
        {$values}
        ];
    }
}
EOF;

        $this->write($result);

        return $result;
    }
}
