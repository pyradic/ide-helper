<?php

namespace Pyro\IdeHelper\Examples;

class FieldConfigsExamples
{
    public static function addon()
    {
        return [
            'type'       => '',
            'mode'       => 'dropdown',
            'search'     => '',
            'theme_type' => '',
            'handler'    => 'Anomaly\\AddonFieldType\\Handler\\DefaultHandler',
        ];
    }

    public static function blocks()
    {
        return [
            'blocks' => '',
            'min'    => '',
            'max'    => '',
        ];
    }

    public static function boolean()
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

    public static function checkboxes()
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

    public static function colorpicker()
    {
        return [
            'format'        => 'hex',
            'default_value' => '',
            'handler'       => 'Anomaly\\ColorpickerFieldType\\Handler\\DefaultHandler',
        ];
    }

    public static function country()
    {
        return [
            'mode'          => '',
            'top_options'   => '',
            'default_value' => '',
            'handler'       => 'Anomaly\\CountryFieldType\\Handler\\DefaultHandler@handle',
        ];
    }

    public static function datetime()
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

    public static function decimal()
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

    public static function editor()
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

    public static function email()
    {
        return [
            'default_value' => '',
        ];
    }

    public static function encrypted()
    {
        return [
            'show_text'    => false,
            'auto_decrypt' => false,
        ];
    }

    public static function file()
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

    public static function files()
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

    public static function icon()
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

    public static function integer()
    {
        return [
            'separator'     => ',',
            'min'           => 0,
            'max'           => '',
            'step'          => 1,
            'default_value' => '',
        ];
    }

    public static function language()
    {
        return [
            'mode'          => 'dropdown',
            'top_options'   => '',
            'default_value' => 'en',
        ];
    }

    public static function markdown()
    {
        return [
            'height' => 300,
        ];
    }

    public static function multiple()
    {
        return [
            'related'    => '',
            'mode'       => 'tags',
            'title_name' => '',
            'min'        => '',
            'max'        => '',
        ];
    }

    public static function polymorphic()
    {
        return [
        ];
    }

    public static function relationship()
    {
        return [
            /** type_text:"string" */
            'related'    => '',
            'mode'       => 'dropdown',
            'title_name' => '',
        ];
    }

    public static function repeater()
    {
        return [
            'related' => '',
            'add_row' => '',
            'min'     => '',
            'max'     => '',
        ];
    }

    public static function select()
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

    public static function slider()
    {
        return [
            'min'           => 0,
            'max'           => 10,
            'step'          => 1,
            'default_value' => '',
            'unit'          => '',
        ];
    }

    public static function slug()
    {
        return [
            'type'      => '_',
            'slugify'   => '',
            'lowercase' => true,
            'min'       => 0,
            'max'       => 0,
        ];
    }

    public static function state()
    {
        return [
            'mode'          => '',
            'countries'     => '',
            'default_value' => '',
            'handler'       => 'Anomaly\\StateFieldType\\Handler\\DefaultHandler@handle',
        ];
    }

    public static function tags()
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

    public static function text()
    {
        return [
            'type'          => 'text',
            'mask'          => '',
            'min'           => 0,
            'min'           => null,
            'max'           => 255,
            'show_counter'  => '',
            'default_value' => '',
        ];
    }

    public static function textarea()
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

    public static function upload()
    {
        return [
            'folder' => '',
            'image'  => '',
            'mimes'  => '',
            'max'    => '2',
            'disk'   => 'uploads',
        ];
    }

    public static function url()
    {
        return [
            'default_value' => '',
        ];
    }

    public static function wysiwyg()
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
}
