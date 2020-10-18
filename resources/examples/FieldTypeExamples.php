<?php /** @noinspection AutoloadingIssuesInspection */

/** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class FieldTypeExamples
{
    public static function types()
    {
        return [
            'anomaly.field_type.addon',
            'pyro.field_type.availability',
            'anomaly.field_type.blocks',
            'anomaly.field_type.boolean',
            'anomaly.field_type.checkboxes',
            'anomaly.field_type.colorpicker',
            'anomaly.field_type.country',
            'anomaly.field_type.datetime',
            'anomaly.field_type.decimal',
            'anomaly.field_type.editor',
            'anomaly.field_type.email',
            'anomaly.field_type.encrypted',
            'anomaly.field_type.file',
            'crvs.field_type.files',
            'anomaly.field_type.grid',
            'anomaly.field_type.icon',
            'anomaly.field_type.integer',
            'anomaly.field_type.language',
            'anomaly.field_type.markdown',
            'pyro.field_type.matrix',
            'anomaly.field_type.multiple',
            'crvs.field_type.multiple_departments',
            'pyro.field_type.pivot',
            'anomaly.field_type.polymorphic',
            'anomaly.field_type.relationship',
            'pyro.field_type.relationship_through',
            'anomaly.field_type.repeater',
            'anomaly.field_type.select',
            'anomaly.field_type.slider',
            'anomaly.field_type.slug',
            'anomaly.field_type.state',
            'anomaly.field_type.tags',
            'anomaly.field_type.text',
            'anomaly.field_type.textarea',
            'anomaly.field_type.upload',
            'anomaly.field_type.url',
            'anomaly.field_type.wysiwyg',
        ];
    }

    public static function valueTypes()
    {
        $fields = [];
        foreach (static::types() as $i => $type) {
            $fields[ null ] = $type;
        }
        return $fields;
    }

    public static function fields()
    {
        return array_merge(static::valueTypes(), static::values());
    }

    public static function values()
    {
        return [
            null => static::addon(),
            null => static::availability(),
            null => static::blocks(),
            null => static::boolean(),
            null => static::checkboxes(),
            null => static::colorpicker(),
            null => static::country(),
            null => static::datetime(),
            null => static::decimal(),
            null => static::editor(),
            null => static::email(),
            null => static::encrypted(),
            null => static::file(),
            null => static::files(),
            null => static::grid(),
            null => static::icon(),
            null => static::integer(),
            null => static::language(),
            null => static::markdown(),
            null => static::matrix(),
            null => static::multiple(),
            null => static::multiple_departments(),
            null => static::pivot(),
            null => static::polymorphic(),
            null => static::relationship(),
            null => static::relationship_through(),
            null => static::repeater(),
            null => static::select(),
            null => static::slider(),
            null => static::slug(),
            null => static::state(),
            null => static::tags(),
            null => static::text(),
            null => static::textarea(),
            null => static::upload(),
            null => static::url(),
            null => static::wysiwyg(),
        ];
    }

    public static function configs()
    {
        return [
            'anomaly.field_type.addon'             => static::addon_config(),
            'pyro.field_type.availability'         => static::availability_config(),
            'anomaly.field_type.blocks'            => static::blocks_config(),
            'anomaly.field_type.boolean'           => static::boolean_config(),
            'anomaly.field_type.checkboxes'        => static::checkboxes_config(),
            'anomaly.field_type.colorpicker'       => static::colorpicker_config(),
            'anomaly.field_type.country'           => static::country_config(),
            'anomaly.field_type.datetime'          => static::datetime_config(),
            'anomaly.field_type.decimal'           => static::decimal_config(),
            'anomaly.field_type.editor'            => static::editor_config(),
            'anomaly.field_type.email'             => static::email_config(),
            'anomaly.field_type.encrypted'         => static::encrypted_config(),
            'anomaly.field_type.file'              => static::file_config(),
            'crvs.field_type.files'                => static::files_config(),
            'anomaly.field_type.grid'              => static::grid_config(),
            'anomaly.field_type.icon'              => static::icon_config(),
            'anomaly.field_type.integer'           => static::integer_config(),
            'anomaly.field_type.language'          => static::language_config(),
            'anomaly.field_type.markdown'          => static::markdown_config(),
            'pyro.field_type.matrix'               => static::matrix_config(),
            'anomaly.field_type.multiple'          => static::multiple_config(),
            'crvs.field_type.multiple_departments' => static::multiple_departments_config(),
            'pyro.field_type.pivot'                => static::pivot_config(),
            'anomaly.field_type.polymorphic'       => static::polymorphic_config(),
            'anomaly.field_type.relationship'      => static::relationship_config(),
            'pyro.field_type.relationship_through' => static::relationship_through_config(),
            'anomaly.field_type.repeater'          => static::repeater_config(),
            'anomaly.field_type.select'            => static::select_config(),
            'anomaly.field_type.slider'            => static::slider_config(),
            'anomaly.field_type.slug'              => static::slug_config(),
            'anomaly.field_type.state'             => static::state_config(),
            'anomaly.field_type.tags'              => static::tags_config(),
            'anomaly.field_type.text'              => static::text_config(),
            'anomaly.field_type.textarea'          => static::textarea_config(),
            'anomaly.field_type.upload'            => static::upload_config(),
            'anomaly.field_type.url'               => static::url_config(),
            'anomaly.field_type.wysiwyg'           => static::wysiwyg_config(),
        ];
    }

    public static function addon_config()
    {
        return [
            'type'       => '',
            'mode'       => 'dropdown',
            'search'     => '',
            'theme_type' => '',
            'handler'    => 'Anomaly\\AddonFieldType\\Handler\\DefaultHandler',
        ];
    }

    public static function addon()
    {
        return [ 'type' => 'anomaly.field_type.addon', 'config' => static::addon_config() ];
    }

    public static function availability_config()
    {
        return [
        ];
    }

    public static function availability()
    {
        return [ 'type' => 'pyro.field_type.availability', 'config' => static::availability_config() ];
    }

    public static function blocks_config()
    {
        return [
            'blocks' => '',
            'min'    => '',
            'max'    => '',
        ];
    }

    public static function blocks()
    {
        return [ 'type' => 'anomaly.field_type.blocks', 'config' => static::blocks_config() ];
    }

    public static function boolean_config()
    {
        return [
            'mode'          => '',
            'label'         => '',
            'on_text'       => '',
            'on_color'      => 'success',
            'off_text'      => '',
            'off_color'     => 'danger',
            'default_value' => false,
        ];
    }

    public static function boolean()
    {
        return [ 'type' => 'anomaly.field_type.boolean', 'config' => static::boolean_config() ];
    }

    public static function checkboxes_config()
    {
        return [
            'mode'          => 'checkboxes',
            'options'       => null,
            'min'           => '',
            'max'           => '',
            'separator'     => ':',
            'default_value' => '',
            'handler'       => 'Anomaly\\CheckboxesFieldType\\CheckboxesFieldTypeOptions',
        ];
    }

    public static function checkboxes()
    {
        return [ 'type' => 'anomaly.field_type.checkboxes', 'config' => static::checkboxes_config() ];
    }

    public static function colorpicker_config()
    {
        return [
            'format'        => 'hex',
            'default_value' => '',
            'handler'       => 'Anomaly\\ColorpickerFieldType\\Handler\\DefaultHandler',
        ];
    }

    public static function colorpicker()
    {
        return [ 'type' => 'anomaly.field_type.colorpicker', 'config' => static::colorpicker_config() ];
    }

    public static function country_config()
    {
        return [
            'mode'          => '',
            'top_options'   => '',
            'default_value' => '',
            'handler'       => 'Anomaly\\CountryFieldType\\Handler\\DefaultHandler@handle',
        ];
    }

    public static function country()
    {
        return [ 'type' => 'anomaly.field_type.country', 'config' => static::country_config() ];
    }

    public static function datetime_config()
    {
        return [
            'mode'        => 'datetime',
            'picker'      => true,
            'date_format' => 'j F, Y',
            'time_format' => 'H:i',
            'timezone'    => 'Europe/Amsterdam',
            'step'        => 1,
        ];
    }

    public static function datetime()
    {
        return [ 'type' => 'anomaly.field_type.datetime', 'config' => static::datetime_config() ];
    }

    public static function decimal_config()
    {
        return [
            'decimals'      => 2,
            'min'           => 0,
            'max'           => '',
            'default_value' => '',
            'separator'     => ',',
            'point'         => '.',
            'digits'        => 11,
        ];
    }

    public static function decimal()
    {
        return [ 'type' => 'anomaly.field_type.decimal', 'config' => static::decimal_config() ];
    }

    public static function editor_config()
    {
        return [
            'mode'          => 'twig',
            'default_value' => '',
            'height'        => 75,
            'word_wrap'     => '',
            'theme'         => 'monokai',
            'loader'        => 'twig',
        ];
    }

    public static function editor()
    {
        return [ 'type' => 'anomaly.field_type.editor', 'config' => static::editor_config() ];
    }

    public static function email_config()
    {
        return [
            'default_value' => '',
        ];
    }

    public static function email()
    {
        return [ 'type' => 'anomaly.field_type.email', 'config' => static::email_config() ];
    }

    public static function encrypted_config()
    {
        return [
            'show_text'    => false,
            'auto_decrypt' => false,
        ];
    }

    public static function encrypted()
    {
        return [ 'type' => 'anomaly.field_type.encrypted', 'config' => static::encrypted_config() ];
    }

    public static function file_config()
    {
        return [
            'folders'       =>
                [
                ],
            'max'           => null,
            'mode'          => 'default',
            'allowed_types' => '',
        ];
    }

    public static function file()
    {
        return [ 'type' => 'anomaly.field_type.file', 'config' => static::file_config() ];
    }

    public static function files_config()
    {
        return [
            'folders'       =>
                [
                ],
            'min'           => '',
            'max'           => '',
            'mode'          => 'default',
            'allowed_types' => '',
        ];
    }

    public static function files()
    {
        return [ 'type' => 'crvs.field_type.files', 'config' => static::files_config() ];
    }

    public static function grid_config()
    {
        return [
            'related' => '',
            'add_row' => '',
            'min'     => '',
            'max'     => '',
        ];
    }

    public static function grid()
    {
        return [ 'type' => 'anomaly.field_type.grid', 'config' => static::grid_config() ];
    }

    public static function icon_config()
    {
        return [
            'mode'          => 'search',
            'icon_sets'     =>
                [
                    0 => 'fontawesome',
                ],
            'default_value' => '',
        ];
    }

    public static function icon()
    {
        return [ 'type' => 'anomaly.field_type.icon', 'config' => static::icon_config() ];
    }

    public static function integer_config()
    {
        return [
            'separator'     => ',',
            'min'           => 0,
            'max'           => '',
            'step'          => 1,
            'default_value' => '',
        ];
    }

    public static function integer()
    {
        return [ 'type' => 'anomaly.field_type.integer', 'config' => static::integer_config() ];
    }

    public static function language_config()
    {
        return [
            'mode'          => 'dropdown',
            'top_options'   => '',
            'default_value' => 'en',
        ];
    }

    public static function language()
    {
        return [ 'type' => 'anomaly.field_type.language', 'config' => static::language_config() ];
    }

    public static function markdown_config()
    {
        return [
            'height' => 300,
        ];
    }

    public static function markdown()
    {
        return [ 'type' => 'anomaly.field_type.markdown', 'config' => static::markdown_config() ];
    }

    public static function matrix_config()
    {
        return [
        ];
    }

    public static function matrix()
    {
        return [ 'type' => 'pyro.field_type.matrix', 'config' => static::matrix_config() ];
    }

    public static function multiple_config()
    {
        return [
            'related'    => '',
            'mode'       => 'tags',
            'title_name' => '',
            'min'        => '',
            'max'        => '',
        ];
    }

    public static function multiple()
    {
        return [ 'type' => 'anomaly.field_type.multiple', 'config' => static::multiple_config() ];
    }

    public static function multiple_departments_config()
    {
        return [
            'related'    => '',
            'mode'       => 'lookup',
            'title_name' => '',
            'min'        => '',
            'max'        => '',
        ];
    }

    public static function multiple_departments()
    {
        return [ 'type' => 'crvs.field_type.multiple_departments', 'config' => static::multiple_departments_config() ];
    }

    public static function pivot_config()
    {
        return [
            'related'          => '',
            'mode'             => 'tags',
            'title_name'       => '',
            'min'              => '',
            'max'              => '',
            'couple'           =>
                [
                    'department' =>
                        [
                            'name'     => 'department',
                            'related'  => 'FQ\\Class\\Name',
                            'unique'   => false,
                            'required' => false,
                            'handler'  => null,
                        ],
                ],
            'relation_handler' => null,
        ];
    }

    public static function pivot()
    {
        return [ 'type' => 'pyro.field_type.pivot', 'config' => static::pivot_config() ];
    }

    public static function polymorphic_config()
    {
        return [
        ];
    }

    public static function polymorphic()
    {
        return [ 'type' => 'anomaly.field_type.polymorphic', 'config' => static::polymorphic_config() ];
    }

    public static function relationship_config()
    {
        return [
            'related'    => '',
            'mode'       => 'dropdown',
            'title_name' => '',
        ];
    }

    public static function relationship()
    {
        return [ 'type' => 'anomaly.field_type.relationship', 'config' => static::relationship_config() ];
    }

    public static function relationship_through_config()
    {
        return [
            'related'     => '',
            'mode'        => 'dropdown',
            'title_name'  => '',
            'through'     => '',
            'related_key' => '',
        ];
    }

    public static function relationship_through()
    {
        return [ 'type' => 'pyro.field_type.relationship_through', 'config' => static::relationship_through_config() ];
    }

    public static function repeater_config()
    {
        return [
            'related'        => '',
            'add_row'        => '',
            'min'            => '',
            'max'            => '',
            'repeater_title' => '',
        ];
    }

    public static function repeater()
    {
        return [ 'type' => 'anomaly.field_type.repeater', 'config' => static::repeater_config() ];
    }

    public static function select_config()
    {
        return [
            'mode'          => 'dropdown',
            'options'       => '',
            'separator'     => '',
            'default_value' => '',
            'selector'      => ':',
            'handler'       => 'options',
        ];
    }

    public static function select()
    {
        return [ 'type' => 'anomaly.field_type.select', 'config' => static::select_config() ];
    }

    public static function slider_config()
    {
        return [
            'min'           => 0,
            'max'           => 10,
            'step'          => 1,
            'default_value' => '',
            'unit'          => '',
        ];
    }

    public static function slider()
    {
        return [ 'type' => 'anomaly.field_type.slider', 'config' => static::slider_config() ];
    }

    public static function slug_config()
    {
        return [
            'type'      => '_',
            'slugify'   => '',
            'lowercase' => true,
            'min'       => '',
            'max'       => '',
        ];
    }

    public static function slug()
    {
        return [ 'type' => 'anomaly.field_type.slug', 'config' => static::slug_config() ];
    }

    public static function state_config()
    {
        return [
            'mode'          => '',
            'countries'     => '',
            'default_value' => '',
            'handler'       => 'Anomaly\\StateFieldType\\Handler\\DefaultHandler@handle',
        ];
    }

    public static function state()
    {
        return [ 'type' => 'anomaly.field_type.state', 'config' => static::state_config() ];
    }

    public static function tags_config()
    {
        return [
            'min'             => '',
            'max'             => '',
            'filter'          => '',
            'options'         => '',
            'enforce_options' => '',
            'default_value'   => '',
            'handler'         => 'Anomaly\\TagsFieldType\\TagsFieldTypeOptions',
        ];
    }

    public static function tags()
    {
        return [ 'type' => 'anomaly.field_type.tags', 'config' => static::tags_config() ];
    }

    public static function text_config()
    {
        return [
            'type'          => 'text',
            'mask'          => '',
            'min'           => '',
            'max'           => 255,
            'show_counter'  => '',
            'default_value' => '',
        ];
    }

    public static function text()
    {
        return [ 'type' => 'anomaly.field_type.text', 'config' => static::text_config() ];
    }

    public static function textarea_config()
    {
        return [
            'rows'          => 6,
            'min'           => '',
            'max'           => '',
            'show_counter'  => '',
            'autogrow'      => true,
            'default_value' => '',
            'storage'       => null,
        ];
    }

    public static function textarea()
    {
        return [ 'type' => 'anomaly.field_type.textarea', 'config' => static::textarea_config() ];
    }

    public static function upload_config()
    {
        return [
            'folder' => '',
            'image'  => '',
            'mimes'  => '',
            'max'    => '2',
            'disk'   => 'uploads',
        ];
    }

    public static function upload()
    {
        return [ 'type' => 'anomaly.field_type.upload', 'config' => static::upload_config() ];
    }

    public static function url_config()
    {
        return [
            'default_value' => '',
        ];
    }

    public static function url()
    {
        return [ 'type' => 'anomaly.field_type.url', 'config' => static::url_config() ];
    }

    public static function wysiwyg_config()
    {
        return [
            'buttons'          =>
                [
                    0 => 'format',
                    1 => 'bold',
                    2 => 'italic',
                    3 => 'deleted',
                    4 => 'lists',
                    5 => 'link',
                    6 => 'horizontalrule',
                    7 => 'underline',
                ],
            'plugins'          =>
                [
                    0 => 'source',
                    1 => 'table',
                    2 => 'video',
                    3 => 'inlinestyle',
                    4 => 'filemanager',
                    5 => 'imagemanager',
                    6 => 'fullscreen',
                    7 => 'alignment',
                ],
            'height'           => 75,
            'line_breaks'      => false,
            'remove_new_lines' => false,
            'default_value'    => '',
            'configuration'    => 'default',
        ];
    }

    public static function wysiwyg()
    {
        return [ 'type' => 'anomaly.field_type.wysiwyg', 'config' => static::wysiwyg_config() ];
    }
}
