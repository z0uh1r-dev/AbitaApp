<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncProductImages extends Command
{
    // --force to overwrite existing imageUrl values
    protected $signature = 'products:sync-images {--force : Overwrite existing imageUrl values if set}';
    protected $description = 'Assign main images to products based on files in storage/app/public/products';

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

        // counters used to rotate through files per folder
        $counters = [];

        // simple keyword->folder mapping to handle irregular slugs
        $mapping = [
            'hightech' => 'hightech',
            'office'   => 'office',
            'gift'     => 'gift-sets',
            'coffret'  => 'gift-sets',
            'bloc'     => 'notebooks',
            'notes'    => 'notebooks',
            'pack'     => 'packs',
            'thermos'  => 'thermos-mugs-bottles',
            'mug'      => 'thermos-mugs-bottles',
            'bouteille'=> 'thermos-mugs-bottles',
            'stylo'    => 'writing',
            'ecriture' => 'writing',
            'event'    => 'events',
            'gallery'  => 'gallery',
        ];

        Product::orderBy('id')->get()->each(function (Product $product) use (&$assigned, &$counters, $filesByFolder, $force, $mapping) {
            // skip if imageUrl already present and not forcing
            if (! $force && $product->imageUrl) {
                return;
            }

            // determine candidate folder by slug prefix or mapping
            $folder = null;
            if (preg_match('/^([^-]+)/', $product->slug, $m)) {
                $pref = $m[1];
                if (isset($filesByFolder[$pref])) {
                    $folder = $pref;
                }
            }

            if (! $folder) {
                foreach ($mapping as $keyword => $f) {
                    if (str_contains($product->slug, $keyword) && isset($filesByFolder[$f])) {
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

            // determine index for this folder
            $idx = $counters[$folder] ?? 0;
            if ($idx >= count($files)) {
                // wrap around if we run out
                $idx = 0;
            }
            $file = $files[$idx];
            $counters[$folder] = $idx + 1;

            $product->imageUrl = "products/{$folder}/{$file}";
            $product->save();
            $assigned++;
            $this->info("Assigned {$product->slug} -> {$product->imageUrl}");
        });

        $this->info("Completed, assigned {$assigned} images.");

        return 0;
    }
}
