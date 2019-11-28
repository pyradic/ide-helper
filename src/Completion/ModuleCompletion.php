<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class ModuleCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(Module::class)
            ->properties([
                'sections'  => [ 'var', 'array = \\' . static::class . '::sections()' ],
                'shortcuts' => [ 'var', 'array = \\' . static::class . '::shortcuts()' ],
            ], true);
    }

    public static function sections()
    {
        return [
            null => [
                'slug'        => 'blocks',
                'permalink'   => '',
                'attributes'  => [],
                'title'       => '',
                'description' => '',
                'data-toggle' => 'modal',
                'data-target' => '#modal',
                'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',
                'href'        => 'admin/blocks/choose',
                'buttons'     => Examples::buttons(),
                'sections'    => [
                    null => [
                        'hidden'  => true,
                        'href'    => '',
                        'buttons' => Examples::buttons(),
                    ],
                ],
            ],
        ];
    }

    public static function shortcuts()
    {
        return [
            null => [
                'icon'  => 'fa fa-database',
                'href'  => '',
                'title' => '',
                'label' => '',
            ],
        ];
    }
}
