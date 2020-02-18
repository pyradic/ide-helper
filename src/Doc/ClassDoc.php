<?php

namespace Pyro\IdeHelper\Doc;

use ReflectionClass;

class ClassDoc
{
    /** @var string */
    protected $className;

    /** @var \ReflectionClass */
    protected $reflection;

    /** @var DocBlock */
    protected $docblock;

    public function __construct($className)
    {
        $this->className  = $className;
        $this->reflection = new ReflectionClass($className);
        $this->docblock   = new Docblock($this->reflection);
    }

    public function ensureProperty($name, $type, $arguments = null)
    {
        $this->docblock->getTagsByName('property');
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getReflection()
    {
        return $this->reflection;
    }

    public function getDocblock()
    {
        return $this->docblock;
    }


}
