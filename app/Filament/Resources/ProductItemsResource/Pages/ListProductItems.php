<?php

namespace App\Filament\Resources\ProductItemsResource\Pages;

use App\Filament\Resources\ProductItemsResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\SyncAction;
use Illuminate\Support\Facades\Http;

class ListProductItems extends ListRecords
{
    protected static string $resource = ProductItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('sync')
                ->label('Sync')
                ->icon('heroicon-m-cloud-arrow-down')
                ->url(route('sync.product')) // langsung buka route
                ->openUrlInNewTab(false), // kalau mau di tab yang sama
        ];
    }
}
