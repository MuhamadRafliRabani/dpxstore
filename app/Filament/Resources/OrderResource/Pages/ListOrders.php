<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return fn($record) => route('filament.admin.resources.order-details.index', ['tableSearch' => $record->order_code]);
    }
}
