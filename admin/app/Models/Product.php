<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'imageUrl',
        'categoryId',
    ];

    // ─── Relations ────────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class, 'productId');
    }

    public function customizations(): HasMany
    {
        return $this->hasMany(ProductCustomization::class, 'productId');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'productId')
                    ->orderBy('order');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
