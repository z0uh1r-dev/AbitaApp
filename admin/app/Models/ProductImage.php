<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['url', 'alt', 'order', 'productId'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
