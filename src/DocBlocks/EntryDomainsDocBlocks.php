<?php /** @noinspection ContractViolationInspection */

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Laradic\Generators\Doc\Block\CollectionDocBlock;
use Laradic\Generators\Doc\Doc\ClassDoc;
use Laradic\Generators\Doc\DocRegistry;
use Pyro\IdeHelper\Command\FindAllEntryDomains;

class EntryDomainsDocBlocks
{
    use DispatchesJobs;

    /** @var DocRegistry */
    protected $registry;

    protected $exclude = [ 'Anomaly\CommentsModule', 'Anomaly\DocumentationModule' ];

    public function __construct($exclude = [])
    {
        $this->exclude = $exclude;
    }

    public function handle(DocRegistry $registry)
    {
        $this->registry = $registry;

        $this->getDomains()->filter(function ($namespace) {
            return ! in_array($namespace, $this->exclude);
        })->map(function ($namespace, $path) {
            return $this->getClasses($path, $namespace);
        });
    }

    protected function getDomains()
    {
        $domains                                                                = $this->dispatchNow(new FindAllEntryDomains(app('addon.collection')->installed()));
        $domains[ base_path('vendor/anomaly/streams-platform/src/Assignment') ] = 'Anomaly\Streams\Platform';
        $domains[ base_path('vendor/anomaly/streams-platform/src/Stream') ]     = 'Anomaly\Streams\Platform';
        $domains[ base_path('vendor/anomaly/streams-platform/src/Entry') ]      = 'Anomaly\Streams\Platform';
        $domains[ base_path('vendor/anomaly/streams-platform/src/Version') ]    = 'Anomaly\Streams\Platform';
        $domains[ base_path('vendor/anomaly/streams-platform/src/Field') ]      = 'Anomaly\Streams\Platform';
        return collect($domains);
    }

