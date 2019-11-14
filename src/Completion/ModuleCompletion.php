<?php

namespace Pyro\IdeHelper\Completion;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Generators\DocBlock\DocBlockGenerator;

class ModuleCompletion implements CompletionInterface
{
    public function generate(DocBlockGenerator $generator)
    {
        list($section, $shortcut) = Common::get([ 'moduleSection', 'moduleShortcut' ]);
        $class = $generator->class(Module::class)
            ->cleanTag('property')
//            ->ensure('property', "array \$sections  = [ \$section  => {$section} ]")
//            ->ensure('property', "array \$shortcuts  = [ \$i => {$shortcut} ]")
            ->properties([
                'sections' => [ 'var', "array = [ \$i => {$section} ]" ],
            ])
            ->methods([
                'getSections'  => [ 'return', "array = [ \$i => {$section} ]" ],
                'setSections'  => [ 'param', "array \$sections = [ \$i => {$section} ]" ],
                'getShortcuts' => [ 'return', "array = [ \$i => {$shortcut} ]" ],
                'setShortcuts' => [ 'param', "array \$shortcuts = [ \$i => {$shortcut} ]" ],
            ]);
    }
}
