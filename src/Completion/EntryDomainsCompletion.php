<?php /** @noinspection ContractViolationInspection */

namespace Pyro\IdeHelper\Completion;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Laradic\Generators\DocBlock\ClassDoc;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Laradic\Idea\Completions\CompletionInterface;
use Pyro\IdeHelper\Command\FindAllEntryDomains;

class EntryDomainsCompletion implements CompletionInterface
{
    use DispatchesJobs;


    /** @var \Laradic\Generators\DocBlock\DocBlockGenerator */
    protected $generator;

    public function generate(DocBlockGenerator $generator, $next)
    {
        $this->generator = $generator;
        $this->getDomains()->map(function ($namespace, $path) {
            return $this->getClasses($path, $namespace);
        });
        return $next($generator);
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
            if ( ! class_exists($className) && ! interface_exists($className)) {
                $className = $this->getFallbackClass($key);
                return $this->generator->class($className);
            }
            return $this->generator->class($className);
        });

        $cs = $c->map(function (ClassDoc $class) {
            return $class->getName() . '[]';
        });
//        $cs = collect($c->all())->evaluate('getNameArray()', 'map'); //cast('string')->evaluate('item ~ "[]"','map');

        $c[ 'interface' ]->ensure('mixin', $c[ 'model' ]);
        $c[ 'presenter' ]->ensure('mixin', $c[ 'model' ]);
        $c[ 'repositoryInterface' ]->ensure('mixin', $c[ 'repository' ]);

        $c[ 'repository' ]->ensureMethod('all', [ $c[ 'collection' ], $cs[ 'interface' ] ]);
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

        /** @var \Illuminate\Support\Collection|ClassDoc[] $process */
        $process = $c->values()->filter(function (ClassDoc $classDoc) {
            return ! $this->isFallbackClass($classDoc->getName());
        });

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
}
