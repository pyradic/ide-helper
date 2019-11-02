<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\ClassDoc;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class ModuleCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(Module::class);
        $this->sections($class);
        $this->shortcuts($class);
        $class->clearTagsByName('property');

    }

    protected function sections(ClassDoc $class)
    {
        $button=Common::$button;
        $class->ensure('property', <<<DOC
array \$sections  = [
    \$section  => [
        'slug'        => 'blocks',
        'data-toggle' => 'modal',
        'data-target' => '#modal',
        'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',
        'href'        => 'admin/blocks/choose',
        'buttons' => [
            '',
            \$button => {$button},
        ],
        
        'sections' => [
            \$section => [
                'hidden'  => true,
                'href'    => '',
                'buttons' => [
                    '',
                    \$button => {$button},
                ],
            ],
        ],
    ],
]
DOC
        );
    }

    protected function shortcuts(ClassDoc $class)
    {
        $class->ensure('property', <<<DOC
array \$shortcuts  = [
    \$i => [
        'icon'  => 'fa fa-database',
        'href'  => '',
        'title' => '',
        'label' => '',
     ]
]
DOC
        );
    }
}
