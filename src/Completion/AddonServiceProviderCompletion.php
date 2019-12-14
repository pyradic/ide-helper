<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\IdeHelper\Examples\AddonServiceProviderExamples;

class AddonServiceProviderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(AddonServiceProvider::class);
        $class->properties([
            'routes' => ['var','array = \\' . AddonServiceProviderExamples::class . '::routes()']
        ]);

    }

}
