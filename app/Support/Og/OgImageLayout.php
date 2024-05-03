<?php

namespace App\Support\Og;

use Intervention\Image\Colors\Rgb\Color;
use SimonHamp\TheOg\Layout\Layouts\GitHubBasic;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Layout\TextBox;

class OgImageLayout extends GitHubBasic
{
    public function features(): void
    {
        $this->addFeature((new TextBox())
            ->name('title')
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size(60)
            ->box($this->mountArea()->box->width(), 400)
            ->position(
                x: 0,
                y: 0,
                relativeTo: function () {
                    if ($url = $this->getFeature('url')) {
                        return $url->anchor(Position::BottomLeft)
                            ->moveY(20);
                    }

                    return $this->mountArea()
                        ->anchor()
                        ->moveY(20);
                },
            )
        );

        $this->addFeature((new TextBox())
            ->name('firstDilemma')
            ->text($this->firstDilemma())
            ->color($this->config->theme->getDescriptionColor())
            ->font($this->config->theme->getDescriptionFont())
            ->size(80)
            ->box($this->mountArea()->box->width(), 200)
            ->position(
                x: 0,
                y: 50,
                relativeTo: fn() => $this->getFeature('title')->anchor(Position::BottomLeft),
            )
        );

        $this->addFeature((new TextBox())
            ->name('or')
            ->text('or')
            ->color(new Color(119, 119, 119))
            ->font($this->config->theme->getDescriptionFont())
            ->size(80)
            ->box($this->mountArea()->box->width(), 50)
            ->position(
                x: 0,
                y: 50,
                relativeTo: fn() => $this->getFeature('firstDilemma')->anchor(Position::BottomLeft),
            )
        );

        $this->addFeature((new TextBox())
            ->name('secondDilemma')
            ->text($this->secondDilemma())
            ->color($this->config->theme->getDescriptionColor())
            ->font($this->config->theme->getDescriptionFont())
            ->size(80)
            ->box($this->mountArea()->box->width(), 200)
            ->position(
                x: 0,
                y: 50,
                relativeTo: fn() => $this->getFeature('or')->anchor(Position::BottomLeft),
            )
        );


//        if ($description = $this->description()) {
//            $this->addFeature((new TextBox())
//                ->name('description')
//                ->text($description)
//                ->color($this->config->theme->getDescriptionColor())
//                ->font($this->config->theme->getDescriptionFont())
//                ->size(80)
//                ->box($this->mountArea()->box->width(), 400)
//                ->position(
//                    x: 0,
//                    y: 50,
//                    relativeTo: fn() => $this->getFeature('title')->anchor(Position::BottomLeft),
//                )
//            );
//        }

        if ($url = $this->url()) {
            $this->addFeature((new TextBox())
                ->name('url')
                ->text($url)
                ->color($this->config->theme->getUrlColor())
                ->font($this->config->theme->getUrlFont())
                ->size(28)
                ->box($this->mountArea()->box->width(), 45)
                ->position(
                    x: 0,
                    y: 20,
                    relativeTo: fn() => $this->mountArea()->anchor(),
                )
            );
        }
    }

    protected function firstDilemma(): ?string
    {
        return $this->config->firstDilemma ?? null;
    }

    protected function secondDilemma(): ?string
    {
        return $this->config->secondDilemma ?? null;
    }
}
