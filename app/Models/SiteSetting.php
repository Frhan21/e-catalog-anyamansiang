<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['group', 'key', 'payload'])]
class SiteSetting extends Model
{
    use HasFactory;

    public static function booted(): void
    {
        static::saved(fn (self $model) => Cache::forget("site_settings_{$model->key}"));
        static::deleted(fn (self $model) => Cache::forget("site_settings_{$model->key}"));
    }

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }
}
