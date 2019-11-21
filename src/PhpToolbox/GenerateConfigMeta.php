<?php /** @noinspection SlowArrayOperationsInLoopInspection */

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laradic\Idea\PhpToolbox\Metadata;
use Laradic\Support\FS;

/*

"registrar":[
        {
            "provider": "pyro_config",
            "language": "php",
            "signatures": [
                {
                    "function": "route",
                    "type": "type"
                }
            ],
            "signature": [
                "route",
                "route:1"
            ]
        },
"providers":[
{
            "name": "pyro_config",
            "items":
 */

class GenerateConfigMeta
{
    use DispatchesJobs;

    protected $path;

    /** @var array */
    protected $excludes;

    protected $data;

    public function __construct($path = null, array $excludes = [])
    {
        if ($path === null) {

            $path = path_join(config('laradic.idea.toolbox.path'), 'pyro/config/.ide-toolbox.metadata.json');
        }
        $this->path     = $path;
        $this->excludes = $excludes;
        $this->data     = new Collection();
    }

    public function handle(Application $application, AddonCollection $addons)
    {

        // addons
        foreach ($addons as $addon) {
            /** @var \Anomaly\Streams\Platform\Addon\Addon $addon */
            $this->data = $this->data->merge(
                $this->getNamespacedConfigInfo($addon->getNamespace() . '::', [
                    $addon->getPath('resources/config'),
                    $application->getResourcesPath($addon->getAppPath('config')),
                ])
            );
        }

        // streams
        $this->data = $this->data->merge(
            $this->getNamespacedConfigInfo('streams::', [
                base_path('vendor/anomaly/streams-platform/resources/config'),
                $application->getResourcesPath('streams/config'),
                base_path('resources/streams/config'),
            ])
        );

        // exclude
        $this->data = $this->data->filter(function ($item) {
            foreach ($this->excludes as $exclude) {
                if (Str::is($exclude, $item[ 'lookup_string' ])) {
                    return false;
                }
            }
            return true;
        });

        $md = Metadata::create($this->path);
        $md->merge([
            'registrar' => [
                [
                    'provider'   => 'pyro_config',
                    'language'   => 'php',
                    'signatures' => [
                        [
                            'function' => 'config',
                            'type'     => 'type',
                        ],
                    ],
                    'signature'  => [
                        'config',
                        'config:1',
                    ],
                ],
            ],
            'providers' => [
                [
                    'name'  => 'pyro_config',
                    'items' => $this->data->values()->toArray(),
                ],
            ],
        ]);
        $md->save();
    }

    protected function getNamespacedConfigInfo(string $prefix, array $searchPaths)
    {
        $found = [];
        foreach ($searchPaths as $i => $path) {
            $files   = array_unique(FS::rglob(path_join($path, '**/*.php')));
            $files   = array_map(function ($configFile) use ($path) {
                return path_make_relative($configFile, $path);
            }, $files);
            $found[] = compact('path', 'files');
        }

        $found = collect($searchPaths)->map(function ($path) {
            $files = collect(FS::rglob(path_join($path, '**/*.php')))
                ->unique()
                ->map(function ($configFile) use ($path) {
                    return path_make_relative($configFile, $path);
                })
                ->toArray();
            return compact('path', 'files');
        });

        $infos = [];
        foreach ($found as $item) {
            $path = $item[ 'path' ];
            foreach ($item[ 'files' ] as $file) {
                $infos[ $file ] = compact('file', 'path');
            }
        }
        unset($item, $path, $file);

        foreach ($infos as &$info) {
            $segments   = explode('/', $info[ 'file' ]);
            $segments[] = path_get_filename_without_extension(array_pop($segments));
            $resolved   = $this->resolveConfig(require path_join($info[ 'path' ], $info[ 'file' ]), $prefix . implode('.', $segments));
            $slug       = $prefix;
            foreach ($segments as $i => $segment) {
                $slug              .= ($i === 0 ? $segment : '.' . $segment);
                $resolved[ $slug ] = [
                    'type'  => $i === 0 ? 'file' : 'array',
                    'key'   => $slug,
                    'value' => [],
                ];
            }
            $info[ 'resolved' ] = $resolved;
        }

        $items = [];
        foreach ($infos as $info) {
            $path          = path_join($info[ 'path' ], $info[ 'file' ]);
            $reslativePath = path_make_relative($path, base_path());
            foreach ($info[ 'resolved' ] as $resolved) {
                $isFile = $resolved[ 'type' ] === 'file';
                if ($isFile) {
                    $resolved[ 'type' ] = 'array';
                }
                $item = [
                    'lookup_string' => $resolved[ 'key' ],
                    'type_text'     => $resolved[ 'type' ],
                    'icon'          => 'com.jetbrains.php.PhpIcons.',
                    'target'        => 'file:///' . $reslativePath,
                ];
                if ($isFile) {
                    $item[ 'icon' ]      .= 'PHP_FILE';
                    $item[ 'tail_text' ] = ' file';
                } elseif ($resolved[ 'type' ] === 'array') {
                    $item[ 'icon' ] .= 'FUNCTION';
                    $item[ 'tail_text' ] = ' => [...]';
                } else {
                    $item[ 'icon' ] .= 'VARIABLE';
                    if ($resolved[ 'type' ] === 'bool') {
                        $item[ 'tail_text' ] = ' => ' . ($resolved[ 'value' ] === true ? 'true' : 'false');
                    } elseif ($resolved[ 'type' ] === 'int') {
                        $item[ 'tail_text' ] = ' => ' . $resolved[ 'value' ];
                    } elseif ($resolved[ 'type' ] === 'string') {
                        $item[ 'tail_text' ] = ' => \'' . Str::truncate($resolved[ 'value' ], 40, '..') . '\'';
                    }
                }

                $items[$item['lookup_string']] = $item;
            }
        }

        return array_values($items);
    }

    protected function resolveConfig($config, $prefix = '')
    {
        $resolved = [];
        foreach ($config as $key => $value) {
            if (is_int($key)) {
                continue;
            }
            $type = $this->getType($value);
            if (Str::endsWith($prefix, '::')) {
                $key = $prefix . $key;
            } else {
                $key = $prefix . '.' . $key;
            }

            $resolved[ $key ] = [
                'key'   => $key,
                'type'  => $type,
                'value' => $value,
            ];

            if (is_array($value)) {
                $resolved = array_merge($resolved, $this->resolveConfig($value, $key));
            }
        }
        return $resolved;
    }

    protected function getType($value)
    {
        if (is_array($value)) {
            return 'array';
        }
        if (is_string($value)) {
            return 'string';
        }
        if (is_bool($value)) {
            return 'bool';
        }
        if (is_int($value)) {
            return 'int';
        }
        return 'mixed';
    }

}