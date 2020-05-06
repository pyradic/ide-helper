<?php

namespace Pyro\IdeHelper\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;

class ResolveAllPermissions
{
    /**
     * @param \Illuminate\Contracts\Config\Repository         $config
     * @param \Anomaly\Streams\Platform\Addon\AddonCollection $addons
     * @param \Illuminate\Translation\Translator              $translator
     *
     * @return \Illuminate\Support\Collection
     */
    public function handle(
        Repository $config,
        AddonCollection $addons,
        Translator $translator)
    {

        $data       = collect();
        $namespaces = array_merge([ 'streams' ], $addons->withConfig('permissions')->namespaces());

        /*
         * gather all the addons with a
         * permissions configuration file.
         *
         * @var Addon $addon
         */
        foreach ($namespaces as $namespace) {
            foreach ($config->get($namespace . '::permissions', []) as $group => $permissions) {

                /*
                 * Determine the general
                 * form UI components.
                 */
                $label = $namespace . '::permission.' . $group . '.name';

                if ( ! $translator->has($warning = $namespace . '::permission.' . $group . '.warning')) {
                    $warning = null;
                }

                if ( ! $translator->has($instructions = $namespace . '::permission.' . $group . '.instructions')) {
                    $instructions = null;
                }

                /*
                 * Gather the available
                 * permissions for the group.
                 */
                $available = array_combine(
                    array_map(
                        function ($permission) use ($namespace, $group) {
                            return $namespace . '::' . $group . '.' . $permission;
                        },
                        $permissions
                    ),
                    array_map(
                        function ($permission) use ($namespace, $group) {
                            $value = $namespace . '::permission.' . $group . '.option.' . $permission;
                            $value = trans($value);
                            return $value;
                        },
                        $permissions
                    )
                );

                $path = null;
                if ($addon  = $addons->get($namespace)) {
                    $path = $addon->getPath('resources/config/permissions.php');
                } elseif ($namespace === 'streams') {
                    $path = 'vendor/anomaly/streams-platform/resources/config/permissions.php';
                }
                if ($path) {
                    $path = Str::removeLeft($path, base_path() . '/');
                    $path = Str::ensureLeft($path, 'file:///');
                }

                foreach ($available as $key => $text) {

                    $data->add([
                        'key'   => $key,
                        'label' => $label,
                        'text'  => $text,
                        'path'  => $path,
                        'addon' => $addon,
                    ]);
                }
            }
        }
        return $data;
    }
}
