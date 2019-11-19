<?php

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Laradic\Idea\PhpToolbox\Metadata;

class GenerateToolboxAddonCollections
{
    protected $path;

    public function __construct($path = null)
    {
        if($path === null){
            $path = base_path('php-toolbox/pyro-addon-collection/.ide-toolbox.metadata.json');
        }
        $this->path = $path;
    }

    public function handle(AddonCollection $addons, Filesystem $fs)
    {
        $fs->ensureDirectory(path_get_directory($this->path));

        $meta = Metadata::create($this->path);
        $data = [
            'modules'    => [],
            'addons'     => [],
            'themes'     => [],
            'plugins'    => [],
            'extensions' => [],
        ];
        $classes = [
            'modules'    => ModuleCollection::class,
            'addons'     => AddonCollection::class,
            'themes'     => ThemeCollection::class,
            'plugins'    => PluginCollection::class,
            'extensions' => ExtensionCollection::class,
        ];
        /** @var AddonCollection|\Anomaly\Streams\Platform\Addon\Addon[] $addons */
        foreach ($addons as $addon) {
            $type               = $addon->getType();
            $typePlural         = Str::plural($type);
            $class              = get_class($addon);
            $data[ 'addons' ][] = $data[ $typePlural ][] = [
                'lookup_string' => $addon->getNamespace(),
                'type'          => $class,
                'target'        => $class,
                'type_text'     => $class,
                'icon'          => 'com.jetbrains.php.PhpIcons.CLASS',
                'tail_text'     => " {$type}",
            ];
        }

        foreach ($data as $name => $items) {
            $meta->push('providers', [
                'name'  => "pyro_{$name}",
                'items' => $items,
            ]);
        }
        foreach($classes as $name => $class){
            $meta->push('registrar', [
                "provider"   => "pyro_{$name}",
                "language"   => "php",
                "signature"  => [
                    "{$class}::get",
                ],
                "signatures" => [

                    [
                        "class"  => "{$class}",
                        "method" => "get",
                        "type"   => "type",
                    ],
                ]
            ]);
        }


        $meta->save();
    }
}
