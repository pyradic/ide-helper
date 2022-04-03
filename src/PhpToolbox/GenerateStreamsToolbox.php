<?php

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Laradic\Idea\Toolbox\Metadata;

class GenerateStreamsToolbox
{
    /** @var \Laradic\Idea\Toolbox\Metadata */
    protected $meta;

    /** @var \Anomaly\Streams\Platform\Entry\EntryModel */
    protected $model;

    /** @var \ReflectionClass */
    protected $modelReflection;

    /** @var string */
    protected $classPrefix;

    /** @var string */
    protected $namespace;

    /** @var string */
    protected $streamNamespace;

    /** @var string */
    protected $streamSlug;

    protected $key;

    /** @var \Anomaly\Streams\Platform\Stream\Contract\StreamInterface */
    protected $stream;

    /**
     * GenerateStreamMeta constructor.
     *
     * @param StreamInterface|string $namespace
     * @param string|null            $slug
     */
    public function __construct($namespace, string $slug = null)
    {
        if ($namespace instanceof StreamInterface) {
            $this->stream = $namespace;
            $slug         = $namespace->slug;
            $namespace    = $namespace->namespace;
        }
        $this->streamNamespace = $namespace;
        $this->streamSlug      = $slug;

        $path       = path_join(
            config('pyro.ide-helper.toolbox.path'),
            'streams',
            $this->key = $slug . '_' . $namespace . '_' . $slug . '_' . $namespace,
            '.ide-toolbox.metadata.json'
        );
        $this->meta = Metadata::create($path);
        config('pyro.ide');
    }

    public function handle(StreamRepositoryInterface $streamRepository)
    {
        $stream = $this->stream;
        $stream = $stream ?: $streamRepository->findBySlugAndNamespace($this->streamSlug, $this->streamNamespace);
        if ( ! $stream) {
            return;
        }

        $modelClass = $stream->getBoundEntryModelName() ?: $stream->getEntryModelName();
        /** @var \Anomaly\Streams\Platform\Entry\EntryModel $model */
        $this->model           = new $modelClass;
        $this->modelReflection = new \ReflectionClass($modelClass);
        $this->namespace       = $this->modelReflection->getNamespaceName();
        $this->classPrefix     = Str::removeRight($this->modelReflection->getShortName(), 'Model');

        $this->generateFieldAttributeMethods();
        $this->generateFieldsProvider();

        $this->meta->save();
        return;
    }

    protected function generateFieldAttributeMethods()
    {
        $repository          = "{$this->namespace}\\{$this->classPrefix}Repository";
        $repositoryInterface = "{$this->namespace}\\Contract\\{$this->classPrefix}RepositoryInterface";
        $model               = get_class($this->model);
        $modelInterface      = "{$this->namespace}\\Contract\\{$this->classPrefix}Interface";
        if ( ! class_exists($repository)) {
            return;
        }

        $this->meta->push('registrar', [
            'provider'   => $this->key . '_fields',
            'language'   => 'php',
            'signatures' => [
                [ 'class' => $repository, 'method' => 'create', 'type' => 'array_key', ],
                [ 'class' => $repository, 'method' => 'update', 'type' => 'array_key', ],
                [ 'class' => $repositoryInterface, 'method' => 'create', 'type' => 'array_key', ],
                [ 'class' => $repositoryInterface, 'method' => 'update', 'type' => 'array_key', ],
                [ 'class' => $model, 'method' => 'create', 'type' => 'array_key', ],
                [ 'class' => $model, 'method' => 'update', 'type' => 'array_key', ],
                [ 'class' => $modelInterface, 'method' => 'create', 'type' => 'array_key', ],
                [ 'class' => $modelInterface, 'method' => 'update', 'type' => 'array_key', ],
//                [ 'class' => $interface, 'method' => 'create', 'type' => 'array_key', ],
//                [ 'class' => $interface, 'method' => 'update', 'type' => 'array_key', ],
            ],
            'signature'  => [
                "{$repository}:create",
                "{$repository}:update",
                "{$repositoryInterface}:create",
                "{$repositoryInterface}:update",
                "{$model}:create",
                "{$model}:update",
                "{$modelInterface}:create",
                "{$modelInterface}:update",
            ],
        ]);
    }

