<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Create a new product with all nested relations inside a single transaction.
     *
     * @param  array  $data  Validated data from StoreProductRequest
     */
    public function store(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            // handle main image upload; store path in imageUrl
            $payload = [
                'name'        => $data['name'],
                'slug'        => $data['slug'],
                'description' => $data['description'],
                'categoryId'  => $data['categoryId'],
            ];

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $payload['imageUrl'] = $data['image']->store('products', 'public');
            }

            $product = Product::create($payload);

            $this->syncSpecifications($product, $data['specifications'] ?? []);
            $this->syncCustomizations($product, $data['customizations'] ?? []);
            $this->syncImages($product, $data['images'] ?? []);

            return $product->load(['category', 'specifications', 'customizations', 'images']);
        });
    }

    /**
     * Update a product and its nested relations inside a single transaction.
     *
     * @param  array  $data  Validated data from UpdateProductRequest
     */
    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $update = [
                'name'        => $data['name'],
                'slug'        => $data['slug'],
                'description' => $data['description'],
                'categoryId'  => $data['categoryId'],
            ];

            // if the user submitted a new main image, delete old and store new
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($product->imageUrl) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($product->imageUrl);
                }
                $update['imageUrl'] = $data['image']->store('products', 'public');
            }

            $product->update($update);

            $this->syncSpecifications($product, $data['specifications'] ?? []);
            $this->syncCustomizations($product, $data['customizations'] ?? []);
            $this->syncImages($product, $data['images'] ?? []);

            return $product->refresh()->load(['category', 'specifications', 'customizations', 'images']);
        });
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    /**
     * Replace all specifications for the product.
     * We delete-then-insert: simple and avoids partial-update edge cases.
     */
    private function syncSpecifications(Product $product, array $specs): void
    {
        $product->specifications()->delete();

        $rows = [];
        foreach ($specs as $spec) {
            $label = trim($spec['label'] ?? '');
            $value = trim($spec['value'] ?? '');
            if ($label !== '' && $value !== '') {
                $rows[] = ['label' => $label, 'value' => $value, 'productId' => $product->id];
            }
        }

        if ($rows) {
            $product->specifications()->insert($rows);
        }
    }

    /**
     * Replace all customization options for the product.
     */
    private function syncCustomizations(Product $product, array $customs): void
    {
        $product->customizations()->delete();

        $rows = [];
        foreach ($customs as $label) {
            $label = trim($label);
            if ($label !== '') {
                $rows[] = ['label' => $label, 'productId' => $product->id];
            }
        }

        if ($rows) {
            $product->customizations()->insert($rows);
        }
    }

    /**
     * Sync gallery images for the product.
     * Updates orders/alts for retained images and adds new uploads.
     */
    private function syncImages(Product $product, array $images): void
    {
        $rowsByUrl = [];
        $usedOrders = [];
        $retainedUrls = [];

        foreach ($images as $img) {
            $order = (int) ($img['order'] ?? 0);
            if ($order < 1) {
                continue;
            }

            // skip duplicate orders
            if (isset($usedOrders[$order])) {
                continue;
            }

            $usedOrders[$order] = true;

            // determine URL: either new uploaded file or existing path
            $url = null;
            if (! empty($img['file']) && $img['file'] instanceof \Illuminate\Http\UploadedFile) {
                // new file upload
                $url = $img['file']->store('products', 'public');
            } elseif (! empty($img['existing'])) {
                // existing image being retained
                $url = $img['existing'];
                // normalize URL - remove any leading /images/ prefix
                if (str_starts_with($url, '/images/products/')) {
                    $url = str_replace('/images/products/', 'products/', $url);
                }
                $retainedUrls[] = $url;
            }

            if (! $url) {
                continue;
            }

            $rowsByUrl[$url] = [
                'url'       => $url,
                'alt'       => trim($img['alt'] ?? '') ?: null,
                'order'     => $order,
                'productId' => $product->id,
            ];
        }

        // delete images that are NOT being retained
        $toDelete = $product->images()->whereNotIn('url', $retainedUrls)->get();
        $toDelete->each(fn($img) => \Illuminate\Support\Facades\Storage::disk('public')->delete($img->url));
        $product->images()->whereNotIn('url', $retainedUrls)->delete();

        // update existing images with new alt/order values
        foreach ($retainedUrls as $url) {
            if (isset($rowsByUrl[$url])) {
                $product->images()->where('url', $url)->update([
                    'alt'   => $rowsByUrl[$url]['alt'],
                    'order' => $rowsByUrl[$url]['order'],
                ]);
            }
        }

        // insert only new images (those not in retainedUrls)
        $newRows = array_filter($rowsByUrl, fn($row, $url) => ! in_array($url, $retainedUrls), ARRAY_FILTER_USE_BOTH);
        if ($newRows) {
            $product->images()->insert(array_values($newRows));
        }
    }
}
