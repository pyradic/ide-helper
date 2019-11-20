<?php

/** @return array = \Pyro\IdeHelper\Examples::config() */
return [
    'toolbox' => [
        'path'    => base_path('php-toolbox'),
        'streams' => [
            /*
             * Goto behaviour of field key values.
             * When doing [CTRL+click] or [CTRL+B] on a field key do:
             * - 'documentation'    :: open the configuration.md file of the field (eg core/anomaly/select-field_type/docs/en/01.introduction/02.configuration.md)
             * - 'field_type_class' :: open the FieldType class of the field (eg \Anomaly\SelectFieldType\SelectFieldType)
             * - 'model_class'      :: open the model the field belongs to (eg \Anomaly\SelectFieldType\SelectFieldType)
             * - false              :: disable goto behaviour
             */
            'field_goto_target' => 'documentation', // Goto [CTRL+click] on field key will open the configuration.md file of the field (eg core/anomaly/select-field_type/docs/en/01.introduction/02.configuration.md)
            'exclude'           => [ 'Anomaly\CommentsModule', 'Anomaly\DocumentationModule' ],
        ],
    ],
];
