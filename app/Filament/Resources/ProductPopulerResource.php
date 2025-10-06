<?php

namespace App\Filament\Resources;

use App\Domain\Product\Models\ProductFavorite;
use App\Filament\Resources\ProductPopulerResource\Pages;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductPopulerResource extends Resource
{
    protected static ?string $model = ProductFavorite::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $modelLabel = 'Products Favorite';
    protected static ?string $navigationParentItem = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm([])
                    ->columnSpan(2)
                    ->required(),

                Hidden::make('creby')
                    ->default(auth()->user()->name)
                    ->dehydrated(fn(string $operation) => $operation === 'create'),

                Hidden::make('cretime')
                    ->default(now())
                    ->dehydrated(fn(string $operation) => $operation === 'create'),

                Hidden::make('modby')
                    ->default(auth()->user()->name)
                    ->dehydrated(fn(string $operation) => $operation === 'edit'),

                Hidden::make('modtime')
                    ->default(now())
                    ->dehydrated(fn(string $operation) => $operation === 'edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('product.name')
                    ->label('Nama Game')
                    ->searchable(),

                TextColumn::make('product.publisher')
                    ->label('Publisher')
                    ->searchable(),

                ImageColumn::make('product.image')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(50)
                    ->width(50),

                TextColumn::make('creby')
                    ->label('Created By')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cretime')
                    ->label('Created Time')
                    ->sortable(),

                TextColumn::make('modby')
                    ->label('Modified By')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('modtime')
                    ->label('Modified Time')
                    ->sortable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProductPopulers::route('/'),
            'create' => Pages\CreateProductPopuler::route('/create'),
            'edit' => Pages\EditProductPopuler::route('/{record}/edit'),
        ];
    }
}
