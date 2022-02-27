<?php

namespace Pyro\IdeHelper\Examples;

class SettingsExamples
{
    public static function sections($section = null, $tab = null)
    {
        return [
            $section => [
                'stacked' => true,
                'fields' => [],
                'tabs'    => [
                    $tab => FormBuilderExamples::sectionTab()
                ],
            ],
        ];
    }

    public static function settings()
    {
        $settings = [];
        foreach (\Pyro\IdeHelper\Examples\FieldTypeExamples::values() as $key => $value) {
            $settings[ $key ] = array_merge($value,  [
                /** A .env key */
                'env'         => 'ENV_KEY',
                /** A configuration key */
                'bind'        => '{vendor}.{addonType}.{name}::{configFile}.{dotKey}',
                'bind'        => 'example.module.forum::discussions.allowed',
                'placeholder' => false,
                'required'    => true
            ]);
        }
        foreach (ConfigExamples::values() as $key => $value) {
            $settings[ $key ]['bind'] = $value;
        }
        return $settings;
    }

}
