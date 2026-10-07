<?php

namespace App\Filament\Resources;

use App\Enums\AvailabilityStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Produk';

    protected static ?string $navigationGroup = 'Katalog Produk';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->nullable(),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(6)
                            ->nullable(),
                        Forms\Components\TextInput::make('dimensions')
                            ->label('Dimensi')
                            ->maxLength(150)
                            ->nullable(),
                        Forms\Components\TextInput::make('material')
                            ->label('Material')
                            ->default('100% Tanaman Mansiang Alami')
                            ->required(),
                        Forms\Components\RichEditor::make('usage_instructions')
                            ->label('Petunjuk Penggunaan/Perawatan')
                            ->nullable(),
                        Forms\Components\Select::make('availability_status')
                            ->label('Status Ketersediaan')
                            ->options(collect(AvailabilityStatus::cases())->mapWithKeys(fn ($e) => [$e->value => $e->name]))
                            ->required()
                            ->default(AvailabilityStatus::ReadyStock->value)
                            ->live(),
                        Forms\Components\TextInput::make('estimated_production_days')
                            ->label('Estimasi Produksi (hari)')
                            ->integer()
                            ->minValue(1)
                            ->nullable()
                            ->visible(fn (Forms\Get $get) => $get('availability_status') === AvailabilityStatus::PreOrder->value)
                            ->requiredIf('availability_status', AvailabilityStatus::PreOrder->value),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Produk Unggulan')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        Forms\Components\FileUpload::make('primary_image')
                            ->label('Gambar Utama')
                            ->disk('public')
                            ->directory('products')
                            ->image()
                            ->imageEditor()
                            ->required(),
                        Forms\Components\Repeater::make('images')
                            ->label('Galeri')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('Gambar')
                                    ->disk('public')
                                    ->directory('products')
                                    ->image()
                                    ->imageEditor()
                                    ->required(),
                                Forms\Components\TextInput::make('caption')
                                    ->label('Caption')
                                    ->nullable(),
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->integer()
                                    ->default(0),
                            ])
                            ->columns(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primary_image')->label('Gambar'),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori'),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('availability_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        AvailabilityStatus::ReadyStock => 'success',
                        AvailabilityStatus::PreOrder => 'info',
                        AvailabilityStatus::OutOfStock => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_featured')->label('Unggulan')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label('Aktif')
                    ->query(fn ($query) => $query->where('is_active', true)),
                Tables\Filters\SelectFilter::make('availability_status')
                    ->label('Status')
                    ->options(collect(AvailabilityStatus::cases())->mapWithKeys(fn ($e) => [$e->value => $e->name])),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
