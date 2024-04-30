<?php

namespace App\Actions;

use App\Support\Traits\Makeable;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class GetTwoRandomDilemmas
{
    use Makeable;

    /**
     * @return array<SplFileInfo>
     */
    public function execute()
    {
        $path = resource_path('dilemmas');

        // Find markdown files in the dilemmas directory
        $files = collect(File::files($path))
            ->filter(function (SplFileInfo $file) {
                return $file->getExtension() === 'md';
            });

        $randomDilemmas = $files->random(2);

        return [
            $randomDilemmas[0],
            $randomDilemmas[1],
        ];
    }
}
