<?php

namespace Pyro\IdeHelper\Examples;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

class Examples
{
    public static function booleanCompletion()
    {
        return [
            /** type_text:"string", tail_text:"checkbox|toggle|radio|switch", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'mode'          => '',
            /** type_text:"string", tail_text:"The label text", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'label'         => '',
            /** type_text:"string", tail_text:"The text on displayed when using toggle or switch", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'on_text'       => '',
            /** type_text:"string", tail_text:"success|info|primary|warning", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'on_color'      => 'success',
            /** type_text:"string", tail_text:"The text on displayed when using toggle or switch", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'off_text'      => '',
            /** type_text:"string", tail_text:"success|info|primary|warning", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'off_color'     => 'danger',
            /** type_text:"bool", tail_text:"true|false", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'default_value' => false,
            /** type:"App\\BooleanHandler", type_text:"BooleanHandler", tail_text:"true|false", icon:"com.jetbrains.php.PhpIcons.FUNCTION" */
            'handler' => Examples::class,
        ];
    }

    /**
     * @param array $options = static::booleanCompletion()
     */
    public function setBoolean(array $options)
    {
    }

    /**
     * @return array = static::booleanCompletion()
     */
    public function getBoolean()
    {

    }

    public function handleBoolean()
    {
        $this->setBoolean([
            '<CARET>'
        ]);
        $boolean = $this->getBoolean();
        $boolean[ '<CARET>' ];
    }

    public static function addonType()
    {
        return [
            /** tail_text:"field type", type:"Anomaly\\CheckboxFieldType\\CheckboxFieldType", type_text:"CheckboxFieldType", icon:"com.jetbrains.php.PhpIcons.CLASS" */
            'anomaly.field_type.checkbox',
            /** tail_text:"module", type:"Anomaly\\UsersModule\\UsersModule", type_text:"UsersModule", icon:"com.jetbrains.php.PhpIcons.CLASS" */
            'anomaly.module.users',
        ];
    }

    /**
     * @param string $namespace = static::addonType()
     *
     * @return mixed
     */
    public function getAddon($namespace)
    {

    }

    public function handleAddon()
    {
        $this->getAddon('<CARET>');
        $module = $this->getAddon('anomaly.module.users'); // returns type Anomaly\UsersModule\UsersModule
        $module->foo(); // resolves properly to Anomaly\UsersModule\UsersModule->foo()
    }

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
