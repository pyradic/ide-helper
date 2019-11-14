<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\ClassDoc;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
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
        $class->cleanTag('property');

    }

    protected function sections(ClassDefinition $class)
    {
        $section=Common::formSection();
        $class->ensureTag('property', <<<DOC
array \$sections  = [
    \$i => {$section}
]
DOC
        );

    }

    protected function actions(ClassDefinition $class)
    {
        $class->ensureTag('property', <<<DOC
array \$actions  = [
    \$i => []
]
DOC
        );
    }

    protected function buttons(ClassDefinition $class)
    {
        $button = Common::$button;
        $class->ensureTag('property', <<<DOC
array \$buttons  = [
    \$button => {$button}
]
DOC
        );
    }

    protected function options(ClassDefinition $class)
    {
        $class->ensureTag('property', <<<DOC
array \$options  = [
    \$i => []
]
DOC
        );
    }
}
