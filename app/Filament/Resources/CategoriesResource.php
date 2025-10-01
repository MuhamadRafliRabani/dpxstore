<?php

namespace App\Filament\Resources;

use App\Domain\Category\Models\Category;
use App\Filament\Resources\CategoriesResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Manajemen Kontent';
    protected static ?string $navigationLabel = 'Kategori';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name'),
                TextInput::make('title')->label('Title'),
                TextInput::make('description')->label('Description')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Title'),

                TextColumn::make('description')
                    ->label('Description'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategories::route('/create'),
            'edit' => Pages\EditCategories::route('/{record}/edit'),
        ];
    }
}
