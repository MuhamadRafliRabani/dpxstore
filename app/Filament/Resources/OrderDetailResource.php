<?php

namespace App\Filament\Resources;

use App\Domain\Order\Models\OrderDtDB;
use App\Filament\Resources\OrderDetailResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderDetailResource extends Resource
{
    protected static ?string $model = OrderDtDB::class;
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $modelLabel = 'Order Detail';

    protected static ?string $navigationParentItem = 'Order';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                TextColumn::make('order.order_code')
                    ->label('Order Code')
                    ->copyable()
                    ->copyMessage('Code Copied')
                    ->copyMessageDuration(1000)
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('product.name')
                    ->label('Product')
                    ->placeholder('-')
                    ->searchable(),

                // TextColumn::make('voucher.code')
                //     ->label('Voucher')
                //     ->searchable(),

                TextColumn::make('user_id')
                    ->placeholder('-')
                    ->label('User ID'),

                TextColumn::make('zone_id')
                    ->placeholder('-')
                    ->label('Zone ID'),

                TextColumn::make('username')
                    ->placeholder('-')
                    ->label('Username'),

                TextColumn::make('no_handphone')
                    ->placeholder('-')
                    ->label('No Handphone'),

                TextColumn::make('no_akun')
                    ->placeholder('-')
                    ->label('No Akun'),

                TextColumn::make('whatsapp')
                    ->placeholder('-')
                    ->label('WhatsApp'),

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
            'index' => Pages\ListOrderDetails::route('/'),
        ];
    }
}
