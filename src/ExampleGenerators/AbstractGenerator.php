<?php

namespace Pyro\IdeHelper\ExampleGenerators;

use Illuminate\Foundation\Bus\Dispatchable;
use function base_path;
use function path_is_relative;

abstract class AbstractGenerator
{

    /** @var string */
    protected $path;

    /** @var boolean */
    protected $noWrite;

    /** @var string */
    protected $namespace;

    protected $prefix;

    /**
     * GenerateFieldBlueprint constructor.
     *
     * @param string $path    File path to write generated results to
     * @param string $namespace
     * @param bool   $noWrite Disable write to file
     */
    public function __construct(string $path, string $namespace, bool $noWrite = false)
    {
        $this->path      = $path;
        $this->noWrite   = $noWrite;
        $this->namespace = $namespace;
    }

    protected function write(string $data)
    {
        if ($this->noWrite) {
            return;
        }
        if ($this->prefix) {
            $data = str_replace('<?php', "<?php\n\n{$this->prefix}\n\n", $data);
        }
        $path = path_is_relative($this->path) ? base_path($this->path) : $this->path;
        file_put_contents($path, $data);
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function isNoWrite()
    {
        return $this->noWrite;
    }

    public function setNoWrite($noWrite)
    {
        $this->noWrite = $noWrite;
        return $this;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

}
