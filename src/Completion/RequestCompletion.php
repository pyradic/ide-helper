<?php

namespace Pyro\IdeHelper\Completion;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Laradic\Idea\Completions\CompletionInterface;

class RequestCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator, $next)
    {
        /** @var \Anomaly\UsersModule\User\UserModel $user */
        $class = $generator->class(Request::class);
        $model = Str::ensureLeft(config('auth.providers.users.model'), '\\');
        $class->ensureMethod('user', $model);
        return $next($generator);
    }
}
