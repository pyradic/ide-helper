<?php

namespace Pyro\IdeHelper\Examples;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Action;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class FormBuilderExamples
{
    public static function field()
    {
        $field = [
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\EnabledGuesser */
            'enabled'      => true,
            'enabled'      => false,
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\DisabledGuesser */
            'disabled'     => true,
            'disabled'     => false,
            'field'        => '',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\LabelsGuesser */
            'label'        => '',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\WarningsGuesser */
            'warning'      => '',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\RequiredGuesser */
            'required'     => false,
            'rules'        => [
                /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\UniqueGuesser */
                'unique'   => false,
                'unique'   => '<field>',
                'unique'   => [],
                'unique:<field>',
                'unique:<table>:<field>',
                /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\NullableGuesser */
                'nullable' => false,
            ],
            'value'        => null,
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\ReadOnlyGuesser */
            'read_only'    => false,
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\ReadOnlyGuesser */
            'read_only'    => true,
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\TranslatableGuesser */
            'translatable' => false,
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\TranslatableGuesser */
            'translatable' => true,
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\InstructionsGuesser */
            'instructions' => '',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\PlaceholdersGuesser */
            'placeholder'  => '',
            'config'       => FieldTypeExamples::configs(),
        ];

        $types = array_combine(FieldTypeExamples::types(), array_values(FieldTypeExamples::configs()));
        foreach ($types as $type => $config) {
            $field[ 'type' ]   = $type;
            $field[ 'config' ] = $config;
        }

        return $field;
    }

    public static function fields()
    {
        return [ static::field(), null => static::field() ];
    }

    public static function events()
    {

        return [
            'validating',
            'validated',
            /** @see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::build() */
            'ready',
            /** @see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::build() */
            'built',
            /** @see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::make() */
            'make',
            /** @see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::post() */
            'post',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Command\PostForm::handle() */
            'posting',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Command\PostForm::handle() */
            'posted',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SaveForm::handle() */
            'saving',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SaveForm::handle() */
            'saved',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SetFormEntry::handle() */
            'setting_entry',
            /** @see \Anomaly\Streams\Platform\Ui\Form\Command\SetFormEntry::handle() */
            'entry_set',
        ];
    }

    public static function sectionRow()
    {
        return [
            'columns' => [
                null => [
                    'classes' => '',
                    'size'    => 24,
                    'fields'  => [],
                    'html'    => '',
                    'view'    => '',
                    'groups'  => [
                        null => static::section(),
                    ],
                    'tabs'    => [
                        null => static::sectionTab(),
                    ],
                    'rows'    => [
                        null => static::sectionRow(),
                    ],
                ],
            ],
        ];
    }

    public static function sectionTab($row = null)
    {
        $tab = [
            'title'  => '',
            'fields' => [],
            'icon'   => '',
            'html'   => '',
            'view'   => '',
            'rows'   => [
                $row => self::sectionRow(),
            ],
        ];

        foreach (IconExamples::all() as $icon) {
            $tab[ 'icon' ] = $icon;
        }
        return $tab;
    }

    public static function sectionBase()
    {
        return IconExamples::mergeWith([
            'view'                 => '',
            'html'                 => '',
            'icon'                 => Examples::icon(),
            'title'                => '',
            'description'          => '',
            'attributes'           => [],
            'classes'              => [],
            'container_classes'    => [],
            'container_attributes' => [],
            /**
             * Only in groups. Defaults to 'deck'
             * @see form/partials/groups.twig
             * @example
             * `class="card-{{ section.type ?: 'deck' }}"`
             */
            'type'                 => '',
            'stacked'              => true,
            'fields'               => [],
        ]);
    }

    public static function section($row = null, $tab = null, $group = null)
    {
        $section             = static::sectionBase();
        $section[ 'rows' ]   = [
            $row => static::sectionRow(),
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

    public static function actions($action = null)
    {
        /**
         * Set the actions config.
         *
         * Uses {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionDefaults::defaults() ActionDefaults::defaults()} if not set/empty
         *
         *
         * Can (optionally) use pre-defined actions registered at {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry::$actions ActionRegistry}. Note that some of them modify the form's redirect option as instructed by {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser::guess() RedirectGuesser::guess()}
         *
         *
         * The builder actions array is populated/modified using:
         * - {@see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::make() FormBuilder::make()} [dispatches] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions BuildActions}
         * - {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions BuildActions} [runs] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder::build() ActionBuilder::build()}
         * - {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder::build() ActionBuilder::build()} [runs] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionInput::read() ActionInput::read()}
         *
         *
         * Once all values of the builder its actions array have been populated/modified.
         * It will create a class for each entry in the builder actions array and add it to the form:
         * - {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder::build() ActionBuilder::build()} [runs] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionFactory::make() ActionFactory::make()}
         * - {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionFactory::make() ActionFactory::make()} [creates and hydrates] {@see \Anomaly\Streams\Platform\Ui\Table\Component\Action\Action Action} and {@see \Anomaly\Streams\Platform\Support\Hydrator Hydrator}
         * - {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionFactory::build() ActionFactory::build()} [adds it to form] {@see \Anomaly\Streams\Platform\Ui\Form\Form Form}
         *
         *
         * ```php
         * $builder->setActions([
         * 'save',
         * 'save_exit'
         * ]);
         * ```
         *
         * @param array $actions = \Pyro\IdeHelper\Examples\FormBuilderExamples::actions()
         *
         * @return $this
         * @see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser::guess() RedirectGuesser::guess()
         *
         * @see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry::$actions ActionRegistry::$actions
         *
         */
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
            null             => static::action(),
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
            'attributes' => [],
            'button'     => Examples::button(),
            'button'     => Examples::buttons(),
        ];
        $action = IconExamples::mergeWith($action);
        return $action;
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

    public static function option()
    {
        return array_keys(static::options());
    }
}
