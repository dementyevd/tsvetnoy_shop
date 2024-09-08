<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'size', 'price', 'remains'
    ];

    public function Images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function Cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function Orderlines(): HasMany
    {
        return $this->hasMany(Orderline::class);
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
