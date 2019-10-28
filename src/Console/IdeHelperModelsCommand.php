<?php /** @noinspection LowPerformingDirectoryOperationsInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Support\Arr;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use ReflectionClass;
use Symfony\Component\Console\Input\InputOption;

class IdeHelperModelsCommand extends \Barryvdh\LaravelIdeHelper\Console\ModelsCommand
{
    public function handle()
    {
        $this->laravel->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);

        $dir = $this->option('dir');

        $locations = [];
        $addons    = resolve(AddonCollection::class);
        if ($this->option('addon') !== null) {
            $addon = $addons->get($this->option('addon'));
            $this->setModelLocations($this->findAddonModelLocations($addon));
        } else {
            $this->setModelLocations($dir ? $dir : $this->findModelLocations($addons));
        }

        parent::handle();
    }

    protected function setModelLocations($locations)
    {
        $locations = Arr::wrap($locations);
        $this->laravel[ 'config' ]->set('ide-helper.model_locations', $locations);
    }

    protected function findAddonModelLocations(Addon $addon)
    {
        /** @var \Illuminate\Support\Collection $paths */
        $paths = collect($addon->getPath('src/*/*Model.php'));
        $paths = $paths->call('glob', [], false)->filter()->flatten();
        return collect($paths->toArray())
            ->filter(function ($path) {
                return ends_with($path, [ 'BlocksModel.php', 'StatusFilterQuery.php' ]) === false;
            })
            ->map(function ($path) {
                $path = \Illuminate\Support\Str::replaceFirst(base_path() . '/', '', $path);
                return path_get_directory($path);
            })
            ->unique()->toArray();
    }


    protected function findModelLocations(AddonCollection $addons)
    {
        /** @var \Illuminate\Support\Collection $paths */
        $paths = $addons->toBase()->values()->map->getPath('src/*/*Model.php');
        $paths = $paths->call('glob', [], false)->filter()->flatten();
        return collect(array_merge(
            $paths->toArray(),
            glob(base_path('vendor/anomaly/streams-platform/src/*/*Model.php'))
        ))
            ->filter(function ($path) {
                return ends_with($path, [ 'BlocksModel.php', 'StatusFilterQuery.php' ]) === false;
            })
            ->map(function ($path) {
                $path = \Illuminate\Support\Str::replaceFirst(base_path() . '/', '', $path);
                return path_get_directory($path);
            })
            ->unique()->toArray();
    }

    protected function getOptions()
    {
        $opts = parent::getOptions();
        return array_merge($opts, [
            [ 'addon', 'A', InputOption::VALUE_OPTIONAL, 'The addon' ],
        ]);
    }

    protected function setProperty($name, $type = null, $read = null, $write = null, $comment = '', $nullable = false)
    {
        return parent::setProperty($name, $type, true, true, $comment, $nullable);
    }

    protected function generateDocs($loadModels, $ignore = '')
    {
        $ignore = implode(',', array_merge(explode(',', $ignore), [
            \Anomaly\UsersModule\User\Table\Filter\StatusFilterQuery::class,
            \Anomaly\PostsModule\Post\Table\Filter\StatusFilterQuery::class,
        ]));
        return parent::generateDocs($loadModels, $ignore);
    }

    protected function createPhpDocs($class)
    {
        $reflection = new ReflectionClass($class);
        $this->setMethod('make', '\\' . $reflection->getName(), [ '$attributes=[]' ]);
        return parent::createPhpDocs($class);
    }


}
