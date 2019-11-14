<?php /** @noinspection ContractViolationInspection */

namespace Pyro\IdeHelper\Completion;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Laradic\Generators\Completion\CollectionCompletion;
use Laradic\Generators\Completion\CompletionInterface;
use Laradic\Generators\DocBlock\ClassDoc;
use Laradic\Generators\DocBlock\Definition\ClassDefinition;
use Laradic\Generators\DocBlock\DocBlockGenerator;
use Pyro\IdeHelper\Command\FindAllEntryDomains;

class EntryDomainsCompletion implements CompletionInterface
{
    use DispatchesJobs;

    /** @var \Laradic\Generators\DocBlock\DocBlockGenerator */
    protected $generator;

    protected $excludeNamespaces = ['Anomaly\CommentsModule','Anomaly\DocumentationModule'];

    public function generate(DocBlockGenerator $generator)
    {
        $this->generator = $generator;
        $this->getDomains()->filter(function($namespace){
            return !in_array($namespace,$this->excludeNamespaces);
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
        /** @var \Laradic\Generators\DocBlock\Definition\ClassDefinition[]|\Illuminate\Support\Collection $c */
        /** @var array{model:ClassDoc, collection:ClassDoc, criteria:ClassDoc, observer:ClassDoc, presenter:ClassDoc, repository:ClassDoc, queryBuilder:ClassDoc, router:ClassDoc, seeder:ClassDoc, interface:ClassDoc, repositoryInterface:ClassDoc}  $c         */
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
        ])->map(function ($className, $key) {
            if ( ! class_exists($className) && ! interface_exists($className)) {
                $className = $this->getFallbackClass($key);
                return $this->generator->class($className);
            }
            return $this->generator->class($className);
        });

        $cs = $c->map(function (ClassDefinition $class) {
            return $class->getReflectionName(true) . '[]';
        });
//        $cs = collect($c->all())->evaluate('getNameArray()', 'map'); //cast('string')->evaluate('item ~ "[]"','map');

        $c[ 'interface' ]->ensureTag('mixin', $c[ 'model' ]);
        $c[ 'presenter' ]->ensureTag('mixin', $c[ 'model' ]);
        $c[ 'repositoryInterface' ]->ensureTag('mixin', $c[ 'repository' ]);
        $c[ 'criteria' ]->ensureTag('mixin', $c[ 'queryBuilder' ]);

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
            ->ensureMethod('create', $c[ 'interface' ], 'array $attributes = []')
            ->ensureMethod('getModel', $c[ 'model' ])
            ->ensureMethod('newInstance', $c[ 'interface' ], 'array $attributes = []')
            ->ensureMethod('sorted', [ $c[ 'collection' ], $cs[ 'interface' ] ], '$direction = "asc"')
            ->ensureMethod('first', $c[ 'interface' ], '$direction = "asc"')
            ->ensureMethod('lastModified', $c[ 'interface' ]);

        $c[ 'queryBuilder' ]->ensureTag('property', $c['model'] . ' $model');

        /** @var \Illuminate\Support\Collection|ClassDoc[] $process */
        $process = $c->values()->filter(function (ClassDefinition $classDoc) {
            return ! $this->isFallbackClass($classDoc->getReflectionName());
        });
        with(new CollectionCompletion($c[ 'collection' ]->getReflectionName(), $c[ 'interface' ]->getReflectionName()))->generate($this->generator);
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
        'queryBuilder'        => \Anomaly\Streams\Platform\Entry\EntryQueryBuilder::class,
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