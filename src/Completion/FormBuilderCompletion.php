<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\IdeHelper\Examples\Examples;
use Pyro\IdeHelper\Examples\FormBuilderExamples;

class FormBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(FormBuilder::class);
        $class->properties([
            'buttons'  => [ 'var', 'array = \\' . Examples::class . '::buttons()' ],
            'sections' => [ 'var', 'array = \\' . FormBuilderExamples::class . '::sections()' ],
            'actions'  => [ 'var', 'array = \\' . FormBuilderExamples::class . '::actions()' ],
            'options'  => [ 'var', 'array = \\' . FormBuilderExamples::class . '::options()' ],
        ], true);
        $class->methods([
            'setButtons'  => [ 'param', 'array $buttons = \\' . FormBuilderExamples::class . '::buttons()' ],
            'getButtons'  => [ 'return', 'array = \\' . FormBuilderExamples::class . '::buttons()' ],
            'setSections' => [ 'param', 'array $sections = \\' . FormBuilderExamples::class . '::sections()' ],
            'getSections' => [ 'return', 'array = \\' . FormBuilderExamples::class . '::sections()' ],
            'setActions'  => [ 'param', 'array $actions = \\' . FormBuilderExamples::class . '::actions()' ],
            'getActions'  => [ 'return', 'array = \\' . FormBuilderExamples::class . '::actions()' ],
            'setOption'   => [ 'param', 'string $key = \\' . FormBuilderExamples::class . '::option()[$any]' ],
            'hasOption'   => [ 'param', 'string $key = \\' . FormBuilderExamples::class . '::option()[$any]' ],
            'getOption'   => [ 'param', 'string $key = \\' . FormBuilderExamples::class . '::option()[$any]' ],
            'setOptions'  => [ 'param', 'array $options = \\' . FormBuilderExamples::class . '::options()' ],
            'getOptions'  => [ 'return', 'array = \\' . FormBuilderExamples::class . '::options()' ],
        ], true);
    }

}
