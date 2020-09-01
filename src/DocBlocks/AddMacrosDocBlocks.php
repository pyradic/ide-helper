<?php

namespace Pyro\IdeHelper\DocBlocks;

use Laradic\Generators\Doc\Block\MacrosDocBlock;
use Laradic\Generators\Doc\DocRegistry;

class AddMacrosDocBlocks
{
    /** @var array */
    protected $classes;

    public function __construct(array $classes = [])
    {
        $this->classes = $classes;
    }

    public function handle(DocRegistry $registry)
    {
        foreach ($this->classes as $class => $exclude) {
            (new MacrosDocBlock($class, $exclude))->generate($registry);
        }
    }

}
