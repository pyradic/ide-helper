<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class TableBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(TableBuilder::class);
        $this->sections($class);
        $this->options($class);
        $this->actions($class);
        $this->buttons($class);
        $this->filters($class);
        $class->cleanTag('property');

    }

    protected function sections(ClassDefinition $class)
    {
        $class->ensureTag('property', <<<DOC
array \$sections  = [
    \$i => []
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
    \$i => {$button}
]
DOC
        );
    }

    protected function filters(ClassDefinition $class)
    {
        $class->ensureTag('property', <<<DOC
array \$filters  = [
    \$i => []
]
DOC
        );
    }
}
