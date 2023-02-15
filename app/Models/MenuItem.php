<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MenuItem extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'slug', 'price', 'discount', 'category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function discount(): Attribute
    {
        return Attribute::get(fn($val) => $val ?: $this->category->discount);
    }

    public function discountPrice(): Attribute
    {
        return Attribute::get(fn() => $this->discount ? $this->price * (1 - $this->discount / 100) : $this->price);
    }

    public function addDiscount($discount): bool
    {
        return $this->update(['discount' => $discount]);
    }
}
