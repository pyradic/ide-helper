<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\ClassDoc;
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
        $class->clearTagsByName('property');

    }

    protected function sections(ClassDoc $class)
    {
        $class->ensure('property', <<<DOC
array \$sections  = [
    \$i => []
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
    \$i => {$button}
]
DOC
        );
    }

    protected function filters(ClassDoc $class)
    {
        $class->ensure('property', <<<DOC
array \$filters  = [
    \$i => []
]
DOC
        );
    }
}
