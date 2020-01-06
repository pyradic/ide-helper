<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\IdeHelper\Examples\Examples;
use Pyro\IdeHelper\Examples\TableBuilderExamples;

class TableBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(TableBuilder::class);
        $class->cleanTag('property');
        $class->properties([
            'buttons' => [ 'var', 'array = \\' . Examples::class . '::buttons()' ],
            'actions' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::actions()' ],
            'options' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::options()' ],
            'filters' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::filters()' ],
            'views'   => [ 'var', 'array = \\' . TableBuilderExamples::class . '::views()' ],
            'columns' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::columns()' ],
        ]);
        $class->cleanTag('method');
        $class->methods([
            'setButtons' => [ 'param', 'array $buttons = \\' . TableBuilderExamples::class . '::buttons()' ],
            'getButtons' => [ 'return', 'array = \\' . TableBuilderExamples::class . '::buttons()' ],
            'setActions' => [ 'param', 'array $actions = \\' . TableBuilderExamples::class . '::actions()' ],
            'getActions' => [ 'return', 'array = \\' . TableBuilderExamples::class . '::actions()' ],
            'setOption'  => [ 'param', 'string $key = \\' . TableBuilderExamples::class . '::option()[$any]' ],
            'hasOption'  => [ 'param', 'string $key = \\' . TableBuilderExamples::class . '::option()[$any]' ],
            'getOption'  => [ 'param', 'string $key = \\' . TableBuilderExamples::class . '::option()[$any]' ],
            'setOptions' => [ 'param', 'array $options = \\' . TableBuilderExamples::class . '::options()' ],
            'getOptions' => [ 'return', 'array = \\' . TableBuilderExamples::class . '::options()' ],

            'setViews' => [ 'param', 'array $views = \\' . TableBuilderExamples::class . '::views()' ],
            'getViews' => [ 'return', 'array = \\' . TableBuilderExamples::class . '::views()' ],
        ]);

        //@todo removes other param, fix it
        $class->method('addView')
            ->ensureParamTag('array $view = \\' . TableBuilderExamples::class . '::view()')->setVariableName('$view');
    }

}
