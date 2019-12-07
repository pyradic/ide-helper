<?php

namespace Pyro\IdeHelper\Examples;

class FieldFullConfigsExamples
{
    public static function full(){
        return [
            null => static::addon(),
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
            null => static::icon(),
            null => static::integer(),
            null => static::language(),
            null => static::markdown(),
            null => static::multiple(),
            null => static::polymorphic(),
            null => static::relationship(),
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

    public static function addon(){
        return array (
            'slug' => 'anomaly.field_type.addon',
            'config' =>
                array (
                    'type' => '',
                    'mode' => 'dropdown',
                    'search' => '',
                    'theme_type' => '',
                    'handler' => 'Anomaly\\AddonFieldType\\Handler\\DefaultHandler',
                ),
        );
    }
    public static function blocks(){
        return array (
            'slug' => 'anomaly.field_type.blocks',
            'config' =>
                array (
                    'blocks' => '',
                    'min' => '',
                    'max' => '',
                ),
        );
    }
    public static function boolean(){
        return array (
            'slug' => 'anomaly.field_type.boolean',
            'config' =>
                array (
                    'mode' => '',
                    'label' => '',
                    'on_text' => '',
                    'on_color' => 'success',
                    'off_text' => '',
                    'off_color' => 'danger',
                    'default_value' => false,
                ),
        );
    }
    public static function checkboxes(){
        return array (
            'slug' => 'anomaly.field_type.checkboxes',
            'config' =>
                array (
                    'mode' => 'checkboxes',
                    'options' => NULL,
                    'min' => '',
                    'max' => '',
                    'separator' => ':',
                    'default_value' => '',
                    'handler' => 'Anomaly\\CheckboxesFieldType\\CheckboxesFieldTypeOptions',
                ),
        );
    }
    public static function colorpicker(){
        return array (
            'slug' => 'anomaly.field_type.colorpicker',
            'config' =>
                array (
                    'format' => 'hex',
                    'default_value' => '',
                    'handler' => 'Anomaly\\ColorpickerFieldType\\Handler\\DefaultHandler',
                ),
        );
    }
    public static function country(){
        return array (
            'slug' => 'anomaly.field_type.country',
            'config' =>
                array (
                    'mode' => '',
                    'top_options' => '',
                    'default_value' => '',
                    'handler' => 'Anomaly\\CountryFieldType\\Handler\\DefaultHandler@handle',
                ),
        );
    }
    public static function datetime(){
        return array (
            'slug' => 'anomaly.field_type.datetime',
            'config' =>
                array (
                    'mode' => 'datetime',
                    'picker' => true,
                    'date_format' => 'j F, Y',
                    'time_format' => 'H:i',
                    'timezone' => 'Europe/Amsterdam',
                    'step' => 1,
                ),
        );
    }
    public static function decimal(){
        return array (
            'slug' => 'anomaly.field_type.decimal',
            'config' =>
                array (
                    'decimals' => 2,
                    'min' => 0,
                    'max' => '',
                    'default_value' => '',
                    'separator' => ',',
                    'point' => '.',
                    'digits' => 11,
                ),
        );
    }
    public static function editor(){
        return array (
            'slug' => 'anomaly.field_type.editor',
            'config' =>
                array (
                    'mode' => 'twig',
                    'default_value' => '',
                    'height' => 75,
                    'word_wrap' => '',
                    'theme' => 'monokai',
                    'loader' => 'twig',
                ),
        );
    }
    public static function email(){
        return array (
            'slug' => 'anomaly.field_type.email',
            'config' =>
                array (
                    'default_value' => '',
                ),
        );
    }
    public static function encrypted(){
        return array (
            'slug' => 'anomaly.field_type.encrypted',
            'config' =>
                array (
                    'show_text' => false,
                    'auto_decrypt' => false,
                ),
        );
    }
    public static function file(){
        return array (
            'slug' => 'anomaly.field_type.file',
            'config' =>
                array (
                    'folders' =>
                        array (
                        ),
                    'max' => NULL,
                    'mode' => 'default',
                    'allowed_types' => '',
                ),
        );
    }
    public static function files(){
        return array (
            'slug' => 'anomaly.field_type.files',
            'config' =>
                array (
                    'folders' =>
                        array (
                        ),
                    'min' => '',
                    'max' => '',
                    'mode' => 'default',
                    'allowed_types' => '',
                ),
        );
    }
    public static function icon(){
        return array (
            'slug' => 'anomaly.field_type.icon',
            'config' =>
                array (
                    'mode' => 'search',
                    'icon_sets' =>
                        array (
                            0 => 'fontawesome',
                        ),
                    'default_value' => '',
                ),
        );
    }
    public static function integer(){
        return array (
            'slug' => 'anomaly.field_type.integer',
            'config' =>
                array (
                    'separator' => ',',
                    'min' => 0,
                    'max' => '',
                    'step' => 1,
                    'default_value' => '',
                ),
        );
    }
    public static function language(){
        return array (
            'slug' => 'anomaly.field_type.language',
            'config' =>
                array (
                    'mode' => 'dropdown',
                    'top_options' => '',
                    'default_value' => 'en',
                ),
        );
    }
    public static function markdown(){
        return array (
            'slug' => 'anomaly.field_type.markdown',
            'config' =>
                array (
                    'height' => 300,
                ),
        );
    }
    public static function multiple(){
        return array (
            'slug' => 'anomaly.field_type.multiple',
            'config' =>
                array (
                    'related' => '',
                    'mode' => 'tags',
                    'title_name' => '',
                    'min' => '',
                    'max' => '',
                ),
        );
    }
    public static function polymorphic(){
        return array (
            'slug' => 'anomaly.field_type.polymorphic',
            'config' =>
                array (
                ),
        );
    }
    public static function relationship(){
        return array (
            'slug' => 'anomaly.field_type.relationship',
            'config' =>
                array (
                    'related' => '',
                    'mode' => 'dropdown',
                    'title_name' => '',
                ),
        );
    }
    public static function repeater(){
        return array (
            'slug' => 'anomaly.field_type.repeater',
            'config' =>
                array (
                    'related' => '',
                    'add_row' => '',
                    'min' => '',
                    'max' => '',
                ),
        );
    }
    public static function select(){
        return array (
            'slug' => 'anomaly.field_type.select',
            'config' =>
                array (
                    'mode' => 'dropdown',
                    'options' => '',
                    'separator' => '',
                    'default_value' => '',
                    'selector' => ':',
                    'handler' => 'options',
                ),
        );
    }
    public static function slider(){
        return array (
            'slug' => 'anomaly.field_type.slider',
            'config' =>
                array (
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'default_value' => '',
                    'unit' => '',
                ),
        );
    }
    public static function slug(){
        return array (
            'slug' => 'anomaly.field_type.slug',
            'config' =>
                array (
                    'type' => '_',
                    'slugify' => '',
                    'lowercase' => true,
                    'min' => '',
                    'max' => '',
                ),
        );
    }
    public static function state(){
        return array (
            'slug' => 'anomaly.field_type.state',
            'config' =>
                array (
                    'mode' => '',
                    'countries' => '',
                    'default_value' => '',
                    'handler' => 'Anomaly\\StateFieldType\\Handler\\DefaultHandler@handle',
                ),
        );
    }
    public static function tags(){
        return array (
            'slug' => 'anomaly.field_type.tags',
            'config' =>
                array (
                    'min' => '',
                    'max' => '',
                    'filter' => '',
                    'options' => '',
                    'enforce_options' => '',
                    'default_value' => '',
                    'handler' => 'Anomaly\\TagsFieldType\\TagsFieldTypeOptions',
                ),
        );
    }
    public static function text(){
        return array (
            'slug' => 'anomaly.field_type.text',
            'config' =>
                array (
                    'type' => 'text',
                    'mask' => '',
                    'min' => '',
                    'max' => 255,
                    'show_counter' => '',
                    'default_value' => '',
                ),
        );
    }
    public static function textarea(){
        return array (
            'slug' => 'anomaly.field_type.textarea',
            'config' =>
                array (
                    'rows' => 6,
                    'min' => '',
                    'max' => '',
                    'show_counter' => '',
                    'autogrow' => true,
                    'default_value' => '',
                    'storage' => NULL,
                ),
        );
    }
    public static function upload(){
        return array (
            'slug' => 'anomaly.field_type.upload',
            'config' =>
                array (
                    'folder' => '',
                    'image' => '',
                    'mimes' => '',
                    'max' => '2',
                    'disk' => 'uploads',
                ),
        );
    }
    public static function url(){
        return array (
            'slug' => 'anomaly.field_type.url',
            'config' =>
                array (
                    'default_value' => '',
                ),
        );
    }
    public static function wysiwyg(){
        return array (
            'slug' => 'anomaly.field_type.wysiwyg',
            'config' =>
                array (
                    'buttons' =>
                        array (
                            0 => 'format',
                            1 => 'bold',
                            2 => 'italic',
                            3 => 'deleted',
                            4 => 'lists',
                            5 => 'link',
                            6 => 'horizontalrule',
                            7 => 'underline',
                        ),
                    'plugins' =>
                        array (
                            0 => 'source',
                            1 => 'table',
                            2 => 'video',
                            3 => 'inlinestyle',
                            4 => 'filemanager',
                            5 => 'imagemanager',
                            6 => 'fullscreen',
                            7 => 'alignment',
                        ),
                    'height' => 75,
                    'line_breaks' => false,
                    'remove_new_lines' => false,
                    'default_value' => '',
                    'configuration' => 'default',
                ),
        );
    }
}
