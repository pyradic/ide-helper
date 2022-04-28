<?php

namespace Pyro\IdeHelper\PhpToolbox;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Laradic\Idea\Toolbox\AbstractToolboxGenerator;
use Oaty\Platform\Support\Assets;
use Symfony\Component\Finder\Finder;

class   ResourcesToolboxGenerator extends AbstractToolboxGenerator
{
    /**
     * @param       $directory
     * @param false $hidden
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    public function allFiles($directory, $hidden = false)
    {
        return iterator_to_array(
            Finder::create()->files()->followLinks()->ignoreDotFiles(! $hidden)->in($directory)->sortByName(),
            false
        );
    }

    public function handle(
        AddonCollection $addons)
    {
        $icons = collect([
            'html' => "com.intellij.util.PlatformIcons.XML_TAG_ICON",
            'js'   => "com.intellij.util.PlatformIcons.FUNCTION_ICON",
            'css'  => 'com.intellij.icons.AllIcons$Xml.Css_class',
            'php'  => "com.jetbrains.php.PhpIcons.PHP_FILE",
            'jpg'  => 'com.intellij.util.PlatformIcons.WEB_ICON',
            'png'  => 'com.intellij.util.PlatformIcons.WEB_ICON',
            'jpeg' => 'com.intellij.util.PlatformIcons.WEB_ICON',
        ]);
        $data  = collect();
        foreach ($addons->all() as $addon) {
            $path     = $addon->getPath('resources');
            if($path === '/resources'){
                continue;
            }
            $allFiles = $this->allFiles($path);

            foreach ($allFiles as $file) {
                $target = str_replace(base_path(), 'file:///', $file->getPathname());
                $ext    = $file->getExtension();
                $item   = collect([
                    'addon'         => $addon,
                    'file'          => $file,
                    'path'          => $file->getRelativePath(),
                    'extension'     => $ext,
                    'lookup_string' => $addon->getNamespace($file->getRelativePathname()),
                    'type_text'     => "[{$ext}]",
//                    'tail_text'     => '',
//    'icon' => '',
//    'type'          => Image::class,
                    'type'          => Assets::class,
                    'target'        => $target,
                ]);
                if ($icons->has($ext)) {
                    $item->put('icon', $icons->get($ext));
                }
                $data->add($item);
            }
        }
        $allowedFields = [ 'lookup_string', 'type_text', 'tail_text', 'icon', 'type', 'target' ];
        $this->metadata()
            ->merge([
                'registrar' => [
                    [
                        'provider'   => 'pyro_resources_nophp',
                        'language'   => 'twig',
                        'signatures' => [
                            [
                                'function' => 'img',
                                'index'    => 0,
                            ],
                        ],
                    ],
                    [
                        'provider'   => 'pyro_resources_nophp',
                        'language'   => 'twig',
                        'signatures' => [
                            [
                                'function' => 'spa_asset_url',
                                'type'     => 'type',
                                'index'    => 0,
                            ],
                        ],
                    ],
                ],
                'providers' => [
                    [
                        'name'     => 'pyro_resources',
                        'defaults' => [
                            'icon' => 'com.intellij.icons.AllIcons$FileTypes.Unknown',
                        ],
                        'items'    => $data->map->only($allowedFields)->values()->toArray(),
                    ],
                    [
                        'name'     => 'pyro_resources_php',
                        'defaults' => [
                            'icon' => $icons->get('php'),
                        ],
                        'items'    => $data->where('extension', 'php')->map->only($allowedFields)->values()->toArray(),
                    ],
                    [
                        'name'     => 'pyro_resources_nophp',
                        'defaults' => [
                            'icon' => 'com.intellij.icons.AllIcons$FileTypes.Unknown',
                        ],
                        'items'    => $data->where('extension', '!=', 'php')->map->only($allowedFields)->values()->toArray(),
                    ],
                ],
            ])
            ->save();
    }
}
