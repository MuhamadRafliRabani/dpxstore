<?php

namespace App\Filament\Resources;

use App\Domain\Product\Models\Product_dt;
use App\Filament\Resources\ProductItemsResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductItemsResource extends Resource
{
    protected static ?string $model = Product_dt::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $modelLabel = 'Products Items';
    protected static ?string $navigationParentItem = 'Products';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('product_name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('categories.name')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable(),


                TextColumn::make('type')
                    ->label('Type'),

                TextColumn::make('seller_name')
                    ->label('Nama Saller'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr', true)
                    ->sortable(),

                TextColumn::make('buyer_sku_code')
                    ->label('Buyer SKU Code'),

                TextColumn::make('buyer_product_status')
                    ->label('Buyer Product Status')
                    ->badge()
                    ->color(fn(string $state): string => $state == '1' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == '1' ? 'Active' : 'Inactive')->sortable(),

                TextColumn::make('seller_product_status')
                    ->label('Saller Product Status')
                    ->badge()
                    ->color(fn(string $state): string => $state == '1' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == '1' ? 'Active' : 'Inactive')->sortable(),

                TextColumn::make('unlimited_stock')
                    ->label('Unlimited Stock')
                    ->badge()
                    ->color(fn(string $state): string => $state == '1' ? 'success' : 'warning')

                    ->formatStateUsing(fn($state) => $state == '1' ? 'Unlimited' : 'Limited')->sortable(),

                TextColumn::make('stock')
                    ->label('Stock')->sortable(),

                TextColumn::make('multi')
                    ->label('Multi')->sortable(),

                TextColumn::make('start_cut_off')
                    ->label('Start Cut Off'),

                TextColumn::make('end_cut_off')
                    ->label('End Cut Off'),

                TextColumn::make('desc')
                    ->label('Description'),

                TextColumn::make('creby')
                    ->label('Created By'),

                TextColumn::make('cretime')
                    ->label('Created Time'),

                TextColumn::make('modby')
                    ->label('Modified By'),

                TextColumn::make('modtime')
                    ->label('Modified Time'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListProductItems::route('/'),
            // 'create' => Pages\CreateProductItems::route('/create'),
            'edit' => Pages\EditProductItems::route('/{record}/edit'),
        ];
    }
}
