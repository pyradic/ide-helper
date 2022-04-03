<?php

namespace Pyro\IdeHelper\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Support\Facades\File;

class ResolveAllResources
{

    public function handle(
        AddonCollection $addons)
    {
        $data = collect();
        foreach ($addons->all() as $addon) {
            $path     = $addon->getPath('resources');
            $allFiles = File::allFiles($path);

            foreach ($allFiles as $file) {
                $data->add([
                    'lookup_string' => $addon->getNamespace($file->getRelativePathname()),
                    'type_text'     => "[{$file->getExtension()}]",
                    'tail_text'     => "",
                    'icon'          => "com.jetbrains.php.PhpIcons.STATIC_FIELD",
                    'type'          => $file->getPathname(),
                    'target'        => $file->getPathname(),
                ]);
            }
        }
        return $data;
    }
}
