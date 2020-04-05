<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Examples\Examples;
use Pyro\IdeHelper\Examples\FieldTypeExamples;
use Pyro\IdeHelper\Examples\FormBuilderExamples;

class FormBuilderDocBlocks
{

    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(FormBuilder::class);

        $cd->cleanTag('method')
            ->ensureMethod('onReady', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onBuilt', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onPost', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onSaving', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onSaved', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onValidating', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onValidated', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onPosting', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onSettingEntry', 'void', FormBuilder::class . ' $builder')
            ->ensureMethod('onEntrySet', 'void', FormBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $entry')
            ->ensureMethod('onQuerying', 'void', '\\' . FormBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $query')
            ->ensureMethod('onQueried', 'void', '\\' . FormBuilder::class . ' $builder, \\' . EntryQueryBuilder::class . ' $query');

        $cd->getProperty('buttons')->ensureVar('array', '= \\' . Examples::class . '::buttons()');
        $cd->getProperty('fields')->ensureVar('array', '= \\' . FieldTypeExamples::class . '::values()');
        $cd->getProperty('sections')->ensureVar('array', '= \\' . FormBuilderExamples::class . '::sections()');
        $cd->getProperty('actions')->ensureVar('array', '= \\' . FormBuilderExamples::class . '::actions()');
        $cd->getProperty('options')->ensureVar('array', '= \\' . FormBuilderExamples::class . '::options()');

        $cd->getMethod('setButtons')->ensureParam('$buttons', 'array', ' = \\' . FormBuilderExamples::class . '::buttons()');
        $cd->getMethod('setSections')->ensureParam('$sections', 'array', ' = \\' . FormBuilderExamples::class . '::sections()');
        $cd->getMethod('setActions')->ensureParam('$actions', 'array', ' = \\' . FormBuilderExamples::class . '::actions()');
        $cd->getMethod('setOption')->ensureParam('$key', 'string', ' = \\' . FormBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('hasOption')->ensureParam('$key', 'string', ' = \\' . FormBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('getOption')->ensureParam('$key', 'string', ' = \\' . FormBuilderExamples::class . '::option()[$any]');
        $cd->getMethod('setOptions')->ensureParam('$options', 'array', ' = \\' . FormBuilderExamples::class . '::options()');
        $cd->getMethod('getButtons')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::buttons()');
        $cd->getMethod('getSections')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::sections()');
        $cd->getMethod('getActions')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::actions()');
        $cd->getMethod('getOptions')->ensureReturn('array', ' = \\' . FormBuilderExamples::class . '::options()');

        $cd->getMethod('addButton')->ensureParam('$definition', 'array', ' = \\' . Examples::class . '::button()');
    }

}
