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
        \$settings = [
            null => [
                /** A .env key */
                'env'         => 'ENV_KEY',
                'placeholder' => false,
                'required'    => true,
                /** A configuration key */
                'bind'        => '{vendor}.{addonType}.{name}::{configFile}.{dotKey}',
                'bind'        => 'example.module.forum::discussions.allowed',
            ],
        ];
        return array_merge(\$settings, \Pyro\IdeHelper\Examples\FieldTypeExamples::values());
    }
}
EOF;

        $this->write($result);

        return $result;
    }
}
