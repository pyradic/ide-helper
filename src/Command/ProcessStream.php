<?php

namespace Pyradic\IdeHelper\Command;

use Illuminate\Support\Str;
use Laradic\Generators\DocBlock\ClassDoc;

class ProcessStream
{
    /** @var \Laradic\Generators\DocBlock\DocBlockGenerator */
    protected $generator;
    /** @var string */
    protected $namespace;
    /** @var string */
    protected $path;

    protected static $classDocClass = ClassDoc::class;

    /**
     * AddStreamToGenerator constructor.
     *
     * @param string                                         $namespace
     * @param string                                         $path
     * @param \Laradic\Generators\DocBlock\DocBlockGenerator $generator
     */
    public function __construct(string $path, string $namespace)
    {
        $this->namespace = $namespace;
        $this->path      = $path;
    }

    public function handle()
    {
        $path      = $this->path;
        $namespace = $this->namespace;
        $name      = pathinfo($path, PATHINFO_BASENAME);
        /** @var \Laradic\Generators\DocBlock\ClassDoc[]|\Illuminate\Support\Collection $c */
        /** @var array{model:ClassDoc, collection:ClassDoc, criteria:ClassDoc, observer:ClassDoc, presenter:ClassDoc, repository:ClassDoc, router:ClassDoc, seeder:ClassDoc, interface:ClassDoc, repositoryInterface:ClassDoc}  $c         */
        $c = collect([
            'model'               => "\\{$namespace}\\{$name}\\{$name}Model",
            'collection'          => "\\{$namespace}\\{$name}\\{$name}Collection",
            'criteria'            => "\\{$namespace}\\{$name}\\{$name}Criteria",
            'observer'            => "\\{$namespace}\\{$name}\\{$name}Observer",
            'presenter'           => "\\{$namespace}\\{$name}\\{$name}Presenter",
            'repository'          => "\\{$namespace}\\{$name}\\{$name}Repository",
            'router'              => "\\{$namespace}\\{$name}\\{$name}Router",
            'seeder'              => "\\{$namespace}\\{$name}\\{$name}Seeder",
            'interface'           => "\\{$namespace}\\{$name}\\Contract\\{$name}Interface",
            'repositoryInterface' => "\\{$namespace}\\{$name}\\Contract\\{$name}RepositoryInterface",
        ])->map(function ($className, $key) {
            if ( ! class_exists($className) &&  ! interface_exists($className)) {
                $className = $this->getFallbackClass($key);
                return $this->createClassDoc($className);
            }
            return $this->createClassDoc($className);
        });

        $cs = $c->map(function (ClassDoc $class) {
            return $class->getName() . '[]';
        });
//        $cs = collect($c->all())->evaluate('getNameArray()', 'map'); //cast('string')->evaluate('item ~ "[]"','map');

        $c[ 'interface' ]->ensure('mixin', $c[ 'model' ]);
        $c[ 'presenter' ]->ensure('mixin', $c[ 'model' ]);
        $c[ 'repositoryInterface' ]->ensure('mixin', $c[ 'repository' ]);

        $c[ 'repository' ]->ensureMethod('all', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'array $ids');
        $c[ 'repository' ]->ensureMethod('allWithTrashed', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'array $ids');
        $c[ 'repository' ]->ensureMethod('allWithoutRelations', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'array $ids');
        $c[ 'repository' ]->ensureMethod('findAll', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'array $ids');
        $c[ 'repository' ]->ensureMethod('findAllBy', [ $c[ 'collection' ], $cs[ 'interface' ] ], 'string $key, $value');
        $c[ 'repository' ]->ensureMethod('first', $c[ 'interface' ], '$direction = "asc"');
        $c[ 'repository' ]->ensureMethod('find', $c[ 'interface' ], '$id');
        $c[ 'repository' ]->ensureMethod('findBy', $c[ 'interface' ], '$key, $value');
        $c[ 'repository' ]->ensureMethod('create', $c[ 'interface' ], 'array $attributes = []');
        $c[ 'repository' ]->ensureMethod('getModel', $c[ 'interface' ]);
        $c[ 'repository' ]->ensureMethod('newInstance', $c[ 'interface' ], 'array $attributes = []');

        $c[ 'collection' ]->ensureMethod('all', $cs[ 'interface' ]);
        $c[ 'collection' ]->ensureMethod('first', $c[ 'interface' ]);
        $c[ 'collection' ]->ensureMethod('get', $cs[ 'interface' ], '$key, $default=null');
        $c[ 'collection' ]->ensureMethod('find', $c[ 'interface' ], '$key, $default=null');
        $c[ 'collection' ]->ensureMethod('findBy', $c[ 'interface' ], '$key, $value');

        $process = [];
        foreach ($c as $name => $classDoc) {
//            $content  = $classDoc->process();
//            $fileName = $classDoc->getFileName();
            if ($this->isFallbackClass($classDoc->getName())) {
                continue;
            }
            $process[] = $classDoc;
        }
        return $process;
    }

    protected $fallbacks = [
        'model'               => \Anomaly\Streams\Platform\Entry\EntryModel::class,
        'collection'          => \Anomaly\Streams\Platform\Entry\EntryCollection::class,
        'criteria'            => \Anomaly\Streams\Platform\Entry\EntryCriteria::class,
        'observer'            => \Anomaly\Streams\Platform\Entry\EntryObserver::class,
        'presenter'           => \Anomaly\Streams\Platform\Entry\EntryPresenter::class,
        'repository'          => \Anomaly\Streams\Platform\Entry\EntryRepository::class,
        'router'              => \Anomaly\Streams\Platform\Entry\EntryRouter::class,
        'seeder'              => \Anomaly\Streams\Platform\Database\Seeder\Seeder::class,
        'interface'           => \Anomaly\Streams\Platform\Entry\Contract\EntryInterface::class,
        'repositoryInterface' => \Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface::class,
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

    public static function setClassDocClass($classDocClass)
    {
        static::$classDocClass = $classDocClass;
    }

    /** @return ClassDoc */
    protected function createClassDoc($class)
    {
        $classDocClass = static::$classDocClass;
        return new $classDocClass($class);
    }


}
