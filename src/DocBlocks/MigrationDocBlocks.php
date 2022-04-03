<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Laradic\Generators\Doc\DocRegistry;

class MigrationDocBlocks extends DocBlocks
{

    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(Migration::class);
        $cd->getProperty('fields')->ensureVar('array', ' = ' . $this->exampleClass('FieldTypeExamples', 'fields'));
        $cd->getProperty('assignments')->ensureVar('array', ' = ' . $this->exampleClass('MigrationExamples', 'assignments'));
    }
}
