<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Laradic\Generators\Doc\Doc\ClassDoc;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Examples\ModuleExamples;

class ModuleDocBlocks
{
    public function handle(DocRegistry $registry)
    {
        $cd = $registry->getClass(Module::class);
        $cd->cleanTag('method')
            ->ensureMethod('onUninstalling', 'void', Module::class . ' $module')
            ->ensureMethod('onUninstalled', 'void', Module::class . ' $module')
            ->ensureMethod('onInstalling', 'void', Module::class . ' $module')
            ->ensureMethod('onInstalled', 'void', Module::class . ' $module')
            ->ensureMethod('onMigrating', 'void', Module::class . ' $module')
            ->ensureMethod('onMigrated', 'void', Module::class . ' $module');
        $cd->getProperty('sections')->ensureVar('array', '= \\' . ModuleExamples::class . '::sections()');
        $cd->getProperty('shortcuts')->ensureVar('array', '= \\' . ModuleExamples::class . '::shortcuts()');
        $cd->getMethod('setSections')->ensureParam('sections', 'array', '= \\' . ModuleExamples::class . '::sections()');
        $cd->getMethod('addSection')->ensureParam('section', 'array', '= \\' . ModuleExamples::class . '::section()');
        $cd->getMethod('setShortcuts')->ensureParam('shortcuts', 'array', '= \\' . ModuleExamples::class . '::shortcuts()');
        $cd->getMethod('addShortcut')->ensureParam('shortcut', 'array', '= \\' . ModuleExamples::class . '::shortcut()');
        $cd->getMethod('getSections')->ensureReturn('array', '= \\' . ModuleExamples::class . '::sections()');
        $cd->getMethod('getShortcuts')->ensureReturn('array', '= \\' . ModuleExamples::class . '::shortcuts()');
    }
}
