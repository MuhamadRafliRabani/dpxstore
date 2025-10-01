<?php

namespace App\Filament\Resources;

use App\Domain\Product\Models\Product;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Produk & Layanan';
    protected static ?string $navigationLabel = 'Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('game_id')
                    ->label('Game')
                    ->relationship('games', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('categories', 'name')
                    ->preload()
                    ->searchable()
                    ->optionsLimit(50)
                    ->required(),

                TextInput::make('product')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(250),

                TextInput::make('product_ref')
                    ->label('Product Ref')
                    ->required()
                    ->maxLength(50),

                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required(),

                TextInput::make('raw_price')
                    ->label('Harga Dasar')
                    ->numeric()
                    ->required(),

                TextInput::make('provider')
                    ->required()
                    ->maxLength(250),

                TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->maxLength(250),

                Select::make('status')
                    ->options([
                        'On' => 'Aktif',
                        'Off' => 'Nonaktif',
                    ])
                    ->required(),

                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->directory('product')
                    ->disk('public')
                    ->preserveFilenames()
                    ->imageEditor(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('games.name')
                    ->label('Game')
                    ->searchable(),

                TextColumn::make('categories.name')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('product')
                    ->label('Produk'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(
                        fn($state) =>
                        Str::of(Number::currency($state, 'IDR', 'id'))->replace(',00', '')
                    )
                    ->sortable(),

                TextColumn::make('provider'),

                TextColumn::make('sku'),

                TextColumn::make('status'),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
