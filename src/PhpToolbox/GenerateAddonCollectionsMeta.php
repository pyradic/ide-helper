<?php

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Laradic\Idea\Toolbox\AbstractToolboxGenerator;

class GenerateAddonCollectionsMeta extends AbstractToolboxGenerator
{

    public function handle(AddonCollection $addons, Filesystem $fs)
    {
        $data    = [
            'modules'    => [],
            'addons'     => [],
            'themes'     => [],
            'plugins'    => [],
            'extensions' => [],
        ];
        $classes = [
//            'addons' => AddonCollection::class,
            'modules'     => ModuleCollection::class,
            'themes'      => ThemeCollection::class,
            'plugins'     => PluginCollection::class,
            'field_types' => FieldTypeCollection::class,
            'extensions'  => ExtensionCollection::class,
        ];
        /** @var AddonCollection|\Anomaly\Streams\Platform\Addon\Addon[] $addons */
        foreach ($addons as $addon) {
            $type       = $addon->getType();
            $typePlural = Str::plural($type);
            if ( ! array_key_exists($typePlural, $classes)) {
                continue;
            }
            $class                 = get_class($addon);
            $data[ $typePlural ][] = [
                'lookup_string' => $addon->getNamespace(),
                'type'          => $classes[ $typePlural ],
                'target'        => $class,
                'type_text'     => $class,
                'icon'          => 'com.jetbrains.php.PhpIcons.CLASS',
                'tail_text'     => " {$type}",
            ];
        }

        foreach ($data as $name => $items) {
            $this->metadata()->push('providers', [
                'name'  => "pyro_{$name}",
                'items' => $items,
            ]);
        }
        foreach ($classes as $name => $class) {
            $this->metadata()->push('registrar', [
                "provider"   => "pyro_{$name}",
                "language"   => "php",
                "signature"  => [
                    "{$class}:get",
                ],
                "signatures" => [

                    [
                        "class"  => "{$class}",
                        "method" => "get",
                        "type"   => "type",
                    ],
                ],
            ]);
        }

        $this->metadata()->save();
    }
}
