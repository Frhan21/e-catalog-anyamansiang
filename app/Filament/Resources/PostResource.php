<?php

namespace App\Filament\Resources;

use App\Enums\PostStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Artikel';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Panduan Artikel')
                    ->description('Form ini mengatur artikel pada halaman blog. Simpan sebagai Draft saat belum siap dilihat pengunjung, lalu pilih Published saat siap terbit.')
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->helperText('Alamat artikel di website. Terisi otomatis dari judul; ubah hanya bila diperlukan.')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\Select::make('post_category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->required(),
                                Forms\Components\Select::make('author_id')
                                    ->label('Penulis')
                                    ->relationship('author', 'name')
                                    ->nullable(),
                                Forms\Components\RichEditor::make('content')
                                    ->label('Konten')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Gambar Utama')
                                    ->disk('public')
                                    ->directory('posts')
                                    ->image()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->helperText('Format JPG, PNG, atau WebP. Ukuran maksimal 2 MB.')
                                    ->validationMessages([
                                        'max' => 'Ukuran gambar maksimal 2 MB.',
                                        'mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
                                    ])
                                    ->requiredIf('status', PostStatus::Published->value),
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->helperText('Draft tidak terlihat oleh pengunjung. Published membuat artikel tampil sesuai tanggal publikasi.')
                                    ->options(collect(PostStatus::cases())->mapWithKeys(fn ($e) => [$e->value => $e->name]))
                                    ->required()
                                    ->default(PostStatus::Draft->value)
                                    ->live(),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publikasi')
                                    ->nullable()
                                    ->requiredIf('status', PostStatus::Published->value)
                                    ->visible(fn (Forms\Get $get) => $get('status') === PostStatus::Published->value),
                                Forms\Components\TextInput::make('reading_time_minutes')
                                    ->label('Waktu Baca (menit)')
                                    ->helperText('Perkiraan waktu yang dibutuhkan pengunjung untuk membaca artikel.')
                                    ->integer()
                                    ->default(1),
                            ])->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')->label('Gambar'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori'),
                Tables\Columns\TextColumn::make('author.name')->label('Penulis'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        PostStatus::Published => 'success',
                        PostStatus::Draft => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('published_at')->label('Publikasi')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(collect(PostStatus::cases())->mapWithKeys(fn ($e) => [$e->value => $e->name])),
                Tables\Filters\SelectFilter::make('post_category_id')
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