    protected function generateFieldsProvider()
    {
        $repository = "{$this->namespace}\\{$this->classPrefix}Repository";
        $fields     = $this->getFields();
        $items      = [];
        foreach ($fields as $field) {

            $rules = implode('|', $field[ 'rules' ]);
            $item  = [
                'type'          => $repository,
                'lookup_string' => $field[ 'slug' ],
                'type_text'     => $field[ 'php_type' ],
                'tail_text'     => " ({$field['sql_type']}) {$rules}",
                'icon'          => 'com.jetbrains.php.PhpIcons.FIELD',
            ];

            if ($field[ 'type' ] === null) {
                $item[ 'icon' ] = 'com.jetbrains.php.PhpIcons.PROTECTED';
            } else {
                $item[ 'target' ] = get_class($field[ 'type' ]);
                if ($field[ 'type' ]->isRequired()) {
                    $item[ 'icon' ] = 'com.jetbrains.php.PhpIcons.STATIC_FIELD';
                }
            }

            $items[] = $item;
        }
        $this->meta->push('providers', [
            'name'  => $this->key . '_fields',
            'items' => $items,
        ]);
    }

    /**
     * @return array = [['rules'=>[],'sql_type'=>'','php_type'=>'','type' => new \Anomaly\Streams\Platform\Addon\FieldType\FieldType()]]
     */
    protected function getFields()
    {
        $columnTypes = $this->getTableColumnTypes();
        $fields      = $this->model->getAssignments()->map->getFieldSlug()->toBase()->mapWithKeys(function ($slug) {
            if ( ! $fieldType = $this->model->getFieldType($slug)) {
                return null;
            }
            $rules = $fieldType->getRules();
            if ($fieldType->isRequired() && ! in_array('required', $rules, true)) {
                $rules[] = 'required';
            }
            $phpType = $this->sqlToPhpType($fieldType->getColumnType());

            if ($fieldType->getType() === 'anomaly.field_type.relationship') {
                $related = $fieldType->config('related');
                if ( ! $related) {
                    $related = get_class($fieldType->getRelatedModel());
                }
                $phpType = $phpType . '|' . $related;
            }
            if (in_array($slug, $this->model->getDates(), true)) {
                $phpType = $phpType . '|' . Carbon::class;
            }
            return [
                $slug => [
                    'slug'     => $slug,
                    'rules'    => $rules,
                    'sql_type' => $fieldType->getColumnType(),
                    'php_type' => $phpType,
                    'type'     => $fieldType,
                ],
            ];
        });
        $fields      = $fields->merge(
            $columnTypes->diffKeys($fields)->map(function ($column) {
                $column[ 'slug' ]  = $column[ 'name' ];
                $column[ 'rules' ] = [];
                $column[ 'type' ]  = null;
                unset($column[ 'name' ]);
                return $column;
            })
        );
        return $fields;
    }

    protected function getTableColumnTypes()
    {

        $table            = $this->model->getConnection()->getTablePrefix() . $this->model->getTable();
        $schema           = $this->model->getConnection()->getDoctrineSchemaManager();
        $databasePlatform = $schema->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');

        $platformName = $databasePlatform->getName();
        $database     = null;
        if (strpos($table, '.')) {
            [ $database, $table ] = explode('.', $table);
        }

        $columns    = $schema->listTableColumns($table, $database);
        $properties = [];
        if ($columns) {
            foreach ($columns as $column) {
                $name                = $column->getName();
                $phpType             = 'mixed';
                $sqlType             = $column->getType()->getName();
                $properties[ $name ] = [
                    'name'     => $name,
                    'sql_type' => $sqlType,
                    'php_type' => $this->sqlToPhpType($sqlType),
                ];
            }
        }
        return collect($properties);
    }

    protected function sqlToPhpType($sqlType)
    {
        $phpType = 'mixed';
        switch ($sqlType) {
            case 'string':
            case 'text':
            case 'date':
            case 'time':
            case 'guid':
            case 'datetimetz':
            case 'datetime':
                $phpType = 'string';
                break;
            case 'integer':
            case 'bigint':
            case 'smallint':
                $phpType = 'int';
                break;
            case 'boolean':
                $phpType = 'bool';
                break;
                break;
            case 'decimal':
            case 'float':
                $phpType = 'float';
                break;
            default:
                $phpType = 'mixed';
                break;
        }
        return $phpType;
    }
}
