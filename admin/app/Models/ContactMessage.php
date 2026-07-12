<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    public $timestamps = false;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = null;

    protected $fillable = [
        'fullName',
        'companyName',
        'phone',
        'email',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'createdAt' => 'datetime',
        ];
    }
}
