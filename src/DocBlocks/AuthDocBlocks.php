<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;
use Laradic\Generators\Doc\DocRegistry;

class AuthDocBlocks
{
    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(Authenticatable::class);
        $model = Str::ensureLeft(config('auth.providers.users.model'), '\\');
        $cd->cleanTag('mixin');
        $cd->ensureMixin( $model);

        $registry->getClass(Guard::class)
            ->getMethod('user')
            ->ensureReturn([Authenticatable::class, UserInterface::class]);
    }

}
