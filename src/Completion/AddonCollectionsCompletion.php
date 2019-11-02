<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\AddonsModule\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
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

    protected $exclude = [];

    public function __construct(array $exclude = [])
    {
        $this->exclude = $exclude;
    }

    public function generate(DocBlockGenerator $generator)
    {
        foreach (static::$items as $collection => $item) {
            with(new CollectionCompletion($collection, $item))->generate($generator);
        }
    }
}
