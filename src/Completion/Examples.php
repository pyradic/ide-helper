<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

class Examples
{
    public static function button()
    {
        return [
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
            'icon'         => static::icon(),
            'text'         => '',
            'permission'   => '',
            'href'         => 'admin/addons/disable/{entry.namespace}',

            'enabled'     => 'admin/dashboard/view/*',
            'href'        => 'admin/blocks/areas/{request.route.parameters.area}/choose',
        ];
    }

    public static function buttons()
    {
        $buttons = (new \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry())->getButtons();
        $buttons[null]=static::button();
        return $buttons;
    }

    public static function icon()
    {
        $icons=(new IconRegistry)->getIcons();
        $icons[null]='';
        return $icons;
    }


    /**
     * @param array $rr = static::buttons()
     *
     * @return void
     */
    public function sadf($rr)
    {
        /** @noinspection InfinityLoopInspection */
        $this->sadf([
            'success'=>['icon']
        ]);
    }
}
