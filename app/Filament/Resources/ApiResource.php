<?php

namespace App\Filament\Resources;

use App\Domain\Api\Model\Api;
use App\Filament\Resources\ApiResource\Pages;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ApiResource extends Resource
{
    protected static ?string $model = Api::class;
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $modelLabel = 'Api';


    public static function form(Form $form): Form
    {
        return $form->schema([
            // Midtrans
            Fieldset::make('Midtrans')
                ->columns(2)
                ->schema([
                    TextInput::make('midtrans_server_key')
                        ->label('Server Key')
                        ->required(fn(callable $get) => filled($get('midtrans_client_key'))),

                    TextInput::make('midtrans_client_key')
                        ->label('Client Key')
                        ->required(fn(callable $get) => filled($get('midtrans_server_key'))),
                ]),

            // Digiflazz
            Fieldset::make('Digiflazz')
                ->columns(2)
                ->schema([
                    TextInput::make('digiflazz_username')
                        ->label('Username')
                        ->required(fn(callable $get) => filled($get('digiflazz_api_key'))),

                    TextInput::make('digiflazz_api_key')
                        ->label('API Key')
                        ->required(fn(callable $get) => filled($get('digiflazz_username'))),
                ]),

            // APIGames
            Fieldset::make('APIGames')
                ->columns(2)
                ->schema([
                    TextInput::make('apigames_secret')
                        ->label('Secret Key')
                        ->required(fn(callable $get) => filled($get('apigames_merchant_id'))),

                    TextInput::make('apigames_merchant_id')
                        ->label('Merchant ID')
                        ->required(fn(callable $get) => filled($get('apigames_secret'))),
                ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('midtrans_client_key')
                    ->label('Midtrans Client Key')
                    ->limit(50, end: ' ...')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('midtrans_server_key')
                    ->label('Midtrans Server Key')
                    ->limit(50, end: ' ...')

                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('digiflazz_username')
                    ->label('Digiflazz Username')
                    ->limit(50, end: ' ...')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('digiflazz_api_key')
                    ->label('Digiflazz Api Key')
                    ->limit(50, end: ' ...')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('apigames_merchant_id')
                    ->label('APIGAMES Merchant ID')
                    ->limit(50, end: ' ...')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('apigames_secret')
                    ->label('APIGAMES Secret')
                    ->limit(50, end: ' ...')
                    ->placeholder('-'),

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
            'index' => Pages\ListApis::route('/'),
            'create' => Pages\CreateApi::route('/create'),
            'edit' => Pages\EditApi::route('/{record}/edit'),
        ];
    }
}
