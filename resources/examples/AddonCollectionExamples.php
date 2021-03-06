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
            'anomaly.module.settings'                    => \Anomaly\SettingsModule\SettingsModule::class,
            'anomaly.module.preferences'                 => \Anomaly\PreferencesModule\PreferencesModule::class,
            'anomaly.field_type.addon'                   => \Anomaly\AddonFieldType\AddonFieldType::class,
            'anomaly.module.blocks'                      => \Anomaly\BlocksModule\BlocksModule::class,
            'anomaly.field_type.blocks'                  => \Anomaly\BlocksFieldType\BlocksFieldType::class,
            'anomaly.field_type.boolean'                 => \Anomaly\BooleanFieldType\BooleanFieldType::class,
            'anomaly.field_type.checkboxes'              => \Anomaly\CheckboxesFieldType\CheckboxesFieldType::class,
            'anomaly.field_type.colorpicker'             => \Anomaly\ColorpickerFieldType\ColorpickerFieldType::class,
            'anomaly.module.configuration'               => \Anomaly\ConfigurationModule\ConfigurationModule::class,
            'anomaly.plugin.contact'                     => \Anomaly\ContactPlugin\ContactPlugin::class,
            'anomaly.field_type.country'                 => \Anomaly\CountryFieldType\CountryFieldType::class,
            'anomaly.module.dashboard'                   => \Anomaly\DashboardModule\DashboardModule::class,
            'anomaly.field_type.datetime'                => \Anomaly\DatetimeFieldType\DatetimeFieldType::class,
            'anomaly.field_type.decimal'                 => \Anomaly\DecimalFieldType\DecimalFieldType::class,
            'anomaly.extension.default_authenticator'    => \Anomaly\DefaultAuthenticatorExtension\DefaultAuthenticatorExtension::class,
            'anomaly.extension.default_page_handler'     => \Anomaly\DefaultPageHandlerExtension\DefaultPageHandlerExtension::class,
            'anomaly.field_type.editor'                  => \Anomaly\EditorFieldType\EditorFieldType::class,
            'anomaly.field_type.email'                   => \Anomaly\EmailFieldType\EmailFieldType::class,
            'anomaly.field_type.encrypted'               => \Anomaly\EncryptedFieldType\EncryptedFieldType::class,
            'anomaly.field_type.file'                    => \Anomaly\FileFieldType\FileFieldType::class,
            'anomaly.module.files'                       => \Anomaly\FilesModule\FilesModule::class,
            'anomaly.module.grids'                       => \Anomaly\GridsModule\GridsModule::class,
            'anomaly.module.grids'                       => \Anomaly\GridsModule\GridsModule::class,
            'anomaly.field_type.grid'                    => \Anomaly\GridFieldType\GridFieldType::class,
            'anomaly.plugin.helper'                      => \Anomaly\HelperPlugin\HelperPlugin::class,
            'anomaly.extension.html_block'               => \Anomaly\HtmlBlockExtension\HtmlBlockExtension::class,
            'anomaly.field_type.icon'                    => \Anomaly\IconFieldType\IconFieldType::class,
            'anomaly.module.installer'                   => \Anomaly\InstallerModule\InstallerModule::class,
            'anomaly.field_type.integer'                 => \Anomaly\IntegerFieldType\IntegerFieldType::class,
            'anomaly.field_type.language'                => \Anomaly\LanguageFieldType\LanguageFieldType::class,
            'anomaly.field_type.markdown'                => \Anomaly\MarkdownFieldType\MarkdownFieldType::class,
            'anomaly.field_type.multiple'                => \Anomaly\MultipleFieldType\MultipleFieldType::class,
            'anomaly.module.navigation'                  => \Anomaly\NavigationModule\NavigationModule::class,
            'anomaly.extension.page_link_type'           => \Anomaly\PageLinkTypeExtension\PageLinkTypeExtension::class,
            'anomaly.module.pages'                       => \Anomaly\PagesModule\PagesModule::class,
            'anomaly.field_type.polymorphic'             => \Anomaly\PolymorphicFieldType\PolymorphicFieldType::class,
            'anomaly.module.redirects'                   => \Anomaly\RedirectsModule\RedirectsModule::class,
            'anomaly.field_type.relationship'            => \Anomaly\RelationshipFieldType\RelationshipFieldType::class,
            'anomaly.module.repeaters'                   => \Anomaly\RepeatersModule\RepeatersModule::class,
            'anomaly.module.repeaters'                   => \Anomaly\RepeatersModule\RepeatersModule::class,
            'anomaly.field_type.repeater'                => \Anomaly\RepeaterFieldType\RepeaterFieldType::class,
            'anomaly.extension.robots'                   => \Anomaly\RobotsExtension\RobotsExtension::class,
            'anomaly.module.search'                      => \Anomaly\SearchModule\SearchModule::class,
            'anomaly.field_type.select'                  => \Anomaly\SelectFieldType\SelectFieldType::class,
            'anomaly.extension.sitemap'                  => \Anomaly\SitemapExtension\SitemapExtension::class,
            'anomaly.field_type.slider'                  => \Anomaly\SliderFieldType\SliderFieldType::class,
            'anomaly.field_type.slug'                    => \Anomaly\SlugFieldType\SlugFieldType::class,
            'anomaly.field_type.state'                   => \Anomaly\StateFieldType\StateFieldType::class,
            'anomaly.field_type.tags'                    => \Anomaly\TagsFieldType\TagsFieldType::class,
            'anomaly.field_type.text'                    => \Anomaly\TextFieldType\TextFieldType::class,
            'anomaly.field_type.textarea'                => \Anomaly\TextareaFieldType\TextareaFieldType::class,
            'anomaly.extension.throttle_security_check'  => \Anomaly\ThrottleSecurityCheckExtension\ThrottleSecurityCheckExtension::class,
            'anomaly.field_type.upload'                  => \Anomaly\UploadFieldType\UploadFieldType::class,
            'anomaly.field_type.url'                     => \Anomaly\UrlFieldType\UrlFieldType::class,
            'anomaly.extension.url_link_type'            => \Anomaly\UrlLinkTypeExtension\UrlLinkTypeExtension::class,
            'anomaly.extension.user_security_check'      => \Anomaly\UserSecurityCheckExtension\UserSecurityCheckExtension::class,
            'anomaly.module.users'                       => \Anomaly\UsersModule\UsersModule::class,
            'anomaly.field_type.wysiwyg'                 => \Anomaly\WysiwygFieldType\WysiwygFieldType::class,
            'anomaly.extension.wysiwyg_block'            => \Anomaly\WysiwygBlockExtension\WysiwygBlockExtension::class,
            'anomaly.extension.xml_feed_widget'          => \Anomaly\XmlFeedWidgetExtension\XmlFeedWidgetExtension::class,
            'pyrocms.theme.accelerant'                   => \Pyrocms\AccelerantTheme\AccelerantTheme::class,
            'pyrocms.theme.starter'                      => \Pyrocms\StarterTheme\StarterTheme::class,
            'crvs.module.activities'                     => \Crvs\ActivitiesModule\ActivitiesModule::class,
            'crvs.theme.admin'                           => \Crvs\AdminTheme\AdminTheme::class,
            'crvs.module.agenda'                         => \Crvs\AgendaModule\AgendaModule::class,
            'crvs.extension.care_role_type'              => \Crvs\CareRoleTypeExtension\CareRoleTypeExtension::class,
            'crvs.extension.caretaker_role_type'         => \Crvs\CaretakerRoleTypeExtension\CaretakerRoleTypeExtension::class,
            'crvs.module.ci'                             => \Crvs\CiModule\CiModule::class,
            'crvs.extension.client_registrations_widget' => \Crvs\ClientRegistrationsWidgetExtension\ClientRegistrationsWidgetExtension::class,
            'crvs.extension.client_registrations_widget' => \Crvs\ClientRegistrationsWidgetExtension\ClientRegistrationsWidgetExtension::class,
            'crvs.module.client_registrations'           => \Crvs\ClientRegistrationsModule\ClientRegistrationsModule::class,
            'crvs.module.clients'                        => \Crvs\ClientsModule\ClientsModule::class,
            'crvs.module.contacts'                       => \Crvs\ContactsModule\ContactsModule::class,
            'crvs.module.core'                           => \Crvs\CoreModule\CoreModule::class,
            'crvs.extension.courses_role_type'           => \Crvs\CoursesRoleTypeExtension\CoursesRoleTypeExtension::class,
            'crvs.extension.default_role_type'           => \Crvs\DefaultRoleTypeExtension\DefaultRoleTypeExtension::class,
            'crvs.module.departments'                    => \Crvs\DepartmentsModule\DepartmentsModule::class,
            'crvs.module.dev'                            => \Crvs\DevModule\DevModule::class,
            'crvs.module.faq'                            => \Crvs\FaqModule\FaqModule::class,
            'crvs.field_type.files'                      => \Crvs\FilesFieldType\FilesFieldType::class,
            'crvs.module.files'                          => \Crvs\FilesModule\FilesModule::class,
            'crvs.theme.frontend'                        => \Crvs\FrontendTheme\FrontendTheme::class,
            'crvs.module.helpdesk'                       => \Crvs\HelpdeskModule\HelpdeskModule::class,
            'crvs.field_type.multiple_departments'       => \Crvs\MultipleDepartmentsFieldType\MultipleDepartmentsFieldType::class,
            'crvs.extension.notes_widget'                => \Crvs\NotesWidgetExtension\NotesWidgetExtension::class,
            'crvs.extension.notes_widget'                => \Crvs\NotesWidgetExtension\NotesWidgetExtension::class,
            'crvs.module.notes'                          => \Crvs\NotesModule\NotesModule::class,
            'crvs.extension.private_storage_adapter'     => \Crvs\PrivateStorageAdapterExtension\PrivateStorageAdapterExtension::class,
            'crvs.extension.requester_role_type'         => \Crvs\RequesterRoleTypeExtension\RequesterRoleTypeExtension::class,
            'crvs.module.ui'                             => \Crvs\UiModule\UiModule::class,
            'crvs.extension.volunteer_role_type'         => \Crvs\VolunteerRoleTypeExtension\VolunteerRoleTypeExtension::class,
            'examples.module.ex1'                        => \Examples\Ex1Module\Ex1Module::class,
            'examples.module.ex2'                        => \Examples\Ex2Module\Ex2Module::class,
            'examples.module.ex3'                        => \Examples\Ex3Module\Ex3Module::class,
            'pyro.module.activity_log'                   => \Pyro\ActivityLogModule\ActivityLogModule::class,
            'pyro.field_type.availability'               => \Pyro\AvailabilityFieldType\AvailabilityFieldType::class,
            'pyro.extension.confluence_widget'           => \Pyro\ConfluenceWidgetExtension\ConfluenceWidgetExtension::class,
            'pyro.module.diagnose'                       => \Pyro\DiagnoseModule\DiagnoseModule::class,
            'pyro.module.docs'                           => \Pyro\DocsModule\DocsModule::class,
            'pyro.module.graphql'                        => \Pyro\GraphqlModule\GraphqlModule::class,
            'pyro.extension.html_widget'                 => \Pyro\HtmlWidgetExtension\HtmlWidgetExtension::class,
            'pyro.extension.jira_widget'                 => \Pyro\JiraWidgetExtension\JiraWidgetExtension::class,
            'pyro.field_type.matrix'                     => \Pyro\MatrixFieldType\MatrixFieldType::class,
            'pyro.extension.divider_link_type'           => \Pyro\DividerLinkTypeExtension\DividerLinkTypeExtension::class,
            'pyro.extension.divider_link_type'           => \Pyro\DividerLinkTypeExtension\DividerLinkTypeExtension::class,
            'pyro.extension.header_link_type'            => \Pyro\HeaderLinkTypeExtension\HeaderLinkTypeExtension::class,
            'pyro.extension.header_link_type'            => \Pyro\HeaderLinkTypeExtension\HeaderLinkTypeExtension::class,
            'pyro.extension.label_link_type'             => \Pyro\LabelLinkTypeExtension\LabelLinkTypeExtension::class,
            'pyro.extension.label_link_type'             => \Pyro\LabelLinkTypeExtension\LabelLinkTypeExtension::class,
            'pyro.extension.module_link_type'            => \Pyro\ModuleLinkTypeExtension\ModuleLinkTypeExtension::class,
            'pyro.extension.module_link_type'            => \Pyro\ModuleLinkTypeExtension\ModuleLinkTypeExtension::class,
            'pyro.extension.url_link_type'               => \Pyro\UrlLinkTypeExtension\UrlLinkTypeExtension::class,
            'pyro.extension.url_link_type'               => \Pyro\UrlLinkTypeExtension\UrlLinkTypeExtension::class,
            'pyro.extension.disabled_link_type'          => \Pyro\DisabledLinkTypeExtension\DisabledLinkTypeExtension::class,
            'pyro.extension.disabled_link_type'          => \Pyro\DisabledLinkTypeExtension\DisabledLinkTypeExtension::class,
            'pyro.module.menus'                          => \Pyro\MenusModule\MenusModule::class,
            'pyro.module.news'                           => \Pyro\NewsModule\NewsModule::class,
            'pyro.module.permission_tree'                => \Pyro\PermissionTreeModule\PermissionTreeModule::class,
            'pyro.field_type.pivot'                      => \Pyro\PivotFieldType\PivotFieldType::class,
            'pyro.module.reactable'                      => \Pyro\ReactableModule\ReactableModule::class,
            'pyro.field_type.relationship_through'       => \Pyro\RelationshipThroughFieldType\RelationshipThroughFieldType::class,
            'pyro.module.streams_platform'               => \Pyro\StreamsPlatformModule\StreamsPlatformModule::class,
            'pyro.extension.table_exporter'              => \Pyro\TableExporterExtension\TableExporterExtension::class,
            'pyro.extension.table_filters'               => \Pyro\TableFiltersExtension\TableFiltersExtension::class,
            'pyro.module.ui'                             => \Pyro\UiModule\UiModule::class,
            'pyro.module.vxe_table'                      => \Pyro\VxeTableModule\VxeTableModule::class,
            'wmomo.module.zwolle'                        => \Wmomo\ZwolleModule\ZwolleModule::class,
        ];
    }
}
