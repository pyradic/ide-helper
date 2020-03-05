<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Examples\AddonServiceProviderExamples;

class AddonServiceProviderDocBlocks
{
    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(AddonServiceProvider::class);
        $cd->getProperty('routes')->ensureVar('array', '= \\' . AddonServiceProviderExamples::class . '::routes()');
        $cd->getMethod('getRoutes')->ensureReturn('array', '= \\' . AddonServiceProviderExamples::class . '::routes()');
    }

}
