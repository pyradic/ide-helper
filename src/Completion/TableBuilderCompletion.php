<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Edit;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Export;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\ForceDelete;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Reorder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\DatetimeFilter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\FieldFilter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\InputFilter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\SearchFilter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\SelectFilter;
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
            'buttons' => [ 'var', 'array = \\' . Examples::class . '::buttons()' ],
            'actions' => [ 'var', 'array = \\' . static::class . '::actions()' ],
            'options' => [ 'var', 'array = \\' . static::class . '::options()' ],
            'filters' => [ 'var', 'array = \\' . static::class . '::filters()' ],
            'views'   => [ 'var', 'array = \\' . static::class . '::views()' ],
            'columns' => [ 'var', 'array = \\' . static::class . '::columns()' ],
        ]);
        $class->cleanTag('method');
        $class->methods([
            'setButtons'  => [ 'param', 'array $buttons = \\' . static::class . '::buttons()' ],
            'getButtons'  => [ 'return', 'array = \\' . static::class . '::buttons()' ],
            'setActions'  => [ 'param', 'array $actions = \\' . static::class . '::actions()' ],
            'getActions'  => [ 'return', 'array = \\' . static::class . '::actions()' ],
            'setOptions'  => [ 'param', 'array $options = \\' . static::class . '::options()' ],
            'getOptions'  => [ 'return', 'array = \\' . static::class . '::options()' ],
        ]);
    }

    public static function columns($i = null, $i2 = null)
    {
        return [
            $i  => [
                'wrapper'     => '',
                'entry'       => '',
                'heading'     => '',
                'value'       => '',
                'field'       => '',
                'sort_column' => 'name',
            ],
            $i2 => [
                'value' => [ '(column)' => '' ],
            ],
        ];
    }

    public static function filters($filter = null)
    {
        /** @see \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::$filters */
        return [

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
            $filter      => [
                'slug'        => '',
                'field'       => '',
                'stream'      => '',
                'prefix'      => '',
                'exact'       => '',
                'active'      => '',
                'column'      => '',
                'placeholder' => '',
                'query'       => '',
            ],
        ];
    }

    public static function actions($action = null)
    {
        /** @see \Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionRegistry::$actions */
        return [
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
            $action        => [
                'handler'    => ActionHandler::class,
                'redirect'   => '',
                'action'     => Action::class,
                'slug'       => '',
                'size'       => 'sm',
                'class'      => '',
                'type'       => '',
                'icon'       => Examples::icon(),
                'text'       => '',
                'dropdown'   => '',
                'enabled'    => '',
                'disabled'   => '',
                'permission' => '',
                'attributes' => [],
                'button'     => Examples::button(),
                'button'     => Examples::buttons(),
            ],
        ];
    }

    public static function options()
    {
        return
            [
                'limit'              => 0,
                'prefix'             => '',
                /**
                 * @see \Anomaly\Streams\Platform\Ui\Table\Command\LoadTable
                 */
                'layout_view'         => '',
                /**
                 * @see \Anomaly\Streams\Platform\Ui\Table\Command\SetDefaultOptions
                 */
                'table_view'         => '',
                'wrapper_view'       => '',
                /** If provided, enables displaying the heading view with the given title */
                'title'              => '', // sadfsdf
                /** If provided, enables displaying the heading view with the given description */
                'description'        => '',
                /**
                 * Instead of using title/description, override the heading view itself
                 *
                 * @see  /etc/hosts
                 * @link /composer.json
                 */
                'heading'            => 'streams::table/partials/heading',
                'class'              => '',
                'container_class'    => '',
                'sortable'           => false,
                'attributes'         => [],
                'no_results_message' => 'streams::message.no_results',
                'filters'            => [
                    'filter_icon' =>  Examples::icon(),
                    'filter_text' => '',
                    'clear_icon'  => Examples::icon(),
                    'clear_text'  => '',
                ],
            ];
    }

    public static function views($view = null)
    {
        /** @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::$views */
        return [
            'all'               => [
                'slug' => 'all',
                'text' => 'streams::view.all',
                'view' => All::class,
            ],
            'trash'             => [
                'slug' => 'trash',
                'text' => 'streams::view.trash',
                'view' => Trash::class,
            ],
            'recently_created'  => [
                'slug' => 'recently_created',
                'text' => 'streams::view.recently_created',
                'view' => RecentlyCreated::class,
            ],
            'recently_modified' => [
                'slug' => 'recently_modified',
                'text' => 'streams::view.recently_modified',
                'view' => RecentlyModified::class,
            ],
            $view               => [
                'slug'    => '',
                'text'    => '',
                'view'    => '',
                'query'   => '',
                'icon'         => Examples::icon(),
                'class'   => '',
                'attributes' => [],
                'buttons' => Examples::buttons(),
                'actions' => static::actions(),
                'options' => static::options(),
            ],
        ];
    }
}
