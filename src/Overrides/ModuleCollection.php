<?php

namespace Pyro\IdeHelper\Overrides;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Illuminate\Support\Collection;

class ModuleCollection extends Collection
{
    /**
     * @param mixed $key
     * @param null  $default
     *
     * @return \Anomaly\Streams\Platform\Addon\Module\Module|mixed|null
     */
    public function get($key, $default = null)
    {
        if (!$key) {
            return $default;
        }

        if (!$addon = parent::get($key, $default)) {
            return $this->findBySlug($key);
        }

        if(!$addon instanceof Module){
            return $default;
        }

        return $addon;
    }

}
