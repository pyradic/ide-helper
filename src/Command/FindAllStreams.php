<?php /** @noinspection OneTimeUseVariablesInspection */

namespace Pyradic\IdeHelper\Command;

use ReflectionClass;
use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;

class FindAllStreams
{
    /** @var \Anomaly\Streams\Platform\Application\Application */
    protected $application;
    /** @var \Anomaly\Streams\Platform\Addon\AddonCollection */
    protected $addons;
    /** @var \Illuminate\Support\Collection */
    protected $entryModelClassNames;

    public function __construct(AddonCollection $addons)
    {
        $this->addons = $addons;
    }

    /**
     * @param \Anomaly\Streams\Platform\Application\Application $application
     * @param \Anomaly\Streams\Platform\Addon\AddonCollection   $addons
     * @return \ReflectionClass[]
     * @throws \ReflectionException
     */
    public function handle(Application $application, AddonCollection $addons)
    {
        $this->application          = $application;
        $this->entryModelClassNames = collect(require $application->getStoragePath('models/classmap.php'))->keys();
        return $this->search();
    }

    /**
     * @return \ReflectionClass[]
     * @throws \ReflectionException
     */
    public function search()
    {
        /** @var ReflectionClass[] $found */
        $found = [];
        foreach ($this->addons->all() as $addon) {
            /** @var \Anomaly\Streams\Platform\Addon\Addon $addon */
            $p               = $addon->getPath('src');
            $models          = rglob($p . '/**/*Model.php');
            $addonClass      = get_class($addon);
            $addonReflection = new ReflectionClass($addonClass);
            $namespace       = $addonReflection->getNamespaceName();
            foreach ($models as $modelPath) {
                $modelName    = path_get_filename_without_extension($modelPath);
                $path         = path_get_directory($modelPath);
                $relativePath = Str::replaceFirst($addon->getPath('src/'), '', $path);
                $modelClass   = implode("\\", [ $namespace, $relativePath, $modelName ]);
                if ($this->isStreamModel($modelClass)) {
                    $found[ $path ] = $namespace;
                }
            }
        }

        return $found;
    }

    protected function isStreamModel($class)
    {
        try {

            if ( ! class_exists($class)) {
                return false;
            }
            foreach ($this->entryModelClassNames as $entryModel) {
                if (is_subclass_of($class, $entryModel)) {
                    return true;
                }
            }
        }
        catch (\Throwable $e) {
        }
        return false;
    }


}
