<?php

namespace App\Filament\Resources;

use App\Domain\Configuration\Model\Configuration;
use App\Filament\Resources\ConfigurationResource\Pages;
use App\Filament\Resources\ConfigurationResource\RelationManagers\BannersRelationManager;
use App\Filament\Resources\ConfigurationResource\RelationManagers\SocialMediaRelationManager;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ConfigurationResource extends Resource
{
    protected static ?string $model = Configuration::class;
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $modelLabel = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('website')
                    ->label('Website')
                    ->required()
                    ->maxLength(100),

                TextInput::make('keywords')
                    ->label('SEO Keywords')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('SEO Description')
                    ->maxLength(255),

                FileUpload::make('logo_header')
                    ->label('Logo Header')
                    ->image()
                    ->directory('logos')
                    ->required(),

                FileUpload::make('logo')
                    ->label('Icon Website')
                    ->image()
                    ->directory('logos')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('website')
                    ->label('Website')
                    ->copyable()
                    ->copyMessage('Website Name Copied')
                    ->copyMessageDuration(1000),

                TextColumn::make('keywords')
                    ->label('Keywords')
                    ->wrap()
                    ->lineClamp(5),

                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->lineClamp(5),

                ImageColumn::make('logo')
                    ->label('Icon Website')
                    ->disk('public')
                    ->circular(),

                ImageColumn::make('logo_header')
                    ->label('Logo Header')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('M Y, d'),
            ])
            ->filters([])
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
            // BannersRelationManager::class,
            // SocialMediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConfigurations::route('/'),
            'edit' => Pages\EditConfiguration::route('/{record}/edit'),
        ];
    }
}
