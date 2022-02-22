<?php

namespace Pyro\IdeHelper\Metas;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Decorator;
use Illuminate\Support\Str;
use Laradic\Idea\Metas\MetaInterface;
use Laradic\Idea\Metas\MetaOptions;

class AddonsMeta implements MetaInterface
{

    protected $lines = [];

    /**
     * @var \Laradic\Idea\Metas\MetaOptions
     */
    protected $options;

    /** @var \Anomaly\Streams\Platform\Addon\AddonCollection */
    protected $addons;

    public function __construct(AddonCollection $addons, ModuleCollection $modules)
    {
        $this->addons = $addons;
    }

    public function name()
    {
        return 'pyro-addons';
    }

    public function generate(MetaOptions $options)
    {

        $this->options = $options;
        $types         = [ 'module', 'extension', 'plugin', 'theme', 'field_type' ];
        foreach($types as $type){
            $overrides = $this->getOverridesForType($type);
            foreach($overrides as $key => $value){
                $this->line("override({$key}, map([\n{$value}\n]));");
            }
        }
        return implode("\n", $this->lines);
    }

    protected function line($content)
    {
        $this->lines[] = $content;
    }

    protected function getOverridesForType($type = null)
    {
        $class = Str::ensureLeft(get_class($type === null ? $this->addons : $this->addons->{$type}), '\\');
        $items = $this->getItemsForType($type);
        $items = $items->transform(function($value, $key){
            return $key . ' => ' . $value;
        })->implode(",\n");
        $overrides = [
            'new ' . $class => $items,
            $class.'::get(0)' => $items,
        ];

        return $overrides;
    }

    protected function getItemsForType($type = null)
    {
        /** @var AddonCollection|\Anomaly\Streams\Platform\Addon\Addon[] $collection */
        $collection = $type === null ? $this->addons : $this->addons->{$type};
        $collection =collect($collection->namespaces())->sort()->mapWithKeys(function($namespace){
            return [$namespace => $this->addons->get($namespace)];
        });
        $items      = [ "''" => "'@'" ];
        $decorator  = new Decorator();
        foreach ($collection as $addon) {
            $addon                                 = $decorator->undecorate($addon);
            $items[ "'{$addon->getNamespace()}'" ] = Str::ensureLeft(get_class($addon), '\\') . '::class';
        }
        return collect($items);
    }

    protected function recurse(array $items, string $prefix = '', array $result = [])
    {
        foreach ($items as $key => $value) {
            if (is_numeric($key) && $this->options[ 'skip_lists' ]) {
                continue;
            }
            $result[] = $prefix . $key;
            if (is_array($value)) {
                $result = $this->recurse($value, $prefix . $key . '.', $result);
            }
        }
        return $result;
    }
}
