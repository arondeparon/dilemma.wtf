<?php

namespace App\Console\Commands;

use App\Models\Dilemma;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class SeedDilemmas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-dilemmas';

    protected $description = 'Create database entries for dilemmas that do not yet exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = resource_path('dilemmas');

        // Find markdown files in the dilemmas directory
        $files = collect(File::files($path))
            ->filter(function (SplFileInfo $file) {
                return $file->getExtension() === 'md';
            });

        foreach ($files as $file) {
            $title = trim(file_get_contents($file->getPathname()));
            Dilemma::firstOrCreate([
                'title' => $title,
            ]);
        }

        $this->info('✅ Done!');

    }
}
