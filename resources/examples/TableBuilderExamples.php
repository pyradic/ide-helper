<?php

namespace Pyro\IdeHelper\Examples;

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

class TableBuilderExamples
{

    public static function columns($i = null, $i2 = null)
    {
        return [
            $i  => [
                'wrapper'     => '',
                'entry'       => '',
                /**
                 * The table thead th title
                 * @see \Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser\HeadingsGuesser
                 */
                'heading'     => '',
                'value'       => '',
                'field'       => '',
                /** @see \Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder */
                'row_class'   => '',
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
                'filter'      => '',
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

    public static function action()
    {
        $action = [
            'handler'    => ActionHandler::class,
            'redirect'   => '',
            'action'     => Action::class,
            'slug'       => '',
            'size'       => 'sm',
            'class'      => '',
            'type'       => '',
            'icon'       => '',
            'text'       => '',
            'dropdown'   => '',
            'enabled'    => '',
            'disabled'   => '',
            'permission' => '',
            'attributes' => [],
            'button'     => Examples::button(),
            'button'     => Examples::buttons(),
        ];

        foreach (IconExamples::all() as $icon) {
            $action[ 'icon' ] = $icon;
        }
        return $action;
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
            null           => static::action(),
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
                'layout_view'        => '',
                /**
                 * @see \Anomaly\Streams\Platform\Ui\Table\Command\SetDefaultOptions
                 */
                'table_view'         => '',
                'wrapper_view'       => 'streams::',
                /** If provided, enables displaying the heading view with the given title */
                'title'              => '', // sadfsdf
                /** If provided, enables displaying the heading view with the given description */
                'description'        => '',
                /**
                 * Instead of using title/description, override the heading view itself
                 * @see  /etc/hosts
                 * @link /composer.json
                 */
                'heading'            => 'streams::table/partials/heading',
                'class'              => '',
                'container_class'    => '',
                /**
                 * Option to disable table views
                 * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder
                 */
                'enable_views'       => true,
                /**
                 * Option to disable pagination
                 * @see \Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePagination
                 */
                'enable_pagination'  => false,
                'sortable'           => false,
                'attributes'         => [],
                /** {@see \Anomaly\Streams\Platform\Ui\Table\TableAuthorizer} {@see \Anomaly\Streams\Platform\Ui\Table\Command\AuthorizeTable} */
                'permission'         => PermissionsExamples::permissions(),
                'no_results_message' => 'streams::message.no_results',
                'filters'            => [
                    'filter_icon' => Examples::icon(),
                    'filter_text' => '',
                    'clear_icon'  => Examples::icon(),
                    'clear_text'  => '',
                ],
            ];
    }

    public static function option()
    {
        return array_keys(static::options());
    }

    public static function view()
    {
        $view = [
            'slug'    => '',
            'text'    => '',
            'view'    => '',
            'icon'    => IconExamples::all(),
            /**
             * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewQueryInterface The interface that a query needs to implement
             * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\Query\RecentlyCreatedQuery An example query
             * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\QueryGuesser::guess() The query value is finalized here
             */
            'query'   => '',
            /**
             * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewHandlerInterface The interface that a view needs to implement
             * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\Type\RecentlyCreated An example view
             * @see \Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser\HandlerGuesser::guess() The handler value is finalized here
             */
            'handler' => '',

            /**
             * Appends a `tag` label to the item text, the `context` option can be used to provide the tag type
             * @see vendor/anomaly/streams-platform/resources/views/table/partials/views.twig
             */
            'label'   => '',
            /** The value of `context` is used for the `label` element classname. like so: `class="tag tag-{{ context }}"`  */
            'context' => '',

            'class'      => '',
            'attributes' => [],
            'buttons'    => Examples::buttons(),
            'actions'    => static::actions(),
            'options'    => static::options(),
        ];
        foreach (IconExamples::all() as $icon) {
            $view[ 'icon' ] = $icon;
        }
        return $view;
    }

    public static function views()
    {
        /** @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::$views */
        return [
            /** @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry */
            'all'               => [
                'slug' => 'all',
                'text' => 'streams::view.all',
                'view' => All::class,
            ],
            /** @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry */
            'trash'             => [
                'slug' => 'trash',
                'text' => 'streams::view.trash',
                'view' => Trash::class,
            ],
            /** @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry */
            'recently_created'  => [
                'slug' => 'recently_created',
                'text' => 'streams::view.recently_created',
                'view' => RecentlyCreated::class,
            ],
            /** @see \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry */
            'recently_modified' => [
                'slug' => 'recently_modified',
                'text' => 'streams::view.recently_modified',
                'view' => RecentlyModified::class,
            ],
            null                => static::view(),
        ];
    }
}
