<?php

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Support\Authorizer;
use Illuminate\Contracts\Config\Repository;
use Laradic\Idea\Toolbox\AbstractToolboxGenerator;
use Pyro\IdeHelper\Command\ResolveAllPermissions;

class GeneratePermissionsMeta extends AbstractToolboxGenerator
{

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
        $this->metadata()
            ->merge([
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
            ])
            ->save();
    }
}
