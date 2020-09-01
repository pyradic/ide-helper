<?php

namespace Pyro\IdeHelper\DocBlocks;

use Laradic\Generators\Doc\Block\CollectionMacrosDocBlock;
use Laradic\Generators\Doc\DocRegistry;

class AddCollectionMacrosDocBlocks
{
    /** @var array */
    protected $collections;

    public function __construct(array $collections = [])
    {
        $this->collections = $collections;
    }

    public function handle(DocRegistry $registry)
    {
        foreach ($this->collections as $collection => $item) {
            (new CollectionMacrosDocBlock($collection, $item))->generate($registry);
        }
    }

}
