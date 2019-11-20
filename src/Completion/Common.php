<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Edit;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Export;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\ForceDelete;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Reorder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\All;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\RecentlyCreated;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\RecentlyModified;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\Trash;
use Illuminate\Support\Arr;

/**
 *
 * @property string $asdf
 */
class Common
{
    public static function get($keys)
    {
        $keys   = Arr::wrap($keys);
        $result = [];
        foreach ($keys as $key) {
            if (method_exists(static::class, $key)) {
                $result[] = forward_static_call([ static::class, $key ]);
            } elseif (property_exists(static::class, $key)) {
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

    public static function buttonKeys()
    {
        return array_keys(resolve(\Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class)->getButtons());
    }

    public static function buttons()
    {

        $buttons = var_export(array_merge(resolve(\Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class)->getButtons(), [
            '$button' => '$BTN$'
        ]),true);
        $button = <<<DOC
[
        'slug'        => 'blocks',
        'data-toggle' => 'modal',
        'data-toggle' => 'confirm',
        'data-toggle' => 'process',

        'data-icon' => 'info',
        'data-icon' => 'warning',

        'data-target' => '#modal',
        'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',

        'data-title'   => 'anomaly.module.addons::confirm.disable_title',
        'data-message' => 'anomaly.module.addons::confirm.disable_message',
        'data-message' => 'Updating Repositories',

        'button' => '',

        'type'       => 'warning',
        'icon'       => 'fa fa-toggle-off',
        'text'       => '',
        'permission' => '',
        'href'       => 'admin/addons/disable/{entry.namespace}',

        'enabled' => 'admin/dashboard/view/*',
        'href'    => 'admin/blocks/areas/{request.route.parameters.area}/choose',
    ]
DOC;

        $buttons= str_replace([ "'\$button'", "'\$BTN$'" ], [ '\\$button', $button ], $buttons);

        return $buttons;
    }

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
        $buttons = Common::buttons();
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
    'buttons' => {$buttons},    
    'sections' => [
        \$section => [
            'hidden'  => true,
            'href'    => '',
            'buttons' => {$buttons}
        ],
    ],
],
DOC;
    }

    public static function formSection()
    {
        $rows             = <<<DOC
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
        $tabs             = <<<DOC
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
