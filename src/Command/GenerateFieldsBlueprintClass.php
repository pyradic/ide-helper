<?php

namespace Pyro\IdeHelper\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Pyro\IdeHelper\Examples\FieldTypeExamples;

class GenerateFieldsBlueprintClass
{
    /** @var string */
    protected $path;

    /** @var boolean */
    protected $noWrite;

    /** @var string */
    protected $namespace;

    /**
     * GenerateFieldBlueprint constructor.
     *
     * @param string $path    File path to write generated results to
     * @param string $namespace
     * @param bool   $noWrite Disable write to file
     */
    public function __construct(string $path, string $namespace, bool $noWrite = false)
    {
        $this->path    = $path;
        $this->noWrite = $noWrite;
        $this->namespace = $namespace;
    }

    protected function write(string $data)
    {
        if ($this->noWrite) {
            return;
        }
        $path = path_is_relative($this->path) ? base_path($this->path) : $this->path;
        file_put_contents($path, $data);
    }

    public function handle(FieldTypeCollection $fields)
    {
        $methods = $this->generateMethods($fields);
        $result = $this->generateBody($methods);
        $this->write($result);
        return $result;
    }

    protected function generateMethods(FieldTypeCollection $fields)
    {

        return $fields
            ->toBase()
            ->map(function (FieldType $type) {
                $exampleFqn = Str::ensureLeft(FieldTypeExamples::class . "::{$type->getSlug()}_config()",'\\');
                return <<<EOF
    /**
     * @param string \$name
     * @param null|array \$config = {$exampleFqn}
     * @return \$this
     */
    public function {$type->getSlug()}(\$name, array \$config = null){
        if(\$config === null){
            \$this->fields[\$name] = '{$type->getNamespace()}';
        } else {
            \$this->fields[\$name] = [
                'type' => '{$type->getNamespace()}',
                'config' => \$config
            ];
        }
        return \$this;
    }
EOF;
            })
            ->values()
            ->implode("\n");

    }

    protected function generateBody(string $methods)
    {
        return <<<EOF
<?php

namespace {$this->namespace};

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Contracts\Support\Arrayable;

class FieldsBlueprint implements Arrayable
{
    protected \$fields = [];

    /** @var Migration */
    protected \$migration;

    public function __construct(Migration \$migration)
    {
        \$this->migration = \$migration;
    }

    public static function migration(Migration \$migration)
    {
        return new static(\$migration);
    }

    public function finish()
    {
        \$this->migration->setFields(\$this->fields);
    }

    public function toArray()
    {
        return \$this->fields;
    }

    {$methods}

}
EOF;

    }
}
