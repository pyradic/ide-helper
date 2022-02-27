<?php

namespace Pyro\IdeHelper\Examples;

class ModuleExamples
{

    public static function sections()
    {
        return [
            null => static::section(),
        ];
    }

    public static function section()
    {
        $section = IconExamples::mergeWith([
            'slug'        => 'blocks',
            'permalink'   => '',
            'attributes'  => [],
            'title'       => '',
            'description' => '',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',
            'href'        => '',
            'icon'        => Examples::icon(),
            'buttons'     => Examples::buttons(),
            'sections'    => [
                null => [
                    'hidden'  => true,
                    'href'    => '',
                    'buttons' => Examples::buttons(),
                ],
            ],
        ]);
        foreach (RoutesExamples::uris() as $uri) {
            $section[ 'href' ] = $uri;
        }
        return $section;
    }

    public static function shortcuts()
    {
        return [
            null => static::shortcut(),
        ];
    }

    public static function shortcut()
    {
        return [
            'icon'  => 'fa fa-database',
            'href'  => RoutesExamples::uris(),
            'title' => '',
            'label' => '',
        ];
    }
}
