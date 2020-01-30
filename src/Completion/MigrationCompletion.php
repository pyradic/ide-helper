<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\IdeHelper\Examples\FieldTypeExamples;

class MigrationCompletion implements CompletionInterface
{

    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(Migration::class);
        $class->cleanTag('property');
        $class->properties([
            'fields'  => [ 'var', 'array = \\' . FieldTypeExamples::class . '::fields()' ],
        ], true);
    }
}
