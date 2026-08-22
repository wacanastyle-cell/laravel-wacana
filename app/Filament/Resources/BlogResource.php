<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Artikel')
                    ->description('Informasi utama artikel Wacana Style.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([

                            TextInput::make('title')
                                ->label('Judul Artikel')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Set $set, $state) {
                                    if (filled($state)) {
                                        $set('slug', Str::slug($state));
                                    }
                                })
                                ->columnSpanFull(),

                            TextInput::make('slug')
                                ->label('Slug / URL')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('Otomatis dibuat dari judul.')
                                ->columnSpanFull(),

                            Textarea::make('excerpt')
                                ->label('Excerpt / Ringkasan')
                                ->rows(4)
                                ->maxLength(1000)
                                ->columnSpanFull(),

                            Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'Berita' => 'Berita',
                                    'Event' => 'Event',
                                    'Touring' => 'Touring',
                                    'Komunitas' => 'Komunitas',
                                    'Tips & Info' => 'Tips & Info',
                                    'Pengumuman' => 'Pengumuman',
                                ])
                                ->searchable()
                                ->native(false),

                            TextInput::make('tags')
                                ->label('Tags')
                                ->placeholder('touring, wacana style, motor')
                                ->helperText('Pisahkan dengan koma.')
                                ->maxLength(500),

                            Toggle::make('featured')
                                ->label('Artikel Unggulan')
                                ->helperText('Tampilkan sebagai artikel unggulan.')
                                ->inline(false),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Content Editor')
                    ->description('Editor HTML/source untuk artikel. HTML lama tetap didukung.')
                    ->icon('heroicon-o-code-bracket')
                    ->schema([
                        Textarea::make('content')
                            ->label('HTML / Source Code')
                            ->required()
                            ->rows(35)
                            ->columnSpanFull()
                            ->helperText(
                                'Paste HTML artikel secara langsung. HTML akan disimpan dan dirender pada halaman blog.'
                            )
                            ->extraAttributes([
                                'style' => 'font-family: monospace; font-size: 13px; line-height: 1.65; min-height: 700px;',
                                'spellcheck' => 'false',
                                'wrap' => 'off',
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Media Artikel')
                    ->description('Thumbnail / gambar unggulan artikel.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Featured Image / Thumbnail')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('blog')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Tampilan Website')
                    ->description('Kontrol bagian mana yang ditampilkan pada halaman artikel.')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'lg' => 4,
                        ])->schema([

                            Toggle::make('show_title')
                                ->label('Tampilkan Judul')
                                ->default(true),

                            Toggle::make('show_thumbnail')
                                ->label('Tampilkan Thumbnail')
                                ->default(true),

                            Toggle::make('show_excerpt')
                                ->label('Tampilkan Excerpt')
                                ->default(true),

                            Toggle::make('show_author')
                                ->label('Tampilkan Author')
                                ->default(true),

                            Toggle::make('show_date')
                                ->label('Tampilkan Tanggal')
                                ->default(true),

                            Toggle::make('show_category')
                                ->label('Tampilkan Kategori')
                                ->default(true),

                            Toggle::make('show_tags')
                                ->label('Tampilkan Tags')
                                ->default(true),

                            Toggle::make('show_reading_time')
                                ->label('Tampilkan Reading Time')
                                ->default(true),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Publikasi')
                    ->description('Atur status dan waktu publikasi artikel.')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 3,
                        ])->schema([

                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                    'scheduled' => 'Scheduled',
                                ])
                                ->default('draft')
                                ->required()
                                ->native(false),

                            DateTimePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->seconds(false),

                            DateTimePicker::make('scheduled_at')
                                ->label('Jadwal Publikasi')
                                ->seconds(false),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('SEO')
                    ->description('Optimasi mesin pencari untuk artikel.')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255)
                            ->helperText('Ideal sekitar 50–60 karakter.'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(320),

                        Grid::make(2)->schema([
                            TextInput::make('focus_keyword')
                                ->label('Focus Keyword'),

                            TextInput::make('canonical_url')
                                ->label('Canonical URL')
                                ->url(),
                        ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Social Media')
                    ->description('Informasi Open Graph untuk Facebook, WhatsApp, X, dan platform sosial lainnya.')
                    ->icon('heroicon-o-share')
                    ->schema([
                        TextInput::make('og_title')
                            ->label('OG Title'),

                        Textarea::make('og_description')
                            ->label('OG Description')
                            ->rows(3),

                        FileUpload::make('og_image')
                            ->label('OG Image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('blog/og')
                            ->visibility('public'),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Statistik Artikel')
                    ->description('Dihitung otomatis dari isi artikel.')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Grid::make(4)->schema([

                            TextInput::make('views')
                                ->label('Views')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('reading_time')
                                ->label('Reading Time')
                                ->suffix(' menit')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('word_count')
                                ->label('Word Count')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('character_count')
                                ->label('Character Count')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),
                        ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->columns([

                ImageColumn::make('featured_image')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(64)
                    ->defaultImageUrl(url('/images/placeholder-blog.jpg')),

                TextColumn::make('title')
                    ->label('Artikel')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Blog $record): string =>
                        Str::limit($record->excerpt ?? 'Tidak ada ringkasan.', 90)
                    )
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->label('Penulis')
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                    ])
                    ->formatStateUsing(fn (string $state): string =>
                        match ($state) {
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'scheduled' => 'Scheduled',
                            default => ucfirst($state),
                        }
                    ),

                TextColumn::make('views')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Berita' => 'Berita',
                        'Event' => 'Event',
                        'Touring' => 'Touring',
                        'Komunitas' => 'Komunitas',
                        'Tips & Info' => 'Tips & Info',
                        'Pengumuman' => 'Pengumuman',
                    ]),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Penulis')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('duplicate')
                    ->label('Duplikat')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (Blog $record) {
                        $copy = $record->replicate();

                        $copy->title = $record->title . ' - Copy';
                        $copy->slug = $record->slug . '-copy-' . time();
                        $copy->status = 'draft';
                        $copy->published_at = null;
                        $copy->scheduled_at = null;
                        $copy->views = 0;

                        $copy->save();
                    }),

                Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) =>
                            $records->each(fn (Blog $blog) =>
                                $blog->update([
                                    'status' => 'published',
                                    'published_at' => $blog->published_at ?? now(),
                                ])
                            )
                        ),

                    Tables\Actions\BulkAction::make('draft')
                        ->label('Jadikan Draft')
                        ->icon('heroicon-o-pencil')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($records) =>
                            $records->each(fn (Blog $blog) =>
                                $blog->update([
                                    'status' => 'draft',
                                ])
                            )
                        ),

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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
