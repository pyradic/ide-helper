<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use function base_path;
use function collect;
use function path_is_relative;

class GenerateFieldTypeExamples extends AbstractGenerator
{
    public function handle(FieldTypeCollection $fields)
    {
        $base  = $fields->toBase();
        $types = $base->map->getNamespace()->implode("',\n'");
        $types = "['{$types}']";

        $methods = $base->map(function (FieldType $type) {
            $config = collect(config($type->getNamespace('config'), []))
                ->map(function () {
                    return '';
                })
                ->merge($type->getConfig())
                ->toArray();

            $configBody = var_export($config, true);
            return <<<EOF
public static function {$type->getSlug()}_config(){
    return {$configBody};
}
public static function {$type->getSlug()}(){
    return ['type' => '{$type->getNamespace()}', 'config' => static::{$type->getSlug()}_config() ];
}
EOF;
        })
            ->values()
            ->implode("\n");

        $values = $fields
            ->toBase()
            ->map(function (FieldType $field) {
                return "null => static::{$field->getSlug()}(),";
            })
            ->values()
            ->implode("\n");

        $configs = $fields
            ->toBase()
            ->map(function (FieldType $field) {
                return "'{$field->getNamespace()}' => static::{$field->getSlug()}_config(),";
            })
            ->values()
            ->implode("\n");

        $result = <<<EOF
<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class FieldTypeExamples
{
    public static function types()
    {
        return {$types};
    }

    public static function valueTypes()
    {
        \$fields = [];
        foreach (static::types() as \$i => \$type) {
            \$fields[ null ] = \$type;
        }
        return \$fields;
    }

    public static function fields()
    {
        return array_merge(static::valueTypes(), static::values());
    }

    public static function values(){
        return [
            {$values}
        ];
    }

    public static function configs(){
        return [
            {$configs}
        ];
    }

    {$methods}
}
EOF;

        $this->write($result);

        return $result;
    }
//
//    protected function generateMigrationExample(FieldTypeCollection $fields)
//    {
//        $methods = $fields
//            ->toBase()
//            ->map(function (FieldType $type) {
//                $config     = collect(config($type->getNamespace('config'), []))
//                    ->map(function () {
//                        return '';
//                    })
//                    ->merge($type->getConfig())
//                    ->toArray();
//                $configBody = var_export($config, true);
//                return <<<EOF
//public static function {$type->getSlug()}_config(){
//    return {$configBody};
//}
//public static function {$type->getSlug()}(){
//    return ['slug' => '{$type->getNamespace()}', 'config' => static::{$type->getSlug()}_config() ];
//}
//EOF;
//            })
//            ->values()
//            ->implode("\n");
//
//        $full = $fields
//            ->toBase()
//            ->map(function (FieldType $field) {
//                return "null => static::{$field->getSlug()}(),";
//            })
//            ->values()
//            ->implode("\n");
//
//        $data = <<<EOF
//<?php
//
//namespace Pyro\IdeHelper\Examples;
//
//class FieldFullConfigsExamples
//{
//    public static function full(){
//        return [
//            {$full}
//        ];
//    }
//
//    {$methods}
//}
//EOF;
//        return $data;
//    }
//
//    protected function generateIndividualConfigExamples(FieldTypeCollection $fields)
//    {
//        $methods = $fields
//            ->toBase()
//            ->map(function (FieldType $type) {
//                $config = collect(config($type->getNamespace('config'), []))
//                    ->map(function () {
//                        return '';
//                    })
//                    ->merge($type->getConfig())
//                    ->toArray();
//                $data   = var_export($config, true);
//                return <<<EOF
//public static function {$type->getSlug()}(){
//    return {$data};
//}
//EOF;
//            })
//            ->values()
//            ->implode("\n");
//
//        $data = <<<EOF
//<?php
//
//namespace Pyro\IdeHelper\Examples;
//
//class FieldConfigsExamples
//{
//    {$methods}
//}
//EOF;
//        return $data;
//    }
}
