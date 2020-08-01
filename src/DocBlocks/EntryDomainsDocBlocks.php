<?php /** @noinspection ContractViolationInspection */

namespace Pyro\IdeHelper\DocBlocks;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
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
//            'formBuilder'         => "\\{$namespace}\\{$name}\\Form\\{$name}FormBuilder",
//            'tableBuilder'        => "\\{$namespace}\\{$name}\\Table\\{$name}TableBuilder",
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

        $this->handleModel($c[ 'model' ], $c, $cs);
        $this->handleCollection($c[ 'collection' ], $c, $cs);
        $this->handleCriteria($c[ 'criteria' ], $c, $cs);
        $this->handleObserver($c[ 'observer' ], $c, $cs);
        $this->handlePresenter($c[ 'presenter' ], $c, $cs);
        $this->handleRepository($c[ 'repository' ], $c, $cs);
        $this->handleQueryBuilder($c[ 'queryBuilder' ], $c, $cs);
        $this->handleRouter($c[ 'router' ], $c, $cs);
        $this->handleSeeder($c[ 'seeder' ], $c, $cs);
        $this->handleInterface($c[ 'interface' ], $c, $cs);
        $this->handleRepositoryInterface($c[ 'repositoryInterface' ], $c, $cs);
        $this->handleFormBuilder($c[ 'formBuilder' ], $c, $cs);
        $this->handleTableBuilder($c[ 'tableBuilder' ], $c, $cs);

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

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleModel(ClassDoc $cd, $c, $cs)
    {
        $cd
            ->ensureMethod('getPresenter', $c[ 'presenter' ])
            ->ensureMethod('newCollection', $c[ 'collection' ])
            ->ensureMethod('newRouter', $c[ 'router' ])
            ->ensureMethod('newEloquentBuilder', $c[ 'queryBuilder' ]);
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleCollection(ClassDoc $cd, $c, $cs)
    {
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleCriteria(ClassDoc $cd, $c, $cs)
    {
        $cd->ensureMixin($c[ 'queryBuilder' ]);
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleObserver(ClassDoc $cd, $c, $cs)
    {
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array{model:ClassDoc, collection:ClassDoc, criteria:ClassDoc, observer:ClassDoc, presenter:ClassDoc, repository:ClassDoc, queryBuilder:ClassDoc, router:ClassDoc, seeder:ClassDoc, interface:ClassDoc, repositoryInterface:ClassDoc, formBuilder:ClassDoc, tableBuilder:ClassDoc} $c
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handlePresenter(ClassDoc $cd, $c, $cs)
    {
        $cd
            ->cleanTag('property')
            ->ensureProperty('$object', $c[ 'model' ])
            ->ensureMethod('getObject', $c[ 'model' ])
            ->ensureMixin($c[ 'model' ]);

        /** @var \Crvs\Platform\Entry\EntryModel $model */
        $modelClass = $c[ 'model' ]->getClassName();
        $model      = new $modelClass();
        if ($model instanceof EntryModel) {
            $presenterProps = collect($model->getAssignments())->map(function (AssignmentInterface $assignment) {
                return [
                    'class' => get_class($assignment->getFieldType()->getPresenter()),
                    'slug'  => $assignment->getFieldSlug(),
                ];
            });
            foreach ($presenterProps as $props) {
                $cd->ensureProperty($props[ 'slug' ], $props[ 'class' ]);
            }
        }
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleRepository(ClassDoc $cd, $c, $cs)
    {

        $cd->cleanTag('method')
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
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleQueryBuilder(ClassDoc $cd, $c, $cs)
    {
        $c[ 'queryBuilder' ]->ensureProperty('$model', $c[ 'model' ]);
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleRouter(ClassDoc $cd, $c, $cs)
    {
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleSeeder(ClassDoc $cd, $c, $cs)
    {
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleInterface(ClassDoc $cd, $c, $cs)
    {
        $cd->ensureMixin($c[ 'model' ]);
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleRepositoryInterface(ClassDoc $cd, $c, $cs)
    {
        $cd->ensureMixin($c[ 'repository' ]);
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleFormBuilder(ClassDoc $cd, $c, $cs)
    {
        $cd
            ->ensureMethod('getFormEntry', $c[ 'interface' ])
            ->ensureMethod('getFormModelName', $c[ 'model' ])
            ->ensureMethod('getFormModel', $c[ 'model' ]);
    }

    /**
     * @param \Laradic\Generators\Doc\Doc\ClassDoc $cd
     * @param array                                $c  = static::cexample()
     * @param array                                $cs = static::cexample()
     *
     * @return void
     */
    protected function handleTableBuilder(ClassDoc $cd, $c, $cs)
    {
    }

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

    public static function cexample()
    {
        return [
            'model'               => new ClassDoc(null),
            'collection'          => new ClassDoc(null),
            'criteria'            => new ClassDoc(null),
            'observer'            => new ClassDoc(null),
            'presenter'           => new ClassDoc(null),
            'repository'          => new ClassDoc(null),
            'queryBuilder'        => new ClassDoc(null),
            'router'              => new ClassDoc(null),
            'seeder'              => new ClassDoc(null),
            'interface'           => new ClassDoc(null),
            'repositoryInterface' => new ClassDoc(null),
            'formBuilder'         => new ClassDoc(null),
            'tableBuilder'        => new ClassDoc(null),
        ];
    }

}
