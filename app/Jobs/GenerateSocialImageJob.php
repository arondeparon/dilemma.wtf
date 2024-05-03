<?php

namespace App\Jobs;

use App\Actions\GenerateSocialImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateSocialImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $hash,
        public string $firstDilemma,
        public string $secondDilemma
    )
    {
    }

    public function handle(): void
    {
        GenerateSocialImage::make()->execute($this->hash, $this->firstDilemma, $this->secondDilemma);
    }
}
