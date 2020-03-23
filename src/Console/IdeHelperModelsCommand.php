<?php /** @noinspection LowPerformingDirectoryOperationsInspection */

namespace Pyro\IdeHelper\Console;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Pyro\IdeHelper\Overrides\FieldTypeParser;
use ReflectionClass;
use Symfony\Component\Console\Input\InputOption;

class IdeHelperModelsCommand extends \Barryvdh\LaravelIdeHelper\Console\ModelsCommand
{
    public function handle()
    {

        $this->getLaravel()->bind(\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser::class, FieldTypeParser::class);
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
        $globs = [
            'src/**/*Model.php',
            'src/**/*Pivot.php',
        ];
        $paths = collect($globs)
            ->map([$addon, 'getPath'])
            ->call('rglob',[],false)
            ->filter()
            ->flatten();
//        $paths = collect($addon->getPath('src/*/*Model.php'))->merge($addon->getPath('src/*/*Pivot.php'));
//        $paths = $paths->call('glob', [], false)->filter()->flatten();
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
        $paths = $addons->enabled()->toBase()->values()->map->getPath('src/*/*Model.php');
//        $applicationResourceModelsPath = resolve(Application::class)->getStoragePath('models');
//        $paths->push(path_join($applicationResourceModelsPath, '*/*Model.php'));
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
        if ($isEntry = $reflection->isSubclassOf(EntryModel::class)) {
            $this->createEntryModelPhpDocs($class);
        }
        return parent::createPhpDocs($class);
    }

    protected $forceTypes = [
        'anomaly.field_type.addon',
    ];

    protected function createEntryModelPhpDocs($class)
    {
        /** @var EntryModel $model */
        $model  = new $class;
        $stream = $model->getStream();
        /** @var \Anomaly\Streams\Platform\Assignment\AssignmentCollection|\Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface[] $assigns */
        $assigns = $stream->getAssignments();
//        $rassigns = $stream->getRelationshipAssignments();
        foreach ($assigns as $assign) {
            $field              = $assign->getField();
            $fieldSlug          = $field->getSlug();
            $fieldType          = $field->getType();
            $fieldTypeNamespace = $fieldType->getNamespace();
//            $columnType = $type->getColumnType();
            if (
                ! array_key_exists($fieldSlug, $this->properties)
                || in_array($fieldTypeNamespace, $this->forceTypes, true)
            ) {
                $this->setProperty($fieldSlug, $this->streamsFieldToPhpType($field));
                if ($this->write_model_magic_where) {
                    $this->setMethod(
                        Str::camel("where_" . $fieldSlug),
                        '\Illuminate\Database\Eloquent\Builder|\\' . get_class($model),
                        [ '$value' ]
                    );
                }
            }
        }
    }

    /**
     * cast the properties's type from $casts.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    protected function streamsFieldToPhpType(FieldInterface $field)
    {
        $type      = $field->getType();
        $namespace = $type->getNamespace();
        switch ($namespace) {
            case 'anomaly.field_type.addon':
                dispatch_now(new \Anomaly\AddonFieldType\Command\BuildOptions($type));
                if ($namespace = head(array_keys($type->getOptions()))) {
                    $addon = resolve('addon.collection')->get($namespace);
                    if ($addon) {
                        $class = Str::ensureLeft(get_class($addon), '\\');
                        if ($addon->getType() === 'extension') {
                            $parents = array_keys(class_parents($class));
                            $len     = count($parents);
                            if ($len > 2) {
                                return Str::ensureLeft($parents[ $len - 3 ], '\\'); // the class that extends Streams\Platform\Addon\Extension
                            }
                        }
                        return $class; // return the class itself, it extends Streams\Platform\Addon\Extension
                    }
                }
                return 'string';
            //formatter:off
            case 'anomaly.field_type.blocks': return 'mixed';
            case 'anomaly.field_type.boolean': return 'bool';
            case 'anomaly.field_type.checkboxes': return 'mixed';
            case 'anomaly.field_type.colorpicker': return 'string';
            case 'anomaly.field_type.country': return 'string';
            case 'anomaly.field_type.datetime': return '\\Carbon\\Carbon';
            case 'anomaly.field_type.decimal': return 'float';
            case 'anomaly.field_type.editor': return 'string';
            case 'anomaly.field_type.email': return 'string';
            case 'anomaly.field_type.encrypted': return 'string';
            case 'anomaly.field_type.file': return 'mixed';
            case 'anomaly.field_type.files': return 'mixed';
            case 'anomaly.field_type.icon': return 'string';
            case 'anomaly.field_type.integer': return 'int';
            case 'anomaly.field_type.language': return 'string';
            case 'anomaly.field_type.markdown': return 'string';
            case 'anomaly.field_type.multiple': return Str::ensureLeft($type->config('related'), '\\');
            case 'anomaly.field_type.polymorphic': return 'mixed';
            case 'anomaly.field_type.relationship': return Str::ensureLeft($type->config('related'), '\\');
            case 'anomaly.field_type.repeater': return 'mixed';
            case 'anomaly.field_type.select': return 'string';
            case 'anomaly.field_type.slider': return 'string';
            case 'anomaly.field_type.slug': return 'string';
            case 'anomaly.field_type.state': return 'string';
            case 'anomaly.field_type.tags': return 'mixed';
            case 'anomaly.field_type.text': return 'string';
            case 'anomaly.field_type.textarea': return 'string';
            case 'anomaly.field_type.upload': return 'mixed';
            case 'anomaly.field_type.url': return 'string';
            case 'anomaly.field_type.wysiwyg': return 'string';
            //formatter:on
        }
        return 'mixed';
    }

}
