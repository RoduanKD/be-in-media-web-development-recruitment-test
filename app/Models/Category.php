<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'slug', 'discount', 'parent_id'];

    public function ancestors(): BelongsTo
    {
        return $this->parent()->with('parent');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function level(): Attribute
    {
        return Attribute::get(function () {
            $level = 1;
            $parent = $this;
            while ($parent = $parent->ancestors) {
                $level++;
            }

            return $level;
        });
    }

    public function discount(): Attribute
    {
        return Attribute::get(fn($val) => $val ?: ($this->parent?->discount ?? 0));
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function addDiscount($discount): bool
    {
        return $this->update(['discount' => $discount]);
    }
}
