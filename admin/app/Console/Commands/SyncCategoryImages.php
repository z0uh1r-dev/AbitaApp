<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncCategoryImages extends Command
{
    // --force to overwrite existing imageUrl values
    protected $signature = 'categories:sync-images {--force : Overwrite existing imageUrl values if set}';
    protected $description = 'Assign images to categories based on files in storage/app/public/products';

    public function handle(): int
    {
        $base = storage_path('app/public/products');

        if (! is_dir($base)) {
            $this->error("Directory {$base} does not exist.");
            return 1;
        }

        $filesByFolder = [];

        foreach (\File::directories($base) as $dir) {
            $folder = basename($dir);
            $filesByFolder[$folder] = collect(\File::files($dir))->map(fn($f) => $f->getFilename())->all();
        }

        $assigned = 0;
        $force = $this->option('force');

        // mapping of category slug keywords to folder names
        $mapping = [
            'gift' => 'gift-sets',
            'coffret' => 'gift-sets',
            'notebooks' => 'notebooks',
            'notes' => 'notebooks',
            'writing' => 'writing',
            'stylo' => 'writing',
            'hightech' => 'hightech',
            'office' => 'office',
            'packs' => 'packs',
            'thermos' => 'thermos-mugs-bottles',
            'mug' => 'thermos-mugs-bottles',
            'events' => 'events',
        ];

        $counters = [];

        Category::orderBy('id')->get()->each(function (Category $category) use (&$assigned, $filesByFolder, $force, $mapping, &$counters) {
            // skip if imageUrl already present and not forcing
            if (! $force && $category->imageUrl) {
                return;
            }

            // determine candidate folder by slug keyword matching
            $folder = null;

            // try direct match first
            if (isset($filesByFolder[$category->slug])) {
                $folder = $category->slug;
            }

            // fall back to mapping
            if (! $folder) {
                foreach ($mapping as $keyword => $f) {
                    if (str_contains($category->slug, $keyword) && isset($filesByFolder[$f])) {
                        $folder = $f;
                        break;
                    }
                }
            }

            if (! $folder) {
                return;
            }

            $files = $filesByFolder[$folder];
            if (empty($files)) {
                return;
            }

            // determine index for this folder using counter
            $idx = $counters[$folder] ?? 0;
            if ($idx >= count($files)) {
                // wrap around if we run out
                $idx = 0;
            }
            $file = $files[$idx];
            $counters[$folder] = $idx + 1;

            $category->imageUrl = "products/{$folder}/{$file}";
            $category->save();
            $assigned++;
            $this->info("Assigned {$category->slug} -> {$category->imageUrl}");
        });

        $this->info("Completed, assigned {$assigned} category images.");

        return 0;
    }
}
