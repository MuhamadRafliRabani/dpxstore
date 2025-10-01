<?php

namespace App\Filament\Resources;

use App\Domain\Banner\Models\Banner;
use App\Filament\Resources\BannerResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationGroup = 'Konfigurasi Website';
    protected static ?string $navigationLabel = 'Banner';

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

            Toggle::make('status')
                ->label('Aktifkan Banner')
                ->default(true)
                ->columnSpan(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('image')
                ->label('Gambar')
                ->height(50),

            ToggleColumn::make('status')
                ->label('Aktifkan Banner'),

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
