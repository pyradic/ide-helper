<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Pyro\IdeHelper\Examples\ConfigExamples;
use Pyro\IdeHelper\Examples\FormBuilderExamples;

class GenerateSettingsExamples extends AbstractGenerator
{
    public function handle(Repository $config)
    {
        $items = array_keys(Arr::dot($config->all()));
        $binds = '';
        foreach ($items as $key) {
            $binds .= "'bind' => '{$key}'," . PHP_EOL;
        }
        $result = <<<EOF
<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class SettingsExamples
{
    public static function sections(\$section = null, \$tab = null)
    {
        return FormBuilderExamples::sections();
    }

    public static function settings()
    {
        \$settings = [];
        foreach (\Pyro\IdeHelper\Examples\FieldTypeExamples::values() as \$key => \$value) {
            \$settings[ \$key ] = array_merge(\$value,  [
                /** A .env key */
                'env'         => 'ENV_KEY',
                'placeholder' => false,
                'required'    => true,
                /** A configuration key */
                'bind'        => '{vendor}.{addonType}.{name}::{configFile}.{dotKey}',
                'bind'        => 'example.module.forum::discussions.allowed',
                {$binds}
            ]);
        }
        return \$settings;
    }
}
EOF;

        $this->write($result);

        return $result;
    }
}
