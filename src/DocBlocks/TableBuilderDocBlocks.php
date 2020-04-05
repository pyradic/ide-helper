<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;
use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Column;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Row;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Examples\Examples;
use Pyro\IdeHelper\Examples\TableBuilderExamples;

class TableBuilderDocBlocks
{
    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(TableBuilder::class);

        $cd->cleanTag('method')
            ->ensureMethod('onReady', 'void', TableBuilder::class . ' $builder')
            ->ensureMethod('onBuilt', 'void', TableBuilder::class . ' $builder')
            ->ensureMethod('onRowDeleted', 'void', TableBuilder::class . ' $builder, \\' . EntryModel::class . ' $model, \\' . EntryModel::class . ' $entry')
            ->ensureMethod('onRowsDeleted', 'void', '$count, '. TableBuilder::class . ' $builder, \\' . EntryModel::class . ' $model')
            ->ensureMethod('onReordered', 'void', '$count, '. TableBuilder::class . ' $builder, \\' . EntryModel::class . ' $model')
            ->ensureMethod('onQuerying', 'void', '\\' . TableBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $query')
            ->ensureMethod('onQueried', 'void', '\\' . TableBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $query');

        $cd->getProperty('actions')->ensureVar('array', ' = \\' . TableBuilderExamples::class . '::actions()');
        $cd->getProperty('buttons')->ensureVar('array', ' = \\' . Examples::class . '::buttons()');
        $cd->getProperty('filters')->ensureVar('array', ' = \\' . TableBuilderExamples::class . '::filters()');
        $cd->getProperty('views')->ensureVar('array', ' = \\' . TableBuilderExamples::class . '::views()');
        $cd->getProperty('columns')->ensureVar('array', ' = \\' . TableBuilderExamples::class . '::columns()');
        $cd->getProperty('options')->ensureVar('array', ' = \\' . TableBuilderExamples::class . '::options()');

        $cd->getMethod('setButtons')->ensureParam('$buttons', 'array', ' = \\' . TableBuilderExamples::class . '::buttons()');
        $cd->getMethod('setActions')->ensureParam('$actions', 'array', ' = \\' . TableBuilderExamples::class . '::actions()');
        $cd->getMethod('setOption')->ensureParam('$key', 'string', ' = \\' . TableBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('hasOption')->ensureParam('$key', 'string', ' = \\' . TableBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('getOption')->ensureParam('$key', 'string', ' = \\' . TableBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('setOptions')->ensureParam('$options', 'array', ' = \\' . TableBuilderExamples::class . '::options()');
        $cd->getMethod('setViews')->ensureParam('$views', 'array', ' = \\' . TableBuilderExamples::class . '::views()');
        $cd->getMethod('getOptions')->ensureReturn('array', ' = \\' . TableBuilderExamples::class . '::options()');
        $cd->getMethod('getButtons')->ensureReturn('array', ' = \\' . TableBuilderExamples::class . '::buttons()');
        $cd->getMethod('getActions')->ensureReturn('array', ' = \\' . TableBuilderExamples::class . '::actions()');
        $cd->getMethod('getViews')->ensureReturn('array', ' = \\' . TableBuilderExamples::class . '::views()');

        $cd->getMethod('addView')->ensureParam('array', '$view', ' = \\' . TableBuilderExamples::class . '::view()');

        $cd = $registry->getClass(Row::class);
        $cd->getMethod('getButtons')->ensureReturn('\\' . ButtonCollection::class . '|\\' . Button::class . '[]');
        $cd->getMethod('getColumns')->ensureReturn('\\' . ColumnCollection::class . '|\\' . Column::class . '[]');

        $cd = $registry->getClass(Column::class);
        $cd->getMethod('getEntry')->ensureReturn([ '\\' . EntryInterface::class, 'mixed' ]);
    }

}
