<?php

namespace App\Filament\Resources\ProductItemsResource\Pages;

use App\Filament\Resources\ProductItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductItems extends EditRecord
{
    protected static string $resource = ProductItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
