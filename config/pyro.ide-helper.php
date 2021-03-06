<?php

use Laradic\Idea\Toolbox\RoutesGenerator;
use Laradic\Idea\Toolbox\ViewsGenerator;
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
use Pyro\IdeHelper\PhpToolbox\AddonCollectionsGenerator;
use Pyro\IdeHelper\PhpToolbox\ConfigGenerator;
use Pyro\IdeHelper\PhpToolbox\PermissionsGenerator;

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
            [ 'description' => 'addon collections completions', 'class' => AddonCollectionsGenerator::class ],
            [ 'description' => 'config completions', 'class' => ConfigGenerator::class, 'excludes' => [] ],
            [ 'description' => 'view completions', 'class' => ViewsGenerator::class ],
            [ 'description' => 'route completions', 'class' => RoutesGenerator::class ],
            [ 'description' => 'permission completions', 'class' => PermissionsGenerator::class ],
        ],
    ],
    'examples' => [
        'path'       => resource_path('vendor/pyro/ide-helper'),
        'namespace'  => 'Pyro\IdeHelper\Examples',
        'generators' => [
            \Pyro\IdeHelper\Command\GenerateAddonCollectionExamples::class,
            \Pyro\IdeHelper\Command\GenerateFieldTypeExamples::class,
            \Pyro\IdeHelper\Command\GeneratePermissionsExamples::class,
            \Pyro\IdeHelper\Command\GenerateRoutesExamples::class,
        ],
        'files'      => [
            //'resources/examples/AddonCollectionExamples.php',
            'resources/examples/AddonServiceProviderExamples.php',
            'resources/examples/Examples.php',
            //'resources/examples/FieldTypeExamples.php',
            'resources/examples/FormBuilderExamples.php',
            'resources/examples/IconExamples.php',
            'resources/examples/mdi.php',
            'resources/examples/ModuleExamples.php',
            //'resources/examples/PermissionsExamples.php',
            //'resources/examples/RoutesExamples.php',
            'resources/examples/TableBuilderExamples.php',
        ],
    ],
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
                \Illuminate\Database\Eloquent\FactoryBuilder::class     => [],
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
