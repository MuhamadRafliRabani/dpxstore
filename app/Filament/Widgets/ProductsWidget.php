<?php

namespace App\Filament\Widgets;

use App\Domain\Order\Models\OrderDB;
use App\Domain\Product\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsWidget extends BaseWidget
{
    // protected ?string $heading = 'Analytics';

    // protected ?string $description = 'An overview of some analytics.';

    protected function getStats(): array
    {
        $profits = OrderDB::where('status', 'Success')->sum('price');;

        return [
            Stat::make('Products', Product::count())
                ->description(Product::where('status', 1)->count() . ' products sedang live')
                ->descriptionIcon('heroicon-m-squares-2x2', IconPosition::Before)
                ->chart([1, 45, 15, 27, 65])
                ->color('success'),
            Stat::make('Orders', OrderDB::where('status', 'Success')->count())
                ->description(OrderDB::where('status', 'Success')->count() . ' order success')
                ->descriptionIcon('heroicon-m-fire', IconPosition::Before)
                ->chart([1, 9, 45, 27, 65])
                ->color('success'),
            Stat::make('Profits', 'Rp. ' . number_format($profits, 0, ',', '.'))
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->chart([1, 22, 15, 33, 65])
                ->color('success'),
        ];
    }
}
