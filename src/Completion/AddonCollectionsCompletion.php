<?php

namespace Pyro\IdeHelper\Completion;

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
use Laradic\Generators\Completion\CollectionCompletion;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\Platform\Addon\Theme\Theme;

class AddonCollectionsCompletion implements CompletionInterface
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
        [ 'name' => 'fieldType', 'collection' => FieldTypeCollection::class, 'item' => FieldType::class, ],
        [ 'name' => 'plugin', 'collection' => PluginCollection::class, 'item' => Plugin::class, ],
    ];

    protected $exclude = [];

    public function __construct(array $exclude = [])
    {
        $this->exclude = $exclude;
    }

    public function generate(DocBlockGenerator $generator)
    {
//        foreach (static::$items as $collection => $item) {
//            with(new CollectionCompletion($collection, $item, $this->exclude))->generate($generator);
//            $class = $generator->class($collection);
//            $class->ensureProperty()
//        }

        foreach(static::$data as $data){
            with(new CollectionCompletion($data['collection'], $data['item'], $this->exclude))->generate($generator);
            $class = $generator->class($data['collection']);
            foreach(static::$data as $item){
                $class->ensureProperty(Str::plural($item['name']), Str::ensureLeft($data['collection'],'\\'));
            }
            $class->method('get')->ensureParamTag('@param string $namespace = ' . \Pyro\IdeHelper\Examples\AddonCollectionExamples::class . '::addonType()[$any]');
        }

//        * @property \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection $extensions
//    * @property \Anomaly\Streams\Platform\Addon\Module\ModuleCollection $modules
//    * @property \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection $fieldTypes
//    * @property \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection $themes
//    * @property \Anomaly\Streams\Platform\Addon\Plugin\PluginCollection $plugins

    }
}
