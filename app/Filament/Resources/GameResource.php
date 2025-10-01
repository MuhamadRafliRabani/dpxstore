<?php

namespace App\Filament\Resources;

use App\Domain\Products\Models\products;
use App\Filament\Resources\GameResource\Pages;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Get;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GameResource extends Resource
{
    protected static ?string $model = products::class;
    protected static ?string $navigationGroup = 'Manajemen Kontent';
    protected static ?string $navigationLabel = 'Game';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama Game')
                ->required()
                ->maxLength(100),

            Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->preload()
                ->required()
                ->searchable()
                ->createOptionForm([
                    TextInput::make('name')->label('Nama Kategori')->required(),

                    TextColumn::make('title')
                        ->label('Title'),

                    TextColumn::make('description')
                        ->label('Description'),
                ]),

            Hidden::make('slug')
                ->default(fn(Get $get) => Str::slug($get('name')))
                ->dehydrated(true),

            TextInput::make('provider')
                ->label('Provider')
                ->maxLength(55)
                ->required(),

            TextInput::make('publisher')
                ->label('Publisher')
                ->maxLength(100),

            TextInput::make('code')
                ->label('Kode Game')
                ->maxLength(55)
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'On' => 'On',
                    'Off' => 'Off',
                ])
                ->required(),

            FileUpload::make('image')
                ->label('Gambar')
                ->image()
                ->directory('games')
                ->disk('public')
                ->imageEditor()
                ->required(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            ImageColumn::make('image')
                ->label('Logo')
                ->disk('public')
                ->height(50)
                ->width(50),

            TextColumn::make('name')
                ->label('Nama Game')
                ->searchable()
                ->sortable(),

            TextColumn::make('category.name')
                ->label('Kategori')
                ->sortable(),

            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'success' => 'On',
                    'danger' => 'Off',
                ]),

            TextColumn::make('code')
                ->label('Kode'),

            TextColumn::make('publisher')
                ->label('Publisher'),

            TextColumn::make('provider')
                ->label('Provider'),
        ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
        ;
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
