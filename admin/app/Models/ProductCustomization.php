<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCustomization extends Model
{
    public $timestamps = false;

    protected $fillable = ['label', 'productId'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
