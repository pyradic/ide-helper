<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Laradic\Generators\Doc\DocRegistry;

class EntryModelDocBlocks
{
    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(EntryModel::class);
        $cd->getMethod('getAssignments')
            ->ensureReturn([ AssignmentCollection::class, AssignmentModel::class . '[]' ]);
    }
}
