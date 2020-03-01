<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Support\Str;
use Laradic\Generators\Doc\Block\CollectionDocBlock;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\Platform\Addon\Theme\Theme;

class AddonCollectionDocBlocks
{
    public static $items = [
        AddonCollection::class     => Addon::class,
        ModuleCollection::class    => Module::class,
        ThemeCollection::class     => Theme::class,
        ExtensionCollection::class => Extension::class,
        FieldTypeCollection::class => FieldType::class,
        PluginCollection::class    => Plugin::class,
    ];

    public static $data = [
        [ 'name' => 'addon', 'collection' => AddonCollection::class, 'item' => Addon::class, ],
        [ 'name' => 'module', 'collection' => ModuleCollection::class, 'item' => Module::class, ],
        [ 'name' => 'theme', 'collection' => ThemeCollection::class, 'item' => Theme::class, ],
        [ 'name' => 'extension', 'collection' => ExtensionCollection::class, 'item' => Extension::class, ],
        [ 'name' => 'field_type', 'collection' => FieldTypeCollection::class, 'item' => FieldType::class, ],
        [ 'name' => 'plugin', 'collection' => PluginCollection::class, 'item' => Plugin::class, ],
    ];

    public function handle(DocRegistry $registry)
    {

        foreach (static::$data as $data) {
            $cd = $registry->getClass($data[ 'collection' ]);
            $cd->cleanTag('property');
            (new CollectionDocBlock($data[ 'collection' ], $data[ 'item' ], []))
                ->generate($registry);

            foreach (static::$data as $item) {
                $cd->ensureProperty(
                    Str::plural($item[ 'name' ]),
                    [$item[ 'collection' ], $item[ 'item' ] . '[]']
                );
            }
            $cd->getMethod('get')->ensureParam('$namespace', 'string', ' = ' . \Pyro\IdeHelper\Examples\AddonCollectionExamples::class . '::addonType()[$any]');
        }
    }

}
