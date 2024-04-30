<?php

namespace App\Actions;

use App\Support\Traits\Makeable;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class GetDilemma
{
    use Makeable;

    public function execute(string $file)
    {
        $path = resource_path('dilemmas');

        // Find markdown files in the dilemmas directory
        $files = collect(File::files($path))
            ->filter(function (SplFileInfo $file) {
                return $file->getExtension() === 'md';
            });

        /** @var SplFileInfo $dilemma */
        $dilemma = $files->first(function (SplFileInfo $f) use ($file) {
            return $f->getFilename() === $file;
        });

        return $dilemma->getPathname();
    }
}