<?php

namespace App\Actions;

use App\Support\Traits\Makeable;
use SimonHamp\TheOg\Background;
use SimonHamp\TheOg\Image;

class GenerateSocialImage
{
    use Makeable;

    public function execute(string $url, $firstDilemma, $secondDilemma)
    {
        $hash = md5($url);

        if (! is_dir(storage_path('app/public/opengraph'))) {
            mkdir(storage_path('app/public/opengraph'));
        }

        if (file_exists(storage_path("app/public/opengraph/$hash.png"))) {
            return;
        }

        (new Image())
            ->accentColor('#cc0000')
            ->border()
            ->url($url)
            ->title('Dilemma')
            ->description(<<<TEXT
        $firstDilemma

        $secondDilemma
    TEXT)
            ->background(Background::GridMe, 0.3)
            ->save(storage_path("app/public/opengraph/$hash.png"));


    }
}
