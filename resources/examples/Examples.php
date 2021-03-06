<?php

namespace Pyro\IdeHelper\Examples;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;
use Pyro\IdeHelper\DocBlocks\AddonCollectionDocBlocks;
use Pyro\IdeHelper\DocBlocks\AddonServiceProviderDocBlocks;
use Pyro\IdeHelper\DocBlocks\AuthDocBlocks;
use Pyro\IdeHelper\DocBlocks\ControlPanelDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryDomainsDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryModelDocBlocks;
use Pyro\IdeHelper\DocBlocks\ExtensionDocBlocks;
use Pyro\IdeHelper\DocBlocks\FieldTypeDocBlocks;
use Pyro\IdeHelper\DocBlocks\FormBuilderDocBlocks;
use Pyro\IdeHelper\DocBlocks\MigrationDocBlocks;
use Pyro\IdeHelper\DocBlocks\ModuleDocBlocks;
use Pyro\IdeHelper\DocBlocks\RequestDocBlocks;
use Pyro\IdeHelper\DocBlocks\TableBuilderDocBlocks;

class Examples
{
    public static function settings()
    {
        $field           = FormBuilderExamples::field();
        $field[ 'env' ]  = 'SOME_DOTENV_NAME';
        $field[ 'bind' ] = 'vendor.module.name::some.config.key';
        return [ null => $field ];
    }

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
            'handler'       => Examples::class,
        ];
    }

    public static function config()
    {
        return [
            'docblock' => [
                'docblocks' => [

                    AddonCollectionDocBlocks::class,
                    AddonServiceProviderDocBlocks::class,
                    AuthDocBlocks::class,
                    new EntryDomainsDocBlocks(),
                    EntryModelDocBlocks::class,
                    FieldTypeDocBlocks::class,
                    FormBuilderDocBlocks::class,
                    MigrationDocBlocks::class,
                    ExtensionDocBlocks::class,
                    ModuleDocBlocks::class,
                    RequestDocBlocks::class,
                    ControlPanelDocBlocks::class,
                    TableBuilderDocBlocks::class,
                ],
            ],
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
            '<CARET>',
        ]);
        $boolean = $this->getBoolean();
        $boolean[ '<CARET>' ];
    }

    public static function addonTypeFqns()
    {
        return [
            /** ['tail_text' => "field type", 'type_text' => "CheckboxesFieldType", 'icon' => "com.jetbrains.php.PhpIcons.CLASS" */
            'anomaly.field_type.checkbox' => \Anomaly\CheckboxesFieldType\CheckboxesFieldType::class,
            'anomaly.module.users'        => \Anomaly\UsersModule\UsersModule::class,
        ];
    }

    public static function addonType()
    {
        return array_keys(self::addonTypeFqns());
    }

    /**
     * @param string $namespace = static::addonType()[$any]
     *
     * @return object = new (self::addonTypeFqns()[$namespace])
     */
    public function getAddon($namespace)
    {

    }

    public function handleAddon()
    {
        $module = $this->getAddon('anomaly.module.users');
        $module->onRegistered();
        $fieldType = $this->getAddon('anomaly.field_type.checkbox');
        $module->foo(); // resolves properly to Anomaly\UsersModule\UsersModule->foo()
    }

    public static function button()
    {
        $button = [
            'slug'        => 'blocks',
            'data-toggle' => 'modal',
            'data-toggle' => 'confirm',
            'data-toggle' => 'process',
            'data-toggle' => 'tooltip',

            'data-icon' => 'info',
            'data-icon' => 'warning',

            'data-target' => '#modal',
            'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',

            'data-title'   => 'anomaly.module.addons::confirm.disable_title',
            'data-message' => 'anomaly.module.addons::confirm.disable_message',
            'data-message' => 'Updating Repositories',

            'button' => '',

            'type'       => 'danger',
            'type'       => 'warning',
            'type'       => 'success',
            'type'       => 'info',
            'type'       => 'primary',
            'type'       => 'secondary',
            'icon'       => static::icon(),
            'text'       => '',
            'permission' => '',
            'href'       => 'admin/addons/disable/{entry.namespace}',

            'enabled' => 'admin/dashboard/view/*',
            'href'    => 'admin/blocks/areas/{request.route.parameters.area}/choose',
        ];

        $button = IconExamples::addTo($button);

        return $button;
    }

    public static function buttons()
    {
        $buttons         = (new \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry())->getButtons();
        $buttons[ null ] = static::button();
        return $buttons;
    }

    public static function icon()
    {
        $icons         = (new IconRegistry)->getIcons();
        $icons[ null ] = '';
        return $icons;
    }

    /**
     * @param array $rr = static::button()
     *
     * @return void
     */
    public function sadf($rr)
    {
        /** @noinspection InfinityLoopInspection */
        $this->sadf([
            'success' => [ 'icon' ],
            'icon'    => '',
        ]);
    }
}
