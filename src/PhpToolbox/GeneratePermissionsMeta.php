<?php

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Support\Authorizer;
use Illuminate\Contracts\Config\Repository;
use Laradic\Idea\PhpToolbox\Metadata;
use Pyro\IdeHelper\Command\ResolveAllPermissions;

class GeneratePermissionsMeta
{

    protected $path;

    public function __construct($path = null)
    {
        if ($path === null) {
            $path = path_join(config('laradic.idea.toolbox.path'), 'pyro/permissions/.ide-toolbox.metadata.json');
        }
        $this->path = $path;
    }

    public function handle()
    {

        /** @var \Illuminate\Support\Collection $permissions */
        $permissions = dispatch_now(new ResolveAllPermissions());
        $data        = $permissions->map(function ($p) {
            $text = $p[ 'text' ];
            if (trans()->has($p[ 'label' ])) {
                $text = trans($p[ 'label' ]) . ' ' . $text;
            }
            return [
                'lookup_string' => $p[ 'key' ],
                'icon'          => 'com.jetbrains.php.PhpIcons.VARIABLE',
                'target'        => $p[ 'path' ],
                'type'          => 'boolean',
                'type_text'     => '  ' . $text,
            ];
        });
        $md          = Metadata::create($this->path);
        $md->merge([
            'registrar' => [
                [
                    'provider'   => 'pyro_permissions',
                    'language'   => 'php',
                    'signatures' => [
                        [
                            'class'  => Repository::class,
                            'method' => 'authorize',
                            'type'   => 'type',
                        ],
                    ],
                    'signature'  => [
                        Authorizer::class . ':authorize',
                    ],
                ],
            ],
            'providers' => [
                [
                    'name'  => 'pyro_permissions',
                    'items' => $data->values()->toArray(),
                ],
            ],
        ]);
        $md->save();
    }
}
