<?php

namespace Pyro\IdeHelper\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class GenerateAddonCollectionExamples  extends AbstractGenerator
{
    public function handle(AddonCollection $addons)
    {
        $body=$addons->map(function(Addon $addon){
           $class=get_class($addon);
            return  "'{$addon->getNamespace()}' => \\{$class}::class,";
        })->implode("\n");
        $body = <<<EOF
    public static function addonTypeFqns()
    {
        return [
            /** ['tail_text' => "field type", 'type_text' => "CheckboxesFieldType", 'icon' => "com.jetbrains.php.PhpIcons.CLASS" */
            {$body}
        ];
    }
EOF;
        $result=$this->wrap($body);
        $this->write($result);
        return $result;
    }
    protected function wrap(string $body)
    {
        return <<<EOF
<?php

namespace {$this->namespace};

class AddonCollectionExamples
{
    public static function addonType()
    {
        return array_keys(self::addonTypeFqns());
    }

    {$body}
}
EOF;

    }
}

/*


    /**
     * @param string $namespace = static::addonType()[$any]
     *
     * @return object = new (self::addonTypeFqns()[$namespace])
     *
public function getAddon($namespace)
{

}

 */
