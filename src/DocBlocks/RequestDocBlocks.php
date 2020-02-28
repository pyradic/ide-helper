<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laradic\Generators\Doc\DocRegistry;

class RequestDocBlocks
{

    public function handle(DocRegistry $registry)
    {
        $cd    = $registry->getClass(Request::class);
        $model = Str::ensureLeft(config('auth.providers.users.model'), '\\');
        $cd->ensureMethod('user', $model);
        $cd->getMethod('user')->ensureReturn([ '\\' . UserInterface::class . '|' . $model ]);
    }
}
