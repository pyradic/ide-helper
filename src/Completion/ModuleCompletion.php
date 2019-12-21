<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\IdeHelper\Examples\ModuleExamples;

class ModuleCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(Module::class);
        $class->cleanTag('property');
        $class->properties([
            'sections'  => [ 'var', 'array = \\' . ModuleExamples::class . '::sections()' ],
            'shortcuts' => [ 'var', 'array = \\' . ModuleExamples::class . '::shortcuts()' ],
        ], true);
        $class->methods([
            'setSections'  => [ 'param', 'array $sections = \\' . ModuleExamples::class . '::sections()' ],
            'getSections'  => [ 'return', 'array = \\' . ModuleExamples::class . '::sections()' ],
            'addSection'  => [ 'param', 'array $section = \\' . ModuleExamples::class . '::section()' ],

            'setShortcuts' => [ 'param', 'array $shortcuts = \\' . ModuleExamples::class . '::shortcuts()' ],
            'getShortcuts' => [ 'return', 'array = \\' . ModuleExamples::class . '::shortcuts()' ],
            'addShortcut' => [ 'param', 'array $shortcut = \\' . ModuleExamples::class . '::shortcut()' ],
        ]);
    }

}
