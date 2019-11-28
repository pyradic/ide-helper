<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class FormBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(FormBuilder::class);
        $class->properties([
            'buttons'  => [ 'var', 'array = \\' . Examples::class . '::buttons()' ],
            'sections' => [ 'var', 'array = \\' . static::class . '::sections()' ],
            'actions'  => [ 'var', 'array = \\' . static::class . '::actions()' ],
            'options'  => [ 'var', 'array = \\' . static::class . '::options()' ],
        ]);
    }

    public static function sectionRow()
    {
        return [
            'columns' => [
                [
                    'classes' => '',
                    'size'    => 24,
                    'fields'  => [],
                    'html'    => '',
                    'view'    => '',
                ],
            ],
        ];
    }

    public static function sectionTab($row = null)
    {
        return [
            'title'  => '',
            'fields' => [],
            'icon'   => '',
            'html'   => '',
            'view'   => '',
            'rows'   => [
                $row => self::sectionRow(),
            ],
        ];
    }

    public static function sectionBase()
    {
        return [
            'view'       => '',
            'html'       => '',
            'stacked'    => true,
            'fields'     => [],
            'attributes' => [],
        ];
    }

    public static function section($row = null, $tab = null, $group = null)
    {
        $section             = static::sectionBase();
        $section[ 'rows' ]   = [
            $row => self::sectionRow(),
        ];
        $section[ 'tabs' ]   = [
            $tab => self::sectionTab(),
        ];
        $section[ 'groups' ] = [
            $group => static::section(),
        ];
        return $section;
    }

    public static function sections()
    {
        return [ static::section() ];
    }

    public static function sections2()
    {
        $rows             = <<<DOC
[
    [ 
        'columns' =>[ 
             [
                'classes' => '',
                'size' => 24,
                'fields' => [],
                'html' => '',
                'view' => ''
            ]
        ]
    ]
],
DOC;
        $tabs             = <<<DOC
[
    \$tab => [
        'title'  => '',
        'fields' => [],
        'icon' => '',
        'html' => '',
        'view' => '',
        'rows' => {$rows},
    ],
]
DOC;
        $formSectionStart = <<<DOC
        'view' => '',
        'html' => '',
        'stacked' => true, 
        'fields' => [],
        'attributes' => [],
        'rows' => {$rows},
        'tabs' => {$tabs},
DOC;

        $groups = <<<DOC
[
     [
        {$formSectionStart}
        'groups' => [],
     ]  
]
DOC;

        $formSection = <<<DOC
[     
        {$formSectionStart}
        'groups' => {$groups},
]
DOC;

        return $formSection;
    }

    public function actions($action = null)
    {
        /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry::$actions */
        return [
            'update'         => [
                'button' => 'update',
                'text'   => 'streams::button.update',
            ],
            'save_exit'      => [
                'button' => 'save',
                'text'   => 'streams::button.save_exit',
            ],
            'save_edit'      => [
                'button' => 'save',
                'text'   => 'streams::button.save_edit',
            ],
            'save_create'    => [
                'button' => 'save',
                'text'   => 'streams::button.save_create',
            ],
            'save_continue'  => [
                'button' => 'save',
                'text'   => 'streams::button.save_continue',
            ],
            'save_edit_next' => [
                'button' => 'save',
                'text'   => 'streams::button.save_edit_next',
            ],
            $action          => [
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
                'redirect'             => '',
                'permission'           => '',
                /**
                 * @see \Anomaly\Streams\Platform\Ui\Form\Command\SetDefaultOptions
                 * @see \Anomaly\Streams\Platform\Ui\Form\Command\MakeForm
                 */
                'form_view'            => 'streams::form/form',
                /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SetDefaultOptions */
                'wrapper_view'         => '',
                /**
                 * @see \Anomaly\Streams\Platform\Ui\Form\Command\SetDefaultOptions
                 * @see \Anomaly\Streams\Platform\Ui\Form\Command\LoadForm
                 */
                'layout_view'          => '',
                /** @see \Anomaly\Streams\Platform\Ui\Form\Command\LoadForm */
                'breadcrumb'           => '',
                /** @see \Anomaly\Streams\Platform\Ui\Form\Command\LoadForm */
                'data'                 => [],
                'prefix'               => '',
                'read_only'            => false,
                /** If provided, enables displaying the heading view with the given title */
                'title'                => '', // sadfsdf
                /** If provided, enables displaying the heading view with the given description */
                'description'          => '',
                /** Instead of using title/description, override the heading view itself */
                'heading'              => 'streams::table/partials/heading',
                'class'                => '',
                'container_class'      => '',
                /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SetSuccessMessage */
                'success_message'      => '',
                /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SetSuccessMessage */
                'success_message_type' => '',
            ];
    }
}
