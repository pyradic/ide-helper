<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Laradic\Generators\Doc\DocRegistry;

class ExtensionDocBlocks
{
    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(Extension::class);
        $cd->cleanTag('method')
            ->ensureMethod('onUninstalling', 'void', Extension::class . ' $extension')
            ->ensureMethod('onUninstalled', 'void', Extension::class . ' $extension')
            ->ensureMethod('onInstalling', 'void', Extension::class . ' $extension')
            ->ensureMethod('onInstalled', 'void', Extension::class . ' $extension')
            ->ensureMethod('onMigrating', 'void', Extension::class . ' $extension')
            ->ensureMethod('onMigrated', 'void', Extension::class . ' $extension');
    }
}
