<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    public $timestamps = false;   // only has createdAt (set manually or via DB default)

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;

    protected $fillable = [
        'companyName',
        'contactName',
        'email',
        'phone',
        'description',
        'status',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
    ];
}
