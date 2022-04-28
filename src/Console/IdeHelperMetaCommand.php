<?php

namespace Pyro\IdeHelper\Console;

class IdeHelperMetaCommand extends \Barryvdh\LaravelIdeHelper\Console\MetaCommand
{
    protected function getAbstracts()
    {
        $exclude = config('pyro.ide-helper.metas.exclude', []);
        $keys =  parent::getAbstracts();
        $keys= array_filter($keys, fn($key) => !in_array($key, $exclude,true));
        return $keys;
    }

}
