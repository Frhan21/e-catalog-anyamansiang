<?php

namespace App\Models;

use App\Enums\AvailabilityStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id',
    'sku',
    'name',
    'slug',
    'price',
    'description',
    'dimensions',
    'material',
    'usage_instructions',
    'availability_status',
    'estimated_production_days',
    'is_featured',
    'is_active',
    'primary_image',
    'views_count',
])]
class Product extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'availability_status' => AvailabilityStatus::class,
            'estimated_production_days' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'views_count' => 'integer',
        ];
    }
}
