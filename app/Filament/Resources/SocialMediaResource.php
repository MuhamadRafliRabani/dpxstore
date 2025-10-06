<?php

namespace App\Filament\Resources;

use App\Domain\SocialMedia\Model\SocialMedia;
use App\Filament\Resources\SocialMediaResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;

class SocialMediaResource extends Resource
{
    protected static ?string $model = SocialMedia::class;


    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $navigationIcon = 'heroicon-o-window';
    protected static ?string $modelLabel = 'Media Sosial';
    protected static ?string $navigationParentItem = 'Website';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('facebook')
                    ->label('Facebook URL')
                    ->placeholder('Isi URL Facebook, atau biarkan kosong jika tidak ingin aktif')
                    ->maxLength(200),

                TextInput::make('instagram')
                    ->label('Instagram URL')
                    ->placeholder('Isi URL Instagram, atau biarkan kosong jika tidak ingin aktif')
                    ->maxLength(200),

                TextInput::make('email')
                    ->label('Email atau Link Email')
                    ->placeholder('Isi Email, atau biarkan kosong jika tidak ingin aktif')
                    ->maxLength(200),

                TextInput::make('youtube')
                    ->label('YouTube URL')
                    ->placeholder('Isi URL YouTube, atau biarkan kosong jika tidak ingin aktif')
                    ->maxLength(200),

                TextInput::make('tiktok')
                    ->label('TikTok URL')
                    ->placeholder('Isi URL TikTok, atau biarkan kosong jika tidak ingin aktif')
                    ->maxLength(200),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('facebook')
                    ->label('Facebook'),

                TextColumn::make('instagram')
                    ->label('Instagram'),

                TextColumn::make('email')
                    ->label('Email'),

                TextColumn::make('youtube')
                    ->label('YouTube'),

                TextColumn::make('tiktok')
                    ->label('TikTok')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialMedia::route('/'),
            'edit' => Pages\EditSocialMedia::route('/{record}/edit'),
        ];
    }
}
