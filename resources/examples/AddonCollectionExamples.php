<?php

namespace Pyro\IdeHelper\Examples;

class AddonCollectionExamples
{
    public static function addonType()
    {
        return array_keys(self::addonTypeFqns());
    }

        public static function addonTypeFqns()
    {
        return [
            /** ['tail_text' => "field type", 'type_text' => "CheckboxesFieldType", 'icon' => "com.jetbrains.php.PhpIcons.CLASS" */
            'anomaly.extension.sitemap' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.module.settings' => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.preferences' => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.field_type.addon' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.field_type.boolean' => \Anomaly\BooleanFieldType\BooleanFieldTypePresenter::class,
            'anomaly.field_type.checkboxes' => \Anomaly\CheckboxesFieldType\CheckboxesFieldTypePresenter::class,
            'anomaly.field_type.colorpicker' => \Anomaly\ColorpickerFieldType\ColorpickerFieldTypePresenter::class,
            'anomaly.field_type.country' => \Anomaly\CountryFieldType\CountryFieldTypePresenter::class,
            'anomaly.field_type.datetime' => \Anomaly\DatetimeFieldType\DatetimeFieldTypePresenter::class,
            'anomaly.field_type.decimal' => \Anomaly\DecimalFieldType\DecimalFieldTypePresenter::class,
            'anomaly.field_type.editor' => \Anomaly\EditorFieldType\EditorFieldTypePresenter::class,
            'anomaly.field_type.email' => \Anomaly\EmailFieldType\EmailFieldTypePresenter::class,
            'anomaly.field_type.encrypted' => \Anomaly\EncryptedFieldType\EncryptedFieldTypePresenter::class,
            'anomaly.field_type.file' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.field_type.files' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.field_type.icon' => \Anomaly\IconFieldType\IconFieldTypePresenter::class,
            'anomaly.field_type.integer' => \Anomaly\IntegerFieldType\IntegerFieldTypePresenter::class,
            'anomaly.field_type.language' => \Anomaly\LanguageFieldType\LanguageFieldTypePresenter::class,
            'anomaly.field_type.markdown' => \Anomaly\MarkdownFieldType\MarkdownFieldTypePresenter::class,
            'anomaly.field_type.multiple' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.field_type.polymorphic' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.field_type.relationship' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.module.repeaters' => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.repeaters' => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.field_type.repeater' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.field_type.select' => \Anomaly\SelectFieldType\SelectFieldTypePresenter::class,
            'anomaly.field_type.slider' => \Anomaly\SliderFieldType\SliderFieldTypePresenter::class,
            'anomaly.field_type.slug' => \Anomaly\SlugFieldType\SlugFieldTypePresenter::class,
            'anomaly.field_type.state' => \Anomaly\StateFieldType\StateFieldTypePresenter::class,
            'anomaly.field_type.tags' => \Anomaly\TagsFieldType\TagsFieldTypePresenter::class,
            'anomaly.field_type.text' => \Anomaly\TextFieldType\TextFieldTypePresenter::class,
            'anomaly.field_type.textarea' => \Anomaly\TextareaFieldType\TextareaFieldTypePresenter::class,
            'anomaly.field_type.url' => \Anomaly\UrlFieldType\UrlFieldTypePresenter::class,
            'anomaly.field_type.wysiwyg' => \Anomaly\WysiwygFieldType\WysiwygFieldTypePresenter::class,
            'anomaly.extension.default_authenticator' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.default_page_handler' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.html_block' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.page_link_type' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.private_storage_adapter' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.robots'                  => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.throttle_security_check' => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.url_link_type'           => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.user_security_check'     => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.wysiwyg_block'           => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.extension.xml_feed_widget'         => \Anomaly\Streams\Platform\Addon\Extension\ExtensionPresenter::class,
            'anomaly.module.addons'                     => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.blocks'                     => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.field_type.blocks'                 => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter::class,
            'anomaly.module.configuration'              => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.dashboard'                  => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.files'                      => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.installer'                  => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.navigation'                 => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.posts'                      => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.search'                     => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.streams'                    => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.system'                     => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.users'                      => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.variables'                  => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'oaty.module.graphql'                       => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.plugin.contact'                    => \Anomaly\Streams\Platform\Addon\AddonPresenter::class,
            'anomaly.plugin.helper'                     => \Anomaly\Streams\Platform\Addon\AddonPresenter::class,
            'pyrocms.theme.accelerant'                  => \Anomaly\Streams\Platform\Addon\Theme\ThemePresenter::class,
            'pyrocms.theme.starter'                     => \Anomaly\Streams\Platform\Addon\Theme\ThemePresenter::class,
            'oaty.module.comments'                      => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'oaty.module.events'                        => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'oaty.module.forum'                         => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'oaty.theme.frontend'                       => \Anomaly\Streams\Platform\Addon\Theme\ThemePresenter::class,
            'oaty.module.platform'                      => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'oaty.module.playstation'                   => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.pages'                      => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
            'anomaly.module.redirects'                  => \Anomaly\Streams\Platform\Addon\Module\ModulePresenter::class,
        ];
    }
}
