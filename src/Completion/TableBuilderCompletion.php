<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Column;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Row;
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
            'actions' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::actions()' ],
            'buttons' => [ 'var', 'array = \\' . Examples::class . '::buttons()' ],
            'filters' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::filters()' ],
            'views'   => [ 'var', 'array = \\' . TableBuilderExamples::class . '::views()' ],
            'columns' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::columns()' ],
            'options' => [ 'var', 'array = \\' . TableBuilderExamples::class . '::options()' ],
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

        $generator->class(Row::class)
            ->methods([
                'getButtons' => [ 'return', '\\' . ButtonCollection::class . '|\\' . Button::class . '[]' ],
                'getColumns' => [ 'return', '\\' . ColumnCollection::class . '|\\' . Column::class . '[]' ],
            ]);
        $generator->class(Column::class)
            ->methods([
                'getEntry' => [ 'return', '\\' . EntryInterface::class . '|mixed' ],
            ]);
    }

}
