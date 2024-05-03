<?php

namespace App\Actions;

use App\Support\Og\Image;
use App\Support\Og\OgImageLayout;
use App\Support\Traits\Makeable;
use Illuminate\Support\Facades\Log;
use SimonHamp\TheOg\Background;

class GenerateSocialImage
{
    use Makeable;

    public function execute(string $hash, $firstDilemma, $secondDilemma)
    {
        if (! is_dir(storage_path('app/public/opengraph'))) {
            mkdir(storage_path('app/public/opengraph'));
        }

        if (file_exists(storage_path("app/public/opengraph/$hash.png"))) {
            return;
        }

        Log::info('Generating social image', [
            'url' => route('dilemma', ['hash' => $hash]),
            'path' => storage_path("app/public/opengraph/$hash.png"),
        ]);


        (new Image())
            ->layout(new OgImageLayout())
            ->accentColor('#1B0000')
            ->url(route('dilemma', ['hash' => $hash]))
            ->title('What do you prefer?')
            ->firstDilemma(trim($firstDilemma))
            ->secondDilemma(trim($secondDilemma))
            ->background(Background::GridMe, 0.4)
            ->save(storage_path("app/public/opengraph/$hash.png"));


    }
}