    public function getClasses($path, $namespace)
    {
        $name = pathinfo($path, PATHINFO_BASENAME);
        /** @var \Illuminate\Support\Collection|ClassDoc[] $c */
        /** @var array{model:ClassDoc, collection:ClassDoc, criteria:ClassDoc, observer:ClassDoc, presenter:ClassDoc, repository:ClassDoc, queryBuilder:ClassDoc, router:ClassDoc, seeder:ClassDoc, interface:ClassDoc, repositoryInterface:ClassDoc, formBuilder:ClassDoc, tableBuilder:ClassDoc}  $c */
        $c = collect([
            'model'               => "\\{$namespace}\\{$name}\\{$name}Model",
            'collection'          => "\\{$namespace}\\{$name}\\{$name}Collection",
            'criteria'            => "\\{$namespace}\\{$name}\\{$name}Criteria",
            'observer'            => "\\{$namespace}\\{$name}\\{$name}Observer",
            'presenter'           => "\\{$namespace}\\{$name}\\{$name}Presenter",
            'repository'          => "\\{$namespace}\\{$name}\\{$name}Repository",
            'queryBuilder'        => "\\{$namespace}\\{$name}\\{$name}QueryBuilder",
            'router'              => "\\{$namespace}\\{$name}\\{$name}Router",
            'seeder'              => "\\{$namespace}\\{$name}\\{$name}Seeder",
            'interface'           => "\\{$namespace}\\{$name}\\Contract\\{$name}Interface",
            'repositoryInterface' => "\\{$namespace}\\{$name}\\Contract\\{$name}RepositoryInterface",
            'formBuilder'         => "\\{$namespace}\\{$name}\\Form\\{$name}FormBuilder",
            'tableBuilder'        => "\\{$namespace}\\{$name}\\Table\\{$name}TableBuilder",
        ]);

        $pivotFiles = glob(path_join($path, '*Pivot.php'), GLOB_NOSORT);
        foreach ($pivotFiles as $pivotFile) {
            $pivotName      = path_get_filename_without_extension($pivotFile);
            $pivotClassName = "\\{$namespace}\\{$name}\\{$pivotName}";
            if (class_exists($pivotClassName)) {
                $c[ lcfirst($pivotName) ] = "\\{$namespace}\\{$name}\\{$pivotName}";
            }
        }

        $c = $c->map(function ($className, $key) {
            if ( ! class_exists($className) && ! interface_exists($className)) {
                $className = $this->getFallbackClass($key);
                return $this->registry->getClass($className);
            }
            return $this->registry->getClass($className);
        });

        $cs = $c->map(function (ClassDoc $class) {
            return Str::ensureLeft($class->getReflection()->getName() . '[]', '\\');
        });
//        $cs = collect($c->all())->evaluate('getNameArray()', 'map'); //cast('string')->evaluate('item ~ "[]"','map');

        $c[ 'interface' ]->ensureMixin($c[ 'model' ]);
        $c[ 'presenter' ]->ensureMixin($c[ 'model' ]);
        $c[ 'presenter' ]->cleanTag('property')->ensureProperty('$object', $c[ 'model' ]);
        $c[ 'repositoryInterface' ]->ensureMixin($c[ 'repository' ]);
        $c[ 'criteria' ]->ensureMixin($c[ 'queryBuilder' ]);

        $c[ 'model' ]->ensureMethod('getPresenter', $c[ 'presenter' ])
            ->ensureMethod('newCollection', $c[ 'collection' ])
            ->ensureMethod('newRouter', $c[ 'router' ])
            ->ensureMethod('newEloquentBuilder', $c[ 'queryBuilder' ]);
        $c[ 'repository' ]->cleanTag('method')
            ->ensureMethod('all', [ $c[ 'collection' ], $cs[ 'interface' ] ])
            ->ensureMethod('allWithTrashed', [ $c[ 'collection' ], $cs[ 'interface' ] ])
            ->ensureMethod('allWithoutRelations', [ $c[ 'collection' ], $cs[ 'interface' ] ])
            ->ensureMethod('first', $c[ 'interface' ], '$direction = "asc"')
            ->ensureMethod('find', $c[ 'interface' ], '$id')
            ->ensureMethod('findWithoutRelations', $c[ 'interface' ], '$id')
            ->ensureMethod('findBy', $c[ 'interface' ], '$key, $value')
            ->ensureMethod('findAll', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'array $ids')
            ->ensureMethod('findAllBy', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'string $key, $value')
            ->ensureMethod('findTrashed', $c[ 'interface' ], '$id')
            ->ensureMethod('newQuery', $c[ 'queryBuilder' ])
            //->ensureMethod('create', $c[ 'interface' ], 'array $attributes = ' . $this->getAttributesString($c[ 'model' ]))
            // 'create' will be provided by php toolbox
            // 'update' cannot be provided by php toolbox. it messes things up. So it will be provided here, utilizing deep-assoc-completion
            ->ensureMethod('create', $c[ 'interface' ], 'array $attributes = ' . $this->getAttributesString($c[ 'model' ]))
            ->ensureMethod('update', $c[ 'interface' ], 'array $attributes = ' . $this->getAttributesString($c[ 'model' ]))
            ->ensureMethod('getModel', $c[ 'model' ])
            ->ensureMethod('newInstance', $c[ 'interface' ], 'array $attributes = []')
            ->ensureMethod('sorted', [ $c[ 'collection' ], $cs[ 'interface' ] ], '$direction = "asc"')
            ->ensureMethod('first', $c[ 'interface' ], '$direction = "asc"')
            ->ensureMethod('lastModified', $c[ 'interface' ]);

        $c[ 'queryBuilder' ]->ensureProperty('$model', $c[ 'model' ]);

        $c[ 'formBuilder' ]
            ->ensureMethod('getFormEntry', $c[ 'interface' ])
            ->ensureMethod('getFormModelName', $c[ 'model' ])
            ->ensureMethod('getFormModel', $c[ 'model' ]);

        /** @var \Pyro\Platform\Entry\EntryModel $model */
        $modelClass     = $c[ 'model' ]->getClassName();
        $presenterProps = [];
        $model          = new $modelClass();
        if ($model instanceof EntryModel) {
            foreach ($model->getAssignments() as $assignment) {
                $presenterProps[] = [
                    'class' => get_class($assignment->getFieldType()->getPresenter()),
                    'slug'  => $assignment->getFieldSlug(),
                ];
            }
        }
        foreach ($presenterProps as $props) {
            $c[ 'presenter' ]->ensureProperty($props[ 'slug' ], $props[ 'class' ]);
        }

//        /** @var \Illuminate\Support\Collection|ClassDefinition[] $process */
//        $process = $c->values()->filter(function (ClassDoc $classDoc) {
//            return ! $this->isFallbackClass($classDoc->getReflection()->getName());
//        });
        (new CollectionDocBlock(
            $c[ 'collection' ]->getReflection()->getName(),
            $c[ 'interface' ]->getReflection()->getName())
        )->generate($this->registry);
    }

