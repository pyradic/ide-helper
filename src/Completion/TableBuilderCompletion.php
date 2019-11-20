<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\All;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\RecentlyCreated;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\RecentlyModified;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Type\Trash;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class TableBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(TableBuilder::class);
        $class->cleanTag('property');
        $class->properties([
            'buttons' => [ 'var', 'array =' . Common::buttons() ],
            'actions' => [ 'var', 'array = ' . $this->actions() ],
            'options' => [ 'var', 'array = ' . $this->options() ],
            'filters' => [ 'var', 'array = ' . $this->filters() ],
            'views'   => [ 'var', 'array = ' . $this->views() ],
            'columns' => [
                'var',
                'array = ' . <<<DOC
[ \\\$column => [
    'wrapper' => '',
    'entry' => '',
    'heading' => '',
    'value' => '',
    'value' => ['(column)' => ''],
    'field' => '',
    'sort_column' => 'name',
]
DOC,
            ],
        ]);
        $class->cleanTag('property');
    }

    public function filters()
    {
        return <<<DOC
[

    'input'      => [
        'slug'   => 'input',
        'filter' => InputFilter::class,
    ],
    'search'     => [
        'slug'        => 'search',
        'filter'      => SearchFilter::class,
        'placeholder' => 'streams::message.search',
    ],
    'select'     => [
        'slug'   => 'select',
        'filter' => SelectFilter::class,
    ],
    'field'      => [
        'filter' => FieldFilter::class,
    ],
    'datetime'   => [
        'slug'   => 'datetime',
        'filter' => DatetimeFilter::class,
    ],
    'created_at' => [
        'filter'      => DatetimeFilter::class,
        'placeholder' => 'streams::entry.created_at',
    ],
    'updated_at' => [
        'filter'      => DatetimeFilter::class,
        'placeholder' => 'streams::entry.updated_at',
    ],
    \\\$filter => [
        'slug' => '',
        'field' => '',
        'stream' => '',
        'prefix' => '',
        'exact' => '',
        'active' => '',
        'column' => '',
        'placeholder' => '',
        'query' => '',
    ]
]
DOC;

    }



    public function actions()
    {
        $buttons = Common::buttons();
        return <<<DOC
[
    'delete'       => [
        'handler' => Delete::class,
    ],
    'prompt'       => [
        'handler' => Delete::class,
    ],
    'force_delete' => [
        'button'  => 'prompt',
        'handler' => ForceDelete::class,
        'text'    => 'streams::button.force_delete',
    ],
    'export'       => [
        'button'  => 'info',
        'icon'    => 'download',
        'handler' => Export::class,
        'text'    => 'streams::button.export',
    ],
    'edit'         => [
        'handler' => Edit::class,
    ],
    'reorder'      => [
        'handler'    => Reorder::class,
        'text'       => 'streams::button.reorder',
        'icon'       => 'fa fa-sort-amount-asc',
        'class'      => 'reorder',
        'type'       => 'success',
        'attributes' => [
            'data-ignore',
        ],
    ],
    \\\$action => [
        'handler'    => '',
        'text'       => '',
        'icon'       => '',
        'class'      => '',
        'type'       => '',
        'attributes' => [],
        'button' => {$buttons}
    ]    
]
DOC;


    }

    public function views()
    {
//        $registry = resolve(\Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class);

        $views = [
            'all'               => All::class,
            'trash'             => Trash::class,
            'recently_created'  => RecentlyCreated::class,
            'recently_modified' => RecentlyModified::class,
        ];
        return <<<DOC
[
    'all' => [
        'slug' => 'all',
        'text' => 'streams::view.all',
        'view' => '{$views['all']}',
    ],
    'trash' => [
        'slug'    => 'trash',
        'text'    => 'streams::view.trash',
        'view' => '{$views['trash']}',
    ],
    'recently_created' => [
        'slug' => 'recently_created',
        'text' => 'streams::view.recently_created',
        'view' => '{$views['recently_created']}',
    ],
    'recently_modified' => [
        'slug' => 'recently_modified',
        'text' => 'streams::view.recently_modified',
        'view' => '{$views['recently_modified']}',
    ],
    \\\$view => [
        'slug'    => '',
        'text'    => '',
        'view'    => '',
    ]
]
DOC;
    }

    public function options()
    {
        return <<<DOC
[
    'limit' => 0,
    'prefix' => '',
    'table_view' => '',
    'wrapper_view' => '',
    'heading' => 'streams::table/partials/heading',
    'title' => '',
    'description' => '',
    'class'=> '',
    'container_class'=> '',
    'sortable' => false,
    'attributes' => [],
    'no_results_message' => 'streams::message.no_results',
    'filters' => [
        'filter_icon' => '',
        'filter_text' => '',
        'clear_icon' => '',
        'clear_text' => '',
    ]
]
DOC;
    }
}
