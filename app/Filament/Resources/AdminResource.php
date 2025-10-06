<?php

namespace App\Filament\Resources;

use App\Domain\Admin\Models\Admin;
use App\Filament\Resources\AdminResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $modelLabel = 'Admin';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Username')
                    ->placeholder('Masukkan username')
                    ->required()
                    ->minLength(4)
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->helperText('Gunakan minimal 4 karakter.'),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->placeholder('Masukkan email')
                    ->required()
                    ->minLength(6)
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->password()
                    ->minLength(6)
                    ->maxLength(255)
                    ->helperText('Minimal 6 karakter.')
                    ->revealable(),

                Toggle::make('status')
                    ->label('Aktifkan Admin')
                    ->helperText('Aktifkan untuk mengizinkan admin ini masuk ke sistem.')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('date_create')
                    ->label('Tanggal Daftar')
                    ->dateTime('M Y, d')
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
