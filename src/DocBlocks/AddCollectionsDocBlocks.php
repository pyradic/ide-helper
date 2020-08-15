<?php

namespace Pyro\IdeHelper\DocBlocks;

use Laradic\Generators\Doc\Block\CollectionDocBlock;
use Laradic\Generators\Doc\DocRegistry;

class AddCollectionsDocBlocks
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
            (new CollectionDocBlock($collection, $item))->generate($registry);
        }
    }

}
