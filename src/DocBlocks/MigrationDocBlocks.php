<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Examples\FieldTypeExamples;

class MigrationDocBlocks
{

    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(Migration::class);
        $cd->getProperty('fields')->ensureVar('array',' = \\' . FieldTypeExamples::class . '::fields()');
    }
}
