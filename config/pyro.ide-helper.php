<?php

use Laradic\Idea\Toolbox\RoutesGenerator;
use Laradic\Idea\Toolbox\ViewsGenerator;
use Pyro\IdeHelper\DocBlocks\AddonCollectionDocBlocks;
use Pyro\IdeHelper\DocBlocks\AddonServiceProviderDocBlocks;
use Pyro\IdeHelper\DocBlocks\AuthDocBlocks;
use Pyro\IdeHelper\DocBlocks\ControlPanelDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryDomainsDocBlocks;
use Pyro\IdeHelper\DocBlocks\EntryModelDocBlocks;
use Pyro\IdeHelper\DocBlocks\ExtensionDocBlocks;
use Pyro\IdeHelper\DocBlocks\FieldTypeDocBlocks;
use Pyro\IdeHelper\DocBlocks\FormBuilderDocBlocks;
use Pyro\IdeHelper\DocBlocks\MigrationDocBlocks;
use Pyro\IdeHelper\DocBlocks\ModuleDocBlocks;
use Pyro\IdeHelper\DocBlocks\RequestDocBlocks;
use Pyro\IdeHelper\DocBlocks\TableBuilderDocBlocks;
use Pyro\IdeHelper\PhpToolbox\GenerateAddonCollectionsMeta;
use Pyro\IdeHelper\PhpToolbox\GenerateConfigMeta;
use Pyro\IdeHelper\PhpToolbox\GeneratePermissionsMeta;

/** @return array = \Pyro\IdeHelper\Examples\Examples::config() */
return [
    'toolbox'  => [
        'path'       => base_path('php-toolbox'),
        'streams'    => [
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
        'generators' => [
            [ 'description' => 'addon collections completions', 'class' => GenerateAddonCollectionsMeta::class ],
            [ 'description' => 'config completions', 'class' => GenerateConfigMeta::class, 'excludes' => [] ],
            [ 'description' => 'view completions', 'class' => ViewsGenerator::class ],
            [ 'description' => 'route completions', 'class' => RoutesGenerator::class ],
            [ 'description' => 'permission completions', 'class' => GeneratePermissionsMeta::class ],
        ],
    ],
    'docblock' => [
        'generators' => [
            AddonCollectionDocBlocks::class,
            AddonServiceProviderDocBlocks::class,
            AuthDocBlocks::class,
            new EntryDomainsDocBlocks(),
            EntryModelDocBlocks::class,
            FieldTypeDocBlocks::class,
            FormBuilderDocBlocks::class,
            MigrationDocBlocks::class,
            ExtensionDocBlocks::class,
            ModuleDocBlocks::class,
            RequestDocBlocks::class,
            ControlPanelDocBlocks::class,
            TableBuilderDocBlocks::class,
        ],
    ],
];
