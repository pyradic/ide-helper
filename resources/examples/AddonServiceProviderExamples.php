<?php

namespace Pyro\IdeHelper\Examples;

class AddonServiceProviderExamples
{

    public static function routes()
    {
        return [
            null => static::route(),
        ];
    }

    public static function route()
    {
        $route                                       = [
            'as'                 => '',
            'uses'               => '',
            'verb'               => '',
            'ttl'                => 0,
            'csrf'               => true,
            'middleware'         => [],
            'where'              => [],
            'streams::httpcache' => false,
            'streams::addon'     => '',

            'anomaly.module.users::role' => 'vendor.module.example::widgets.test',
            'anomaly.module.users::role' => [ 'vendor.module.example::widgets.test' ],

            'anomaly.module.users::redirect' => '/',
            'anomaly.module.users::route'    => 'vendor.module.example::route.name',
            'anomaly.module.users::intended' => '',
            'anomaly.module.users::message'  => 'Sorry, you do not have access.',

            'entry'      => '',
            'breadcrumb' => [ 'title', 'parent::route.name' ],
            'breadcrumb' => [ 'title' => '', 'parent' => '::route.name' ],
        ];
        $permissions                                 = PermissionsExamples::permissionsAssoc();
        $route[ 'anomaly.module.users::permission' ] = $permissions;
        foreach (PermissionsExamples::permissions() as $permission) {
            $route[ 'anomaly.module.users::permission' ] = $permission;
        }
        return $route;
    }
}
