<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\ClassDoc;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class FormBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(FormBuilder::class);
        $this->sections($class);
        $this->actions($class);
        $this->buttons($class);
        $this->options($class);
        //fields
        //rules
        $class->clearTagsByName('property');

    }

    protected function sections(ClassDoc $class)
    {
        $section=Common::formSection();
        $class->ensure('property', <<<DOC
array \$sections  = [
    \$i => {$section}
]
DOC
        );

    }

    protected function actions(ClassDoc $class)
    {
        $class->ensure('property', <<<DOC
array \$actions  = [
    \$i => []
]
DOC
        );
    }

    protected function buttons(ClassDoc $class)
    {
        $button = Common::$button;
        $class->ensure('property', <<<DOC
array \$buttons  = [
    \$button => {$button}
]
DOC
        );
    }

    protected function options(ClassDoc $class)
    {
        $class->ensure('property', <<<DOC
array \$options  = [
    \$i => []
]
DOC
        );
    }
}
