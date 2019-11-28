<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class AddonServiceProviderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(AddonServiceProvider::class);
        $class->properties([
            'routes' => ['var','array = \\' . static::class . '::routes()']
        ]);

    }

    public static function routes()
    {
        return [
            null => [
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
                'anomaly.module.users::intended' => '',
                'anomaly.module.users::message' => 'Sorry, you do not have access.',
            ]
        ];
    }
}
