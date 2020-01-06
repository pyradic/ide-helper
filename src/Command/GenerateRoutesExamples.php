<?php

namespace Pyro\IdeHelper\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Illuminate\Routing\Router;

class GenerateRoutesExamples
{
    /** @var string */
    protected $path;

    /** @var boolean */
    protected $noWrite;

    /** @var string */
    protected $namespace;

    /**
     * GenerateFieldBlueprint constructor.
     *
     * @param string $path    File path to write generated results to
     * @param string $namespace
     * @param bool   $noWrite Disable write to file
     */
    public function __construct(string $path = __DIR__ . '/../../resources/examples/RoutesExamples.php', string $namespace = 'Pyro\\IdeHelper\\Examples', bool $noWrite = false)
    {
        $this->path      = $path;
        $this->noWrite   = $noWrite;
        $this->namespace = $namespace;
    }

    protected function write(string $data)
    {
        if ($this->noWrite) {
            return;
        }
        $path = path_is_relative($this->path) ? base_path($this->path) : $this->path;
        file_put_contents($path, $data, LOCK_EX);
    }

    public function handle(Router $router)
    {

        $routes = collect($router->getRoutes())->map(function ($route) {
            return $route->uri();
        })->filter();

        $uris = $routes->map(function($val){
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
