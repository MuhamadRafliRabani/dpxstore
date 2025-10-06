<?php

namespace App\Filament\Resources;

use App\Domain\Banner\Models\Banner;
use App\Filament\Resources\BannerResource\Pages;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $modelLabel = 'Layout';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('image')
                ->label('Gambar')
                ->disk('public')
                ->directory('banners')
                ->visibility('public')
                ->image()
                ->storeFiles()
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                ->imagePreviewHeight('250')
                ->required()
                ->columnSpan(3),

            Checkbox::make('status')
                ->label('Status')
                ->inline(false)
                ->default(1),

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
        return $table->columns([
            TextColumn::make('id')->sortable(),

            ImageColumn::make('image')
                ->label('Gambar')
                ->height(50),

            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn(string $state): string => $state == '1' ? 'success' : 'danger')
                ->formatStateUsing(fn($state) => $state == '1' ? 'Active' : 'Inactive')->sortable(),

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
                // Tambah filter jika diperlukan
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
