<?php

namespace Pyro\IdeHelper\Command;

use Illuminate\Support\Str;

class ResolveConfigData
{
    /** @var string */
    protected $prefix;

    /** @var array */
    protected $config;

    /** @var array */
    protected $data = [];

    /**
     * ResolveConfigData constructor.
     *
     * @param string $prefix
     * @param array  $config
     */
    public function __construct(array $config, string $prefix='')
    {
        $this->prefix = $prefix;
        $this->config = $config;
    }

    public function handle()
    {
        $this->resolve($this->config, $this->prefix);

        return $this->data;
    }

    protected function resolve($config, $prefix = '')
    {
        foreach ($config as $key => $value) {
            if (is_int($key)) {
                continue;
            }
            $type = $this->getType($value);
            if(Str::endsWith($prefix, '::')){
                $key = $prefix . $key;
            } else {
                $key = $prefix . '.' . $key;
            }

            $this->data[$key] = [
                'key' => $key,
                'type' => $type,
                'value' => $value
            ];

            if(is_array($value)){
                $this->resolve($value, $key);
            }
        }
    }

    protected function getType($value)
    {
        if (is_array($value)) {
            return 'array';
        }
        if (is_string($value)) {
            return 'string';
        }
        if (is_bool($value)) {
            return 'bool';
        }
        if (is_int($value)) {
            return 'int';
        }
        return 'mixed';
    }
}
