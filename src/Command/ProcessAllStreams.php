<?php

namespace Pyradic\IdeHelper\Command;


use Laradic\Idea\GeneratedCompletion;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class ProcessAllStreams
{
    use DispatchesJobs;

    public function handle(AddonCollection $addons)
    {

        $streams = $this->dispatchNow(new FindAllStreams($addons->installed()));
        $streams[base_path('vendor/anomaly/streams-platform/src/Assignment')] = 'Anomaly\Streams\Platform';
        $streams[base_path('vendor/anomaly/streams-platform/src/Stream')] = 'Anomaly\Streams\Platform';
        $streams[base_path('vendor/anomaly/streams-platform/src/Entry')] = 'Anomaly\Streams\Platform';
        $streams[base_path('vendor/anomaly/streams-platform/src/Version')] = 'Anomaly\Streams\Platform';
        $streams[base_path('vendor/anomaly/streams-platform/src/Field')] = 'Anomaly\Streams\Platform';
        /** @var \Laradic\Generators\DocBlock\ClassDoc[] $classes */
        $classes = [];
        $processed = [];
        foreach ($streams as $path => $namespace) {
            $classes = $this->dispatchNow(new ProcessStream($path, $namespace));
            foreach($classes as $class){
                $processed[] = $class->process();
            }
        }
        return $processed;
    }

}
