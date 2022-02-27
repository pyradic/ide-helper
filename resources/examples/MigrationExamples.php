<?php

namespace Pyro\IdeHelper\Examples;

class MigrationExamples
{
    public static function assignments($field = null)
    {
        return [
            $field => [
                'config'       => array_values(FieldTypeExamples::configs()),
                'unique'       => false,
                'required'     => false,
                'searchable'   => false,
                'translatable' => false,
                'versionable'  => false,
                'sort_order'   => false,
            ],
        ];
    }
}
