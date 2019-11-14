<?php

namespace Pyro\IdeHelper\Completion;
use Illuminate\Support\Arr;

/**
 *
 * @property string $asdf
 */
class Common
{
    public static function get($keys)
    {
        $keys = Arr::wrap($keys);
        $result = [];
        foreach($keys as $key){
            if(method_exists(static::class,$key)){
                $result[] = forward_static_call([static::class, $key]);
            } elseif(property_exists(static::class, $key)){
                $result[] = static::$$key;
            }
        }
        return $result;
    }


    public static $button = <<<DOC
[
    'slug'        => 'blocks',
    'data-toggle' => 'modal',
    'data-toggle'  => 'confirm',
    'data-toggle'  => 'process',

    'data-icon'    => 'info',
    'data-icon'    => 'warning',
    
    'data-target' => '#modal',
    'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',
    
    'data-title'   => 'anomaly.module.addons::confirm.disable_title',
    'data-message' => 'anomaly.module.addons::confirm.disable_message',
    'data-message' => 'Updating Repositories',
    
    'button'       => '',
    
    
    'type'         => 'warning',
    'icon'         => 'fa fa-toggle-off',
    'text'         => '',
    'permission'   => '',
    'href'         => 'admin/addons/disable/{entry.namespace}',
    
    'enabled'     => 'admin/dashboard/view/*',
    'href'        => 'admin/blocks/areas/{request.route.parameters.area}/choose',
]
DOC;

    public static $moduleShortcut = <<<DOC
[
    'icon'  => 'fa fa-database',
    'href'  => '',
    'title' => '',
    'label' => '',
 ]
DOC;

    public static function moduleSection()
    {
        $button = static::$button;
        return <<<DOC
[
    'slug'        => 'blocks',
    'permalink'   => '',
    'attributes'  => [],
    'title'       => '',
    'description' => '',
    'data-toggle' => 'modal',
    'data-target' => '#modal',
    'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',
    'href'        => 'admin/blocks/choose',
    'buttons' => [
        '',
        \$button => {$button},
    ],
    
    'sections' => [
        \$section => [
            'hidden'  => true,
            'href'    => '',
            'buttons' => [
                '',
                \$button => {$button},
            ],
        ],
    ],
],
DOC;

    }


    public static function formSection()
    {
        $rows = <<<DOC
[
    [ 
        'columns' =>[ 
             [
                'classes' => '',
                'size' => 24,
                'fields' => [],
                'html' => '',
                'view' => ''
            ]
        ]
    ]
],
DOC;
        $tabs = <<<DOC
[
    \$tab => [
        'title'  => '',
        'fields' => [],
        'icon' => '',
        'html' => '',
        'view' => '',
        'rows' => {$rows},
    ],
]
DOC;
        $formSectionStart = <<<DOC
        'view' => '',
        'html' => '',
        'stacked' => true, 
        'fields' => [],
        'attributes' => [],
        'rows' => {$rows},
        'tabs' => {$tabs},
DOC;

        $groups = <<<DOC
[
     [
        {$formSectionStart}
        'groups' => [],
     ]  
]
DOC;


        $formSection = <<<DOC
[     
        {$formSectionStart}
        'groups' => {$groups},
]
DOC;

        return $formSection;
    }



}
