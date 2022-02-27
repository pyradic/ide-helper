<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Pyro\IdeHelper\Command\ResolveAllPermissions;
use function base_path;
use function dispatch_now;
use function path_is_relative;

class GeneratePermissionsExamples extends AbstractGenerator
{

    public function handle(FieldTypeCollection $fields)
    {
        /** @var \Illuminate\Support\Collection $permissions */
        $permissions = dispatch_now(new ResolveAllPermissions());
        $keys        = $permissions->pluck('key')->map(function ($val) {
            return $val = "'{$val}',";
        })->implode("\n");
        $assoc       = $permissions->pluck('key')->map(function ($val) {
            return $val = "'{$val}' => '{$val}',";
        })->implode("\n");
        $result      = <<<EOF
<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class PermissionsExamples
{
    public static function permissions()
    {
        return [
        {$keys}
        ];
    }

    public static function permissionsAssoc()
    {
        return [
        {$assoc}
        ];
    }
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
