<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationLink;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Section;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanel;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Laradic\Generators\Doc\Block\CollectionDocBlock;
use Laradic\Generators\Doc\DocRegistry;

class ControlPanelDocBlocks
{
    static $collections = [
        [NavigationCollection::class, NavigationLink::class],
        [SectionCollection::class, Section::class],
        [ButtonCollection::class, Button::class],
    ];

    public function handle(DocRegistry $registry)
    {
        foreach(static::$collections as $c) {
            $cdb = new CollectionDocBlock($c[0], $c[1]);
            $cdb->generate($registry);
        }


        $cd=$registry->getClass(ControlPanel::class);
        $cd->getMethod('getNavigation')->ensureReturn([NavigationCollection::class, NavigationLink::class . '[]']);
        $cd->getMethod('getSections')->ensureReturn([SectionCollection::class, Section::class . '[]']);
        $cd->getMethod('getButtons')->ensureReturn([ButtonCollection::class, \Crvs\Platform\Ui\ControlPanel\Component\Button::class . '[]']);


        $cd=$registry->getClass(ControlPanelBuilder::class);
        $cd->getMethod('getControlPanelNavigation')->ensureReturn([NavigationCollection::class, NavigationLink::class . '[]']);
        $cd->getMethod('getControlPanelSections')->ensureReturn([SectionCollection::class, Section::class . '[]']);

    }
}
