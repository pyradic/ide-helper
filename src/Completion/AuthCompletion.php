<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class AuthCompletion implements CompletionInterface
{

    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(Authenticatable::class);
        $model = Str::ensureLeft(config('auth.providers.users.model'), '\\');
        $class->ensureTag('mixin', $model);
        $class->cleanTag('mixin');

        $generator->class(Guard::class)
            ->methods([
                'user' => ['return', '\\'.Authenticatable::class . '|\\' . UserInterface::class]
            ]);


    }

}
