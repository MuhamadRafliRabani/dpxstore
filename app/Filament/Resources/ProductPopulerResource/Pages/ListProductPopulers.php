<?php

namespace App\Filament\Resources\ProductPopulerResource\Pages;

use App\Filament\Resources\ProductPopulerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductPopulers extends ListRecords
{
    protected static string $resource = ProductPopulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
