<?php

namespace App\Actions;

use App\Support\Traits\Makeable;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class GetTwoRandomDilemmas
{
    use Makeable;

    public function execute()
    {
        $path = storage_path('app/dilemmas');

        // Find markdown files in the dilemmas directory
        $files = collect(File::files($path))
            ->filter(function (SplFileInfo $file) {
                return $file->getExtension() === 'md';
            });

        // Get two random dilemmas
        $randomDilemmas = $files->random(2)
            ->map(function ($file) {
                return File::get($file->getPathname());
            });

        return [
            $randomDilemmas[0],
            $randomDilemmas[1],
        ];
    }
}
