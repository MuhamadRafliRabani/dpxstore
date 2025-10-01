<?php

namespace App\Filament\Resources;

use App\Domain\ProductPopuler\Models\ProductPopuler;
use App\Filament\Resources\ProductPopulerResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductPopulerResource extends Resource
{
    protected static ?string $model = ProductPopuler::class;
    protected static ?string $navigationGroup = 'Produk & Layanan';
    protected static ?string $navigationLabel = 'Produk Populer';
    protected static ?int $navigationSort = 2; // Atur urutan navigasi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('game_id')
                    ->label('Game')
                    ->relationship('games', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm([])
                    ->columnSpan(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('games.name')
                    ->label('Nama Game')
                    ->searchable(),

                TextColumn::make('games.publisher')
                    ->label('Publisher')
                    ->searchable(),

                ImageColumn::make('games.image')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(50)
                    ->width(50),

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
