<?php

use Pyro\IdeHelper\DocBlocks\AddCollectionMacrosDocBlocks;
use Pyro\IdeHelper\DocBlocks\AddCollectionsDocBlocks;
use Pyro\IdeHelper\DocBlocks\AddMacrosDocBlocks;
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

/** @return array = \Pyro\IdeHelper\Examples\Examples::config() */
return [
    'models'  => [
        'ignore_properties' => [ 'translations', 'versions' ],
        'ignore_methods'    => [ 'cache', 'translate', 'call', 'translated', 'translatedIn' ],
    ],
    /*
     * Toolbox relies on `php-toolbox` plugin to work
     * Intelij: https://plugins.jetbrains.com/plugin/8133-php-toolbox
     */
    'toolbox' => [
        /** The path where all generated files will be written to. should not be modified */
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
        /** This overrides the 'laradic.idea.toolbox.generators' config  */
        'generators' => [
            \Laradic\Idea\Toolbox\ConfigGenerator::class                       => [
                'description' => 'Laravel config completions',
                'directory'   => 'laravel/config',
            ],
            \Laradic\Idea\Toolbox\RoutesGenerator::class                       => [
                'description' => 'Route completions',
                'directory'   => 'laravel/routes',
            ],
            \Laradic\Idea\Toolbox\ViewsGenerator::class                        => [
                'description'       => 'View completions',
                'directory'         => 'laravel/views',
                'excludeNamespaces' => [ 'storage', 'root' ],
            ],
            \Pyro\IdeHelper\PhpToolbox\AddonCollectionsToolboxGenerator::class => [
                'description' => 'addon collections completions',
                'directory'   => 'pyro/addon_collections',
            ],
            \Pyro\IdeHelper\PhpToolbox\PyroConfigToolboxGenerator::class       => [
                'description' => 'PyroCMS config completions',
                'directory'   => 'pyro/config',
                'excludes'    => [],
            ],
            \Pyro\IdeHelper\PhpToolbox\PermissionsToolboxGenerator::class      => [
                'description' => 'permission completions',
                'directory'   => 'pyro/permissions',
            ],
            \Pyro\IdeHelper\PhpToolbox\ResourcesToolboxGenerator::class        => [
                'description' => 'resources completions',
                'directory'   => 'pyro/resources',
            ],
        ],
    ],
    /*
     * Example files are used in docblocks where the type is array. This relies on the `deep-assoc-completion` plugin to work.
     * VSCode: https://marketplace.visualstudio.com/items?itemName=klesun.deep-assoc-completion-vscode
     * Intelij: https://plugins.jetbrains.com/plugin/9927-deep-assoc-completion/
     */
    'examples' => [
        'path'        => resource_path('vendor/pyro/ide-helper'),
        /** The path where all example files will be written to */
        'output_path' => resource_path('vendor/pyro/ide-helper'),
        /** the namespace all example files should have */
        'namespace'   => 'Pyro\IdeHelper\Examples',
        /* generated example files will by copied to output path with the given namespace */
        'generators'  => [
            \Pyro\IdeHelper\ExampleGenerators\GenerateAddonCollectionExamples::class,
            \Pyro\IdeHelper\ExampleGenerators\GenerateFieldTypeExamples::class,
            \Pyro\IdeHelper\ExampleGenerators\GeneratePermissionsExamples::class,
            \Pyro\IdeHelper\ExampleGenerators\GenerateRoutesExamples::class,
            \Pyro\IdeHelper\ExampleGenerators\GenerateConfigExamples::class,
            \Pyro\IdeHelper\ExampleGenerators\GenerateSettingsExamples::class,
            \Pyro\IdeHelper\ExampleGenerators\GenerateViewExamples::class,
        ],
        /* hand made example files will by copied to output path. With the namespace corrected */
        'files'       => [
            __DIR__ . '/../resources/examples/AddonServiceProviderExamples.php',
            __DIR__ . '/../resources/examples/Examples.php',
            __DIR__ . '/../resources/examples/FormBuilderExamples.php',
            __DIR__ . '/../resources/examples/IconExamples.php',
            __DIR__ . '/../resources/examples/mdi.php',
            __DIR__ . '/../resources/examples/MigrationExamples.php',
            __DIR__ . '/../resources/examples/ModuleExamples.php',
//            __DIR__ . '/../resources/examples/SettingsExamples.php',
            __DIR__ . '/../resources/examples/TableBuilderExamples.php',
        ],
    ],
    /*
     * Docblock generators do not rely on any addon and are compatible with all IDEs.
     * They modify docblocks for A LOT of files.
     * This provideds not just code-completion, but better refactoring results as wel!!!
     */
    'docblock' => [
        'generators' => [
            AddonCollectionDocBlocks::class,
            AddonServiceProviderDocBlocks::class,
            AuthDocBlocks::class,
            new EntryDomainsDocBlocks(),
            new AddMacrosDocBlocks([
                \Illuminate\Database\Schema\Blueprint::class            => [],
                \Illuminate\Support\Arr::class                          => [],
                \Illuminate\Support\Carbon::class                       => [],
                \Carbon\Carbon::class                                   => [],
                \Carbon\CarbonImmutable::class                          => [],
                \Carbon\CarbonInterval::class                           => [],
                \Carbon\CarbonPeriod::class                             => [],
                \Illuminate\Support\Collection::class                   => [],
                \Illuminate\Console\Command::class                      => [],
                \Illuminate\Console\Scheduling\Event::class             => [],
                \Illuminate\Filesystem\Filesystem::class                => [],
                \Illuminate\Mail\Mailer::class                          => [],
                \Illuminate\Routing\Redirector::class                   => [],
                \Illuminate\Database\Eloquent\Relations\Relation::class => [],
                \Illuminate\Cache\Repository::class                     => [],
                \Illuminate\Routing\ResponseFactory::class              => [],
                \Illuminate\Routing\Route::class                        => [],
                \Illuminate\Routing\Router::class                       => [],
                \Illuminate\Validation\Rule::class                      => [],
                \Illuminate\Support\Str::class                          => [],
                \Illuminate\Translation\Translator::class               => [],
                \Illuminate\Routing\UrlGenerator::class                 => [],
                \Illuminate\Database\Query\Builder::class               => [],
                \Illuminate\Http\JsonResponse::class                    => [],
                \Illuminate\Http\RedirectResponse::class                => [],
                \Illuminate\Auth\RequestGuard::class                    => [],
                \Illuminate\Http\Response::class                        => [],
                \Illuminate\Auth\SessionGuard::class                    => [],
                \Illuminate\Http\UploadedFile::class                    => [],
            ]),
            new AddCollectionsDocBlocks([
                // MyCollection::class => MyCollectionItem::class
                \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection::class  => \Anomaly\Streams\Platform\Ui\Form\Component\Action\Action::class,
                \Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionCollection::class => \Anomaly\Streams\Platform\Ui\Table\Component\Action\Action::class,
                \Anomaly\Streams\Platform\Ui\Button\ButtonCollection::class                 => \Anomaly\Streams\Platform\Ui\Button\Button::class,
                \Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection::class    => \Anomaly\Streams\Platform\Addon\FieldType\FieldType::class,
                \Anomaly\Streams\Platform\Field\FieldCollection::class                      => \Anomaly\Streams\Platform\Field\Contract\FieldInterface::class,
            ]),
            new AddCollectionMacrosDocBlocks([
                // MyCollection::class => MyCollectionItem::class
            ]),
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