    protected $fallbacks = [
        'model'               => \Anomaly\Streams\Platform\Entry\EntryModel::class,
        'collection'          => \Anomaly\Streams\Platform\Entry\EntryCollection::class,
        'criteria'            => \Anomaly\Streams\Platform\Entry\EntryCriteria::class,
        'observer'            => \Anomaly\Streams\Platform\Entry\EntryObserver::class,
        'presenter'           => \Anomaly\Streams\Platform\Entry\EntryPresenter::class,
        'repository'          => \Anomaly\Streams\Platform\Entry\EntryRepository::class,
        'router'              => \Anomaly\Streams\Platform\Entry\EntryRouter::class,
        'queryBuilder'        => \Anomaly\Streams\Platform\Entry\EntryQueryBuilder::class,
        'seeder'              => \Anomaly\Streams\Platform\Database\Seeder\Seeder::class,
        'interface'           => \Anomaly\Streams\Platform\Entry\Contract\EntryInterface::class,
        'repositoryInterface' => \Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface::class,
        'formBuilder'         => \Anomaly\Streams\Platform\Ui\Form\FormBuilder::class,
        'tableBuilder'        => \Anomaly\Streams\Platform\Ui\Table\TableBuilder::class,
    ];

    protected function getFallbackClass($key)
    {
        return $this->fallbacks[ $key ];
    }

    protected function isFallbackClass($class)
    {
        $class = Str::removeLeft($class, '\\');
        return in_array($class, $this->fallbacks, true);
    }

    protected function getAttributesString($model)
    {
        $string = [ '[' ];
        foreach ($this->getAttributes($model) as $attr) {
            $string[] = "'{$attr}' => '',";
        }
        $string[] = ']';
        return implode('', $string);
    }

    /**
     * @param ClassDoc|\Anomaly\Streams\Platform\Entry\EntryModel $model
     *
     * @return array
     */
    protected function getAttributes($model)
    {
        if ($model instanceof ClassDoc) {
            $model = $model->getReflection()->getName();
            $model = new $model;
        }
        try {
            return array_unique(array_merge($model->getAssignments()->fieldSlugs(), $model->getRelationshipAssignments()->fieldSlugs()));
        }
        catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @var \Illuminate\Support\Collection|\Doctrine\DBAL\Schema\Column[]
     */
    static $tableColumns = [];

    /**
     * @param string $table
     *
     * @return \Illuminate\Support\Collection|\Doctrine\DBAL\Schema\Column[]
     */
    protected function getDatabaseTableColumns(string $table)
    {
        if ( ! array_key_exists($table, static::$tableColumns)) {
            static::$tableColumns[ $table ] = collect(app()->db->getDoctrineSchemaManager()->listTableColumns($table));
        }
        return static::$tableColumns[ $table ];
    }
}
