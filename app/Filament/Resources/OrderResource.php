<?php

namespace App\Filament\Resources;

use App\Domain\Order\Models\OrderDB;
use App\Filament\Resources\OrderResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = OrderDB::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-fire';
    protected static ?string $modelLabel = 'Order';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                TextColumn::make('order_code')
                    ->label('Order Code')
                    ->copyable()
                    ->copyMessage('Code Copied')
                    ->copyMessageDuration(1000)
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Processing' => 'warning',
                        'Success' => 'success',
                        'Canceled' => 'danger',
                    }),

                TextColumn::make('start_process')
                    ->label('Start Process')
                    ->dateTime('d-m-Y, H:i'),

                TextColumn::make('end_process')
                    ->label('End Process')
                    ->dateTime('d-m-Y, H:i'),

                TextColumn::make('isvoucher')
                    ->label('Have Voucher')
                    ->badge()
                    ->color(fn(string $state): string => $state == '1' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == '1' ? 'Have' : 'Not Have')->sortable(),

                TextColumn::make('creby')
                    ->label('Created By'),

                TextColumn::make('cretime')
                    ->label('Created Time')
                    ->dateTime('d-m-Y, H:i'),

                TextColumn::make('modby')
                    ->label('Modified By'),

                TextColumn::make('modtime')
                    ->label('Modified Time')
                    ->dateTime('d-m-Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/')
        ];
    }
}
