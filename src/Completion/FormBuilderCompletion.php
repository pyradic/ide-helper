<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class FormBuilderCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        $class = $generator->class(FormBuilder::class);
        $class->cleanTag('property');
        $class->properties([
            'buttons'  => [ 'var', 'array =' . Common::buttons() ],
            'sections' => [ 'var', 'array = ' . Common::formSection() ],
            'actions'  => [ 'var', 'array = [\$i => []' ],
            'options'  => [ 'var', 'array = [\$i => []' ],
        ]);
    }

}
