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

        if (file_exists(public_path("opengraph/$hash.png"))) {
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
            ->save(public_path("opengraph/$hash.png"));


    }
}
