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
            'anomaly.module.settings'                   => \Anomaly\SettingsModule\SettingsModule::class,
            'anomaly.module.preferences'                => \Anomaly\PreferencesModule\PreferencesModule::class,
            'anomaly.field_type.addon'                  => \Anomaly\AddonFieldType\AddonFieldType::class,
            'anomaly.module.blocks'                     => \Anomaly\BlocksModule\BlocksModule::class,
            'anomaly.field_type.blocks'                 => \Anomaly\BlocksFieldType\BlocksFieldType::class,
            'anomaly.field_type.boolean'                => \Anomaly\BooleanFieldType\BooleanFieldType::class,
            'anomaly.field_type.checkboxes'             => \Anomaly\CheckboxesFieldType\CheckboxesFieldType::class,
            'anomaly.field_type.colorpicker'            => \Anomaly\ColorpickerFieldType\ColorpickerFieldType::class,
            'anomaly.module.configuration'              => \Anomaly\ConfigurationModule\ConfigurationModule::class,
            'anomaly.plugin.contact'                    => \Anomaly\ContactPlugin\ContactPlugin::class,
            'anomaly.field_type.country'                => \Anomaly\CountryFieldType\CountryFieldType::class,
            'anomaly.module.dashboard'                  => \Anomaly\DashboardModule\DashboardModule::class,
            'anomaly.field_type.datetime'               => \Anomaly\DatetimeFieldType\DatetimeFieldType::class,
            'anomaly.field_type.decimal'                => \Anomaly\DecimalFieldType\DecimalFieldType::class,
            'anomaly.extension.default_authenticator'   => \Anomaly\DefaultAuthenticatorExtension\DefaultAuthenticatorExtension::class,
            'anomaly.extension.default_page_handler'    => \Anomaly\DefaultPageHandlerExtension\DefaultPageHandlerExtension::class,
            'anomaly.field_type.editor'                 => \Anomaly\EditorFieldType\EditorFieldType::class,
            'anomaly.field_type.email'                  => \Anomaly\EmailFieldType\EmailFieldType::class,
            'anomaly.field_type.encrypted'              => \Anomaly\EncryptedFieldType\EncryptedFieldType::class,
            'anomaly.field_type.file'                   => \Anomaly\FileFieldType\FileFieldType::class,
            'anomaly.module.files'                      => \Anomaly\FilesModule\FilesModule::class,
            'anomaly.module.grids'                      => \Anomaly\GridsModule\GridsModule::class,
            'anomaly.module.grids'                      => \Anomaly\GridsModule\GridsModule::class,
            'anomaly.field_type.grid'                   => \Anomaly\GridFieldType\GridFieldType::class,
            'anomaly.plugin.helper'                     => \Anomaly\HelperPlugin\HelperPlugin::class,
            'anomaly.extension.html_block'              => \Anomaly\HtmlBlockExtension\HtmlBlockExtension::class,
            'anomaly.field_type.icon'                   => \Anomaly\IconFieldType\IconFieldType::class,
            'anomaly.module.installer'                  => \Anomaly\InstallerModule\InstallerModule::class,
            'anomaly.field_type.integer'                => \Anomaly\IntegerFieldType\IntegerFieldType::class,
            'anomaly.field_type.language'               => \Anomaly\LanguageFieldType\LanguageFieldType::class,
            'anomaly.field_type.markdown'               => \Anomaly\MarkdownFieldType\MarkdownFieldType::class,
            'anomaly.field_type.multiple'               => \Anomaly\MultipleFieldType\MultipleFieldType::class,
            'anomaly.module.navigation'                 => \Anomaly\NavigationModule\NavigationModule::class,
            'anomaly.extension.page_link_type'          => \Anomaly\PageLinkTypeExtension\PageLinkTypeExtension::class,
            'anomaly.module.pages'                      => \Anomaly\PagesModule\PagesModule::class,
            'anomaly.field_type.polymorphic'            => \Anomaly\PolymorphicFieldType\PolymorphicFieldType::class,
            'anomaly.extension.private_storage_adapter' => \Anomaly\PrivateStorageAdapterExtension\PrivateStorageAdapterExtension::class,
            'anomaly.module.redirects'                  => \Anomaly\RedirectsModule\RedirectsModule::class,
            'anomaly.field_type.relationship'           => \Anomaly\RelationshipFieldType\RelationshipFieldType::class,
            'anomaly.module.repeaters'                  => \Anomaly\RepeatersModule\RepeatersModule::class,
            'anomaly.module.repeaters'                  => \Anomaly\RepeatersModule\RepeatersModule::class,
            'anomaly.field_type.repeater'               => \Anomaly\RepeaterFieldType\RepeaterFieldType::class,
            'anomaly.extension.robots'                  => \Anomaly\RobotsExtension\RobotsExtension::class,
            'anomaly.module.search'                     => \Anomaly\SearchModule\SearchModule::class,
            'anomaly.field_type.select'                 => \Anomaly\SelectFieldType\SelectFieldType::class,
            'anomaly.extension.sitemap'                 => \Anomaly\SitemapExtension\SitemapExtension::class,
            'anomaly.field_type.slider'                 => \Anomaly\SliderFieldType\SliderFieldType::class,
            'anomaly.field_type.slug'                   => \Anomaly\SlugFieldType\SlugFieldType::class,
            'anomaly.field_type.state'                  => \Anomaly\StateFieldType\StateFieldType::class,
            'anomaly.field_type.tags'                   => \Anomaly\TagsFieldType\TagsFieldType::class,
            'anomaly.field_type.text'                   => \Anomaly\TextFieldType\TextFieldType::class,
            'anomaly.field_type.textarea'               => \Anomaly\TextareaFieldType\TextareaFieldType::class,
            'anomaly.extension.throttle_security_check' => \Anomaly\ThrottleSecurityCheckExtension\ThrottleSecurityCheckExtension::class,
            'anomaly.field_type.upload'                 => \Anomaly\UploadFieldType\UploadFieldType::class,
            'anomaly.field_type.url'                    => \Anomaly\UrlFieldType\UrlFieldType::class,
            'anomaly.extension.url_link_type'           => \Anomaly\UrlLinkTypeExtension\UrlLinkTypeExtension::class,
            'anomaly.extension.user_security_check'     => \Anomaly\UserSecurityCheckExtension\UserSecurityCheckExtension::class,
            'anomaly.module.users'                      => \Anomaly\UsersModule\UsersModule::class,
            'anomaly.field_type.wysiwyg'                => \Anomaly\WysiwygFieldType\WysiwygFieldType::class,
            'anomaly.extension.wysiwyg_block'           => \Anomaly\WysiwygBlockExtension\WysiwygBlockExtension::class,
            'anomaly.extension.xml_feed_widget'         => \Anomaly\XmlFeedWidgetExtension\XmlFeedWidgetExtension::class,
            'crvs.module.core'                          => \Crvs\CoreModule\CoreModule::class,
            'crvs.theme.frontend'                       => \Crvs\FrontendTheme\FrontendTheme::class,
            'pyrocms.theme.accelerant'                  => \Pyrocms\AccelerantTheme\AccelerantTheme::class,
            'pyrocms.theme.starter'                     => \Pyrocms\StarterTheme\StarterTheme::class,
            'crvs.theme.admin'                          => \Crvs\AdminTheme\AdminTheme::class,
            'crvs.extension.direct_admin_server_type'   => \Crvs\DirectAdminServerTypeExtension\DirectAdminServerTypeExtension::class,
            'crvs.extension.direct_admin_server_type'   => \Crvs\DirectAdminServerTypeExtension\DirectAdminServerTypeExtension::class,
            'crvs.extension.bitbucket_team_type'        => \Crvs\BitbucketTeamTypeExtension\BitbucketTeamTypeExtension::class,
            'crvs.extension.bitbucket_team_type'        => \Crvs\BitbucketTeamTypeExtension\BitbucketTeamTypeExtension::class,
            'crvs.module.ci'                            => \Crvs\CiModule\CiModule::class,
            'pyro.module.menus'                         => \Pyro\MenusModule\MenusModule::class,
        ];
    }
}
