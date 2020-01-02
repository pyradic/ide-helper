<?php /** @noinspection UnsupportedStringOffsetOperationsInspection */

namespace Pyro\IdeHelper\Command;

use Barryvdh\Reflection\DocBlock\Tag;
use Laradic\Generators\DocBlock\DocBlock;
use ReflectionClass as Rc;
use ReflectionMethod as Rm;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer as AN;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GetClassMethodList
{
    /** @var string */
    protected $class;

    /**
     * GetClassMethodList constructor.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function handle()
    {
        return $this->getModelStatic(new Rc($this->class));
    }

    protected $serializer;

    protected function getSerializer()
    {
        if ($this->serializer === null) {
            $this->serializer = new Serializer([ $norm = new ObjectNormalizer(null) ]);
        }
        return $this->serializer;
    }

    /**
     * @param Rc $class
     *
     * @return \Illuminate\Support\Collection|array = static::example()
     */
    protected function getModelStatic(Rc $class)
    {
        return collect($class->getMethods(Rm::IS_PUBLIC))
            ->filter(function (Rm $method) {
                return ! $method->isStatic()
                    && ! $method->isAbstract()
                    && ! $method->isConstructor();
            })
            ->map(function (Rm $method) {

                $data = $this->getSerializer()->normalize($method, null, [
//                    AN::IGNORED_ATTRIBUTES => ['select','prototype','getPrototype','closure'],
                    AN::ATTRIBUTES => [
                        'name',
                        'static',
                        'public',
                        'export',
//                        '__construct',
//                        '__toString',
                        'public',
                        'private',
                        'protected',
                        'abstract',
                        'final',
                        'static',
                        'constructor',
                        'destructor',

                        'namespace',
//                        'closure',
                        'deprecated',
//                        'internal',
//                        'userDefined',
                        'generator',
                        'variadic',
//                        'closure',
                        'modifiers',
//                        'declaringClass',
//                        'prototype',
//                        'closureThis',
//                        'closureScopeClass',
                        'docComment',
                        'endLine',
                        'extension',
                        'extensionName',
                        'fileName',
//                        'name',
                        'namespaceName',
                        'numberOfParameters',
                        'numberOfRequiredParameters',
//                        'parameters',
                        'shortName',
                        'startLine',
//                        'staticVariables',
                        'returnType',
                        'returnsReference',
                    ],
                ]);

                $docBlock                     = new DocBlock($data[ 'docComment' ]);
                $data[ 'docBlock' ]           = $docBlock->toArray();
                $data[ 'docBlock' ][ 'tags' ] = collect($docBlock->getTags())->map(function (Tag $tag) {
                    return collect($this->getSerializer()->normalize($tag));
                });

                $data[ 'docBlock' ] = collect($data[ 'docBlock' ]);

                $data[ 'parameters' ] = collect($method->getParameters())->map(function (\ReflectionParameter $param) {
                    $data = $this->getSerializer()->normalize($param, null, [
                        AN::ATTRIBUTES => [
                            'name',
                            'type',
                            'passedByReference',
                            'bePassedByValue',
                            'callable',
                            'allowsNull',
                            'position',
                            'optional',
                            'defaultValueAvailable',
//                            'defaultValue',
//                            'defaultValueConstant',
                            'variadic',
                        ],
                    ]);
                    if ($param->isDefaultValueAvailable()) {
                        $data[ 'defaultValue' ] = $param->getDefaultValue();
                    }
                    return collect($data);
                });

                return collect($data);
            })->mapWithKeys(function ($v, $k) {
                return [ $v[ 'name' ] => $v ];
            });
    }
    public static function example()
    {
        return [
            'public'                     => true,
            'private'                    => false,
            'protected'                  => false,
            'abstract'                   => false,
            'final'                      => false,
            'static'                     => false,
            'constructor'                => false,
            'destructor'                 => false,
            'modifiers'                  => 256,
            'deprecated'                 => false,
            'generator'                  => false,
            'variadic'                   => false,
            'docComment'                 => '/**
     * Get the first record matching the attributes or create it.
     *
     * @param  array  $attributes
     * @param  array  $values
     * @return \\Illuminate\\Database\\Eloquent\\Model|static
     */',
            'endLine'                    => 424,
            'extension'                  => null,
            'extensionName'              => false,
            'fileName'                   => '/home/radic/projects/pyro/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php',
            'name'                       => 'firstOrCreate',
            'namespaceName'              => '',
            'numberOfParameters'         => 2,
            'numberOfRequiredParameters' => 1,
            'shortName'                  => 'firstOrCreate',
            'startLine'                  => 415,
            'returnType'                 => null,
            'docBlock'                   => [
                'short_description' => 'Get the first record matching the attributes or create it.',
                'long_description'  => '',
                'tags'              => [
                    [
                        'content'           => 'array  $attributes',
                        'variableName'      => '$attributes',
                        'variadic'          => false,
                        'types'             =>
                            [
                                0 => 'array',
                            ],
                        'type'              => 'array',
                        'name'              => 'param',
                        'description'       => '',
                        'parsedDescription' =>
                            [
                                0 => '',
                            ],
                        'docBlock'          => null,
                        'location'          => null,
                    ],

                    [
                        'content'           => '\\Illuminate\\Database\\Eloquent\\Model|static',
                        'types'             =>
                            [
                                0 => '\\Illuminate\\Database\\Eloquent\\Model',
                                1 => 'static',
                            ],
                        'type'              => '\\Illuminate\\Database\\Eloquent\\Model|static',
                        'name'              => 'return',
                        'description'       => '',
                        'parsedDescription' =>
                            [
                                0 => '',
                            ],
                        'docBlock'          => null,
                        'location'          => null,
                    ],
                ],
                'tags'              => Collection::class,
            ],
            'parameters'                 =>
                [
                    0 =>
                        [
                            'name'                  => 'attributes',
                            'passedByReference'     => false,
                            'type'                  =>
                                [
                                    'name'    => 'array',
                                    'builtin' => true,
                                ],
                            'callable'              => false,
                            'position'              => 0,
                            'optional'              => false,
                            'defaultValueAvailable' => false,
                            'variadic'              => false,
                        ],
                    1 =>
                        [
                            'name'                  => 'values',
                            'passedByReference'     => false,
                            'type'                  =>
                                [
                                    'name'    => 'array',
                                    'builtin' => true,
                                ],
                            'callable'              => false,
                            'position'              => 1,
                            'optional'              => true,
                            'defaultValueAvailable' => true,
                            'variadic'              => false,
                            'defaultValue'          =>
                                [
                                ],
                        ],
                ],
        ];
    }

}
