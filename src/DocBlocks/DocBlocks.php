<?php

namespace Pyro\IdeHelper\DocBlocks;

class DocBlocks
{
    public function getNamespace()
    {
        return config('pyro.ide-helper.examples.namespace');
    }

    public function exampleClass(string $className, ?string $methodName = null)
    {
        $example = '\\' . $this->getNamespace() . '\\' . $className;
        if ($methodName !== null) {
            $example .= '::' . $methodName . '()';
        }
        return $example;
    }
}
