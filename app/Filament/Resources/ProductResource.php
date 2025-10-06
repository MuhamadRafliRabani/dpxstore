<?php

namespace App\Filament\Resources;

use App\Domain\Product\Models\Product;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $modelLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Product Name')
                    ->live(debounce: 400, onBlur: true)  // lebih stabil kalau with onBlur
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $slug = Str::slug($state ?? '');
                        $code = Str::upper($state ?? '');

                        $set('slug', $slug);
                        $set('code', $code);
                    })
                    ->required(),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('name')->label('Nama Kategori')->required(),
                        TextInput::make('title')->label('Judul Kategori')->required(),
                        TextInput::make('desc')->label('Deskripsi Kategori')->required(),
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
                    ])
                    ->optionsLimit(50)
                    ->required(),

                Hidden::make('slug')
                    ->default('')
                    ->dehydrated(),

                TextInput::make('code')
                    ->label('Kode Product')
                    ->readOnly()
                    ->required(),

                TextInput::make('publisher')
                    ->label('Publisher')
                    ->placeholder('Publisher Name')
                    ->required(),

                FileUpload::make('image')
                    ->label('Image')
                    ->directory('product')
                    ->disk('public')
                    ->image()
                    ->preserveFilenames()
                    ->imageEditor()
                    ->required(),

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
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('publisher')
                    ->label('Publisher'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => $state == '1' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == '1' ? 'Active' : 'Inactive')
                    ->sortable(),

                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->height(50)
                    ->width(50),

                TextColumn::make('creby')
                    ->label('Created By')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('cretime')
                    ->label('Created Time')
                    ->sortable(),

                TextColumn::make('modby')
                    ->label('Modified By')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('modtime')
                    ->label('Modified Time')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
