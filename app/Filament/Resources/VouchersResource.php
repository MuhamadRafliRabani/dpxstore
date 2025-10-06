<?php

namespace App\Filament\Resources;

use App\Domain\Root\Models\Voucher;
use App\Filament\Resources\VouchersResource\Pages;
use Filament\Forms\Form;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VouchersResource extends Resource
{
    protected static ?string $model = Voucher::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $modelLabel = 'Voucher';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Kode Voucher')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50)
                    ->placeholder('CONTOH20'),

                TextInput::make('name')
                    ->label('Nama Voucher')
                    ->placeholder('Diskon Akhir Tahun 20%')
                    ->required()
                    ->maxLength(100),

                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),

                Select::make('type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal Tetap'
                    ])
                    ->required()
                    ->live(),

                TextInput::make('discount_value')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric()
                    ->suffix(fn(Get $get) => $get('type') === 'percentage' ? '%' : 'IDR'),

                TextInput::make('max_discount')
                    ->label('Maksimal Diskon (opsional)')
                    ->placeholder('100.000')
                    ->numeric()
                    ->visible(fn(Get $get) => $get('type') === 'percentage')
                    ->helperText('Membatasi Harga Diskon (misal: 20% dari Rp 1jt = Rp 200K → terlalu besar)')
                    ->prefix('IDR'),

                TextInput::make('min_order_amount')
                    ->label('Minimal Belanja (optional)')
                    ->numeric()
                    ->prefix('IDR'),

                TextInput::make('usage_limit')
                    ->label('Batas Penggunaan')
                    ->integer()
                    ->minValue(1),

                DateTimePicker::make('start_date')
                    ->label('Mulai Berlaku')
                    ->required(),

                DateTimePicker::make('end_date')
                    ->label('Berakhir Pada')
                    ->required()
                    ->afterOrEqual('start_date'),

                Select::make('game_id')
                    ->label('Produk Tertentu (optional)')
                    ->relationship('games', 'name')
                    ->searchable()
                    ->preload(),

                Toggle::make('status')
                    ->label('Status Voucher')
                    ->inline(false)
                    ->default(true)
            ])
            ->columns(2);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Vocher')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn(Model $record) => $record->name),

                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal Tetap'
                    })
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'percentage' => 'info',
                        'fixed' => 'success'
                    }),

                TextColumn::make('discount_value')
                    ->label('Diskon')
                    ->formatStateUsing(fn(Model $record) => $record->type === 'percentage'
                        ? "{$record->discount_value}%"
                        : "IDR " . number_format($record->discount_value, 0, ',', '.')),

                TextColumn::make('usage_count')
                    ->label('Digunakan'),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->dateTime(format: 'M d, H:i')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->dateTime(format: 'M d, H:i')
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal Tetap'
                    ]),

                //voucher

                Filter::make('status')
                    ->label('Aktif Saat Ini')
                    ->query(
                        fn(Builder $query): Builder => $query
                            ->where('status', true)
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                    ),
                // Filter::make('expired')
                //     ->label('Sudah Kadaluarsa')
                //     ->query(fn(Builder $query) => $query->where('end_date', '<', now()))
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVouchers::route('/create'),
            'edit' => Pages\EditVouchers::route('/{record}/edit'),
        ];
    }
}
