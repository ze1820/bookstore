<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'published_at' => 'date',
        ];
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BookImage::class)->orderBy('sort');
    }

    public function getCurrentPriceCentsAttribute(): int
    {
        return $this->sale_price_cents ?? $this->price_cents;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price_cents !== null
            && $this->sale_price_cents < $this->price_cents;
    }
}