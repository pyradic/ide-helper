<?php

namespace Pyradic\IdeHelper\Command;

use Laradic\Generators\DocBlock\ClassDoc;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class ProcessAddonServiceProvider
{
    public function handle()
    {
        $class = new ClassDoc(AddonServiceProvider::class);
        $class->ensure('property', <<<DOC
array \$routes  = [
    \$i => [
         'as' => '',
         'uses' => '',
         'verb' => '',
         'ttl' => 0,
         'csrf' => true,
         'middleware' => [],
         'where' => [],
         'streams::httpcache'  => false,
         'streams::addon' => '',

         'anomaly.module.users::permission' => 'vendor.module.example::widgets.test',
         'anomaly.module.users::permission' => ['vendor.module.example::widgets.test'],

         'anomaly.module.users::role' => 'vendor.module.example::widgets.test',
         'anomaly.module.users::role' => ['vendor.module.example::widgets.test'],

         'anomaly.module.users::redirect' => '/',
         'anomaly.module.users::route' => 'vendor.module.example::route.name',
         'anomaly.module.users::intended' => ''
         'anomaly.module.users::message' => 'Sorry, you do not have access.',
     ]
] 
DOC
);
        foreach($class->getDocBlock()->getTagsByName('property') as $tag) {
            $class->getDocBlock()->deleteTag($tag);
        }
        $res = $class->process();

        return $res;
    }
}
