<?php

namespace App\Support\Og;

class Image extends \SimonHamp\TheOg\Image
{
    public readonly string $firstDilemma;

    public readonly string $secondDilemma;

    public function firstDilemma(string $dilemma): self
    {
        $this->firstDilemma = $dilemma;

        return $this;
    }

    public function secondDilemma(string $dilemma): self
    {
        $this->secondDilemma = $dilemma;

        return $this;
    }
}
