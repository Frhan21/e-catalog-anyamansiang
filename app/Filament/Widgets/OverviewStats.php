<?php

namespace App\Filament\Widgets;

use App\Enums\AvailabilityStatus;
use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStats extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::count())
                ->icon('heroicon-o-shopping-bag'),
            Stat::make('Ready Stock', Product::where('availability_status', AvailabilityStatus::ReadyStock)->count())
                ->icon('heroicon-o-check-circle'),
            Stat::make('Pre-Order', Product::where('availability_status', AvailabilityStatus::PreOrder)->count())
                ->icon('heroicon-o-clock'),
            Stat::make('Stok Habis', Product::where('availability_status', AvailabilityStatus::OutOfStock)->count())
                ->icon('heroicon-o-x-circle'),
            Stat::make('Total Artikel', Post::count())
                ->icon('heroicon-o-newspaper'),
            Stat::make('Draft', Post::where('status', PostStatus::Draft)->count())
                ->icon('heroicon-o-pencil-square'),
            Stat::make('Artikel Terbit', Post::published()->count())
                ->icon('heroicon-o-globe-alt'),
        ];
    }
}
