<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookImage extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}