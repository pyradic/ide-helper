<?php

namespace Pyro\IdeHelper\Completion;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class AuthCompletion implements CompletionInterface
{

    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(Authenticatable::class);
        $model = Str::ensureLeft(config('auth.providers.users.model'), '\\');
        $class->ensure('mixin', $model);
        $class->clearTagsByName('mixin');
    }

}
