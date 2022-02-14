<?php

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Laradic\Generators\Doc\DocRegistry;

class FieldTypeDocBlocks
{
    public function handle(DocRegistry $registry, FieldTypeCollection $fieldTypes)
    {
        $fts = $fieldTypes->all();

        foreach ($fts as $ft) {
            try {
                if ( ! class_exists($ft, false)) {
                    continue;
                }
            } catch (\Throwable $e){
                continue;
            }
            $cd = $registry->getClass(get_class($ft));
            $this->ensureMethod($cd, $ft, 'getPresenter'); //, get_class($ft->getPresenter()));
            $this->ensureMethod($cd, $ft, 'getAccessor'); //, get_class($ft->getAccessor()));
            $this->ensureMethod($cd, $ft, 'getModifier'); //, get_class($ft->getModifier()));
            $this->ensureMethod($cd, $ft, 'getQuery'); //, get_class($ft->getQuery()));
            $this->ensureMethod($cd, $ft, 'getSchema'); //, get_class($ft->getSchema()));
            $this->ensureMethod($cd, $ft, 'getParser'); //, get_class($ft->getParser()));
        }
    }

    protected function ensureMethod($cd, $ft, $method)
    {
        try {
            $cd->ensureMethod($method, get_class($ft->{$method}()));
        }
        catch (\Throwable $e) {
        }
    }
}
