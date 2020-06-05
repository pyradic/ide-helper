<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Crvs\Platform\Entry\EntryModel;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Examples\Examples;
use Pyro\IdeHelper\Examples\FieldTypeExamples;
use Pyro\IdeHelper\Examples\FormBuilderExamples;

class FormBuilderDocBlocks
{

    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(FormBuilder::class);
        //* @method $this on(string $trigger = \Pyro\IdeHelper\Examples\FormBuilderExamples::events()[null])
        $cd->cleanTag('method')
            ->ensureMethod('on', '$this', 'string $trigger = \\' . FormBuilderExamples::class . '::events()[null], $listener')
            ->ensureMethod('onReady', 'void', FormBuilder::class . ' $builder', 'Fires in {@see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::build() FormBuilder::build()}')
            ->ensureMethod('onBuilt', 'void', FormBuilder::class . ' $builder', 'Fires in {@see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::build() FormBuilder::build()}')
            ->ensureMethod('onPost', 'void', FormBuilder::class . ' $builder', 'Fires in {@see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::post() FormBuilder::post()}')
            ->ensureMethod('onSaving', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onSaved', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onValidating', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onValidated', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onPosting', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onSettingEntry', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onEntrySet', 'void', FormBuilder::class . ' $builder, \\' . EntryModel::class . ' $entry')
            ->ensureMethod('onQuerying', 'void', '\\' . FormBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $query')
            ->ensureMethod('onQueried', 'void', '\\' . FormBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $query');

        $cd->getProperty('buttons')->ensureVar('array', '= \\' . Examples::class . '::buttons()');
        $cd->getProperty('fields')->ensureVar('array', '= \\' . FieldTypeExamples::class . '::values()');
        $cd->getProperty('sections')->ensureVar('array', '= \\' . FormBuilderExamples::class . '::sections()');
        $cd->getProperty('actions')
            ->ensureVar('array', '= \\' . FormBuilderExamples::class . '::actions()')
            ->ensureSeeTag(\Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser::class . '::guess()', 'RedirectGuesser::guess()')
            ->ensureSeeTag(\Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry::class . '::$actions', 'ActionRegistry::$actions')
            ->setText($this->actionText);

        $cd->getProperty('options')->ensureVar('array', '= \\' . FormBuilderExamples::class . '::options()');
        $cd->getProperty('fields')->ensureVar('array', '= \\' . FormBuilderExamples::class . '::fields()');
        $cd->getMethod('getFields')->ensureReturn('array', '= \\' . FormBuilderExamples::class . '::fields()');
        $cd->getMethod('setFields')->ensureParam('$fields', 'array', '= \\' . FormBuilderExamples::class . '::fields()');
        $cd->getMethod('addField')->ensureParam('$field', 'string|array', '= \\' . FormBuilderExamples::class . '::field()');
        $cd->getMethod('addField')->ensureParam('$definition', 'array', '= \\' . FormBuilderExamples::class . '::field()');

        $cd->getMethod('setButtons')->ensureParam('$buttons', 'array', ' = \\' . FormBuilderExamples::class . '::buttons()');
        $cd->getMethod('getButtons')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::buttons()');
        $cd->getMethod('addButton')->ensureParam('$definition', 'array', ' = \\' . Examples::class . '::button()');

        $cd->getMethod('setSections')->ensureParam('$sections', 'array', ' = \\' . FormBuilderExamples::class . '::sections()');
        $cd->getMethod('setActions')
            ->ensureParam('$actions', 'array', ' = \\' . FormBuilderExamples::class . '::actions()')
            ->ensureSeeTag(\Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser::class . '::guess()', 'RedirectGuesser::guess()')
            ->ensureSeeTag(\Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry::class . '::$actions', 'ActionRegistry::$actions')
            ->ensureReturn('$this')
            ->setText($this->actionText);

        $cd->getMethod('setOption')->ensureParam('$key', 'string', ' = \\' . FormBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('hasOption')->ensureParam('$key', 'string', ' = \\' . FormBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('getOption')->ensureParam('$key', 'string', ' = \\' . FormBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('setOptions')->ensureParam('$options', 'array', ' = \\' . FormBuilderExamples::class . '::options()');
        $cd->getMethod('getSections')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::sections()');
        $cd->getMethod('getActions')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::actions()');
        $cd->getMethod('getOptions')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::options()');

    }

    protected $actionText = <<<EOF
Set the actions config.

Uses {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionDefaults::defaults() ActionDefaults::defaults()} if not set/empty


Can (optionally) use pre-defined actions registered at {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry::\$actions ActionRegistry}.
Note that some of them modify the form's redirect option as instructed by {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser::guess() RedirectGuesser::guess()}


The builder actions array is populated/modified using:
- {@see \Anomaly\Streams\Platform\Ui\Form\FormBuilder::make() FormBuilder::make()} [dispatches] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions BuildActions}
- {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions BuildActions} [runs] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder::build() ActionBuilder::build()}
- {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder::build() ActionBuilder::build()} [runs] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionInput::read() ActionInput::read()}


Once all values of the builder its actions array have been populated/modified.
It will create a class for each entry in the builder actions array and add it to the form:
- {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder::build() ActionBuilder::build()} [runs] {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionFactory::make() ActionFactory::make()}
- {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionFactory::make() ActionFactory::make()} [creates and hydrates] {@see \Anomaly\Streams\Platform\Ui\Table\Component\Action\Action Action} and {@see \Anomaly\Streams\Platform\Support\Hydrator Hydrator}
- {@see \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionFactory::build() ActionFactory::build()} [adds it to form] {@see \Anomaly\Streams\Platform\Ui\Form\Form Form}


```php
\$builder->setActions([
'save',
'save_exit'
]);
```

EOF;

}
