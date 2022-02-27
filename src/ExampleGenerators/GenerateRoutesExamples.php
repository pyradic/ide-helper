<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Illuminate\Routing\Router;
use function base_path;
use function collect;
use function path_is_relative;

class GenerateRoutesExamples extends AbstractGenerator
{

    public function handle(Router $router)
    {

        $routes = collect($router->getRoutes())->map(function ($route) {
            return $route->uri();
        })->filter();

        $uris = $routes->map(function ($val) {
            return $val = "'{$val}',";
        })->implode("\n");

        $result =  <<<EOF
<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class RoutesExamples
{
    public static function uris()
    {
        return [
        {$uris}
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
