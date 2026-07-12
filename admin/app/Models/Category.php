<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'imageUrl',
    ];

    // ─── Relations ────────────────────────────────────────────────────────────

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'categoryId');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Generate a unique slug from a given name.
     * If the slug already exists (excluding current model), append a numeric suffix.
     */
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

    public function canBeDeleted(): bool
    {
        return $this->products()->doesntExist();
    }
}
