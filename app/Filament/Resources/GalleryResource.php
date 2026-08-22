<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Galeri')
                    ->description('Informasi utama galeri Wacana Style.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([

                            TextInput::make('title')
                                ->label('Nama Galeri')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (
                                    Forms\Set $set,
                                    $state
                                ) {
                                    if (filled($state)) {
                                        $set(
                                            'slug',
                                            Str::slug($state)
                                        );
                                    }
                                })
                                ->columnSpanFull(),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),

                            Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'Touring' => 'Touring',
                                    'Kopdar' => 'Kopdar',
                                    'Event' => 'Event',
                                    'Riding' => 'Riding',
                                    'Camping' => 'Camping',
                                    'Anniversary' => 'Anniversary',
                                    'Kegiatan Tim' => 'Kegiatan Tim',
                                    'Dokumentasi' => 'Dokumentasi',
                                    'Video' => 'Video',
                                    'Lainnya' => 'Lainnya',
                                ])
                                ->searchable()
                                ->native(false),

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

                            Toggle::make('featured')
                                ->label('Featured / Unggulan')
                                ->default(false),

                            FileUpload::make('cover')
                                ->label('Cover / Thumbnail')
                                ->image()
                                ->imageEditor()
                                ->disk('public')
                                ->directory('galleries')
                                ->visibility('public')
                                ->maxSize(10240)
                                ->columnSpanFull(),

                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->rows(5)
                                ->columnSpanFull(),

                        ]),
                    ])
                    ->collapsible(),

                Section::make('Foto Galeri')
                    ->description(
                        'Upload, atur urutan, dan lengkapi informasi setiap foto.'
                    )
                    ->icon('heroicon-o-camera')
                    ->schema([

                        Repeater::make('photos')
                            ->relationship('photos')
                            ->label('Foto')
                            ->schema([

                                FileUpload::make('image')
                                    ->label('Foto')
                                    ->required()
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('gallery-photos')
                                    ->visibility('public')
                                    ->maxSize(10240)
                                    ->columnSpanFull(),

                                TextInput::make('title')
                                    ->label('Judul Foto')
                                    ->maxLength(255),

                                TextInput::make('caption')
                                    ->label('Caption Foto')
                                    ->maxLength(500),

                                TextInput::make('alt_text')
                                    ->label('Alt Text')
                                    ->maxLength(255),

                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),

                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                            ])
                            ->reorderable(true)
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['title']
                                    ?? $state['caption']
                                    ?? 'Foto Baru'
                            )
                            ->columnSpanFull(),

                    ])
                    ->collapsible(),

                Section::make('Informasi Event')
                    ->description('Informasi kegiatan yang didokumentasikan.')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([

                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([

                            TextInput::make('event_name')
                                ->label('Nama Event')
                                ->maxLength(255),

                            DatePicker::make('event_date')
                                ->label('Tanggal Event'),

                            TextInput::make('location')
                                ->label('Lokasi')
                                ->maxLength(255),

                            TextInput::make('city')
                                ->label('Kota / Kabupaten')
                                ->maxLength(255),

                            TextInput::make('organizer')
                                ->label('Penyelenggara')
                                ->maxLength(255),

                            Textarea::make('event_description')
                                ->label('Keterangan Event')
                                ->rows(4)
                                ->columnSpanFull(),

                        ]),

                    ])
                    ->collapsible(),

                Section::make('Video')
                    ->description('Tambahkan video YouTube atau video eksternal.')
                    ->icon('heroicon-o-video-camera')
                    ->schema([

                        Repeater::make('videos')
                            ->relationship('videos')
                            ->label('Daftar Video')
                            ->schema([

                                TextInput::make('youtube_url')
                                    ->label('URL YouTube')
                                    ->url()
                                    ->placeholder(
                                        'https://youtube.com/watch?v=...'
                                    ),

                                TextInput::make('external_url')
                                    ->label('URL Video Eksternal')
                                    ->url(),

                                FileUpload::make('thumbnail')
                                    ->label('Thumbnail Video')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('gallery-videos')
                                    ->visibility('public')
                                    ->maxSize(10240),

                                TextInput::make('title')
                                    ->label('Judul Video')
                                    ->maxLength(255),

                                Textarea::make('description')
                                    ->label('Deskripsi Video')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),

                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                            ])
                            ->reorderable(true)
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['title']
                                    ?? 'Video Baru'
                            )
                            ->columnSpanFull(),

                    ])
                    ->collapsible(),

                Section::make('Tampilan Website')
                    ->description('Kontrol informasi yang ditampilkan pada halaman publik.')
                    ->icon('heroicon-o-eye')
                    ->schema([

                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'lg' => 3,
                        ])->schema([

                            Toggle::make('show_title')
                                ->label('Tampilkan Judul')
                                ->default(true),

                            Toggle::make('show_description')
                                ->label('Tampilkan Deskripsi')
                                ->default(true),

                            Toggle::make('show_date')
                                ->label('Tampilkan Tanggal')
                                ->default(true),

                            Toggle::make('show_location')
                                ->label('Tampilkan Lokasi')
                                ->default(true),

                            Toggle::make('show_category')
                                ->label('Tampilkan Kategori')
                                ->default(true),

                            Toggle::make('show_video')
                                ->label('Tampilkan Video')
                                ->default(true),

                        ]),

                    ])
                    ->collapsible(),

                Section::make('Publikasi')
                    ->description('Atur status dan waktu publikasi galeri.')
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
                                ->label('Publish Date')
                                ->seconds(false),

                            DateTimePicker::make('scheduled_at')
                                ->label('Scheduled Date')
                                ->seconds(false),

                        ]),

                    ])
                    ->collapsible(),

                Section::make('SEO')
                    ->description('Optimasi mesin pencari untuk halaman galeri.')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([

                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255)
                            ->helperText(
                                'Ideal sekitar 50–60 karakter.'
                            ),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(320),

                        FileUpload::make('seo_image')
                            ->label('SEO Image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('gallery-seo')
                            ->visibility('public')
                            ->maxSize(10240),

                        TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->url(),

                    ])
                    ->collapsible()
                    ->collapsed(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('event_date', 'desc')
            ->columns([

                ImageColumn::make('cover')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(64),

                TextColumn::make('title')
                    ->label('Galeri')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('event_name')
                    ->label('Event')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('city')
                    ->label('Lokasi')
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('photos_count')
                    ->counts('photos')
                    ->label('Foto')
                    ->suffix(' foto')
                    ->sortable(),

                TextColumn::make('videos_count')
                    ->counts('videos')
                    ->label('Video')
                    ->suffix(' video')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                    ])
                    ->formatStateUsing(
                        fn (string $state): string =>
                            match ($state) {
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'scheduled' => 'Scheduled',
                                default => ucfirst($state),
                            }
                    ),

                TextColumn::make('featured')
                    ->label('Featured')
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string =>
                            $state ? 'Unggulan' : '-'
                    )
                    ->color(
                        fn (bool $state): string =>
                            $state ? 'warning' : 'gray'
                    )
                    ->toggleable(),

                TextColumn::make('event_date')
                    ->label('Tanggal Event')
                    ->date('d M Y')
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
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

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
                        'Touring' => 'Touring',
                        'Kopdar' => 'Kopdar',
                        'Event' => 'Event',
                        'Riding' => 'Riding',
                        'Camping' => 'Camping',
                        'Anniversary' => 'Anniversary',
                        'Kegiatan Tim' => 'Kegiatan Tim',
                        'Dokumentasi' => 'Dokumentasi',
                        'Video' => 'Video',
                        'Lainnya' => 'Lainnya',
                    ]),

                SelectFilter::make('featured')
                    ->label('Featured')
                    ->options([
                        1 => 'Unggulan',
                        0 => 'Biasa',
                    ]),

                Tables\Filters\Filter::make('year')
                    ->form([
                        Select::make('year')
                            ->label('Tahun Event')
                            ->options(
                                fn () => Gallery::query()
                                    ->whereNotNull('event_date')
                                    ->selectRaw(
                                        'strftime("%Y", event_date) as year'
                                    )
                                    ->distinct()
                                    ->orderByDesc('year')
                                    ->pluck('year', 'year')
                                    ->toArray()
                            ),
                    ])
                    ->query(
                        fn (
                            Builder $query,
                            array $data
                        ) =>
                            $query->when(
                                $data['year'] ?? null,
                                fn (Builder $query, $year) =>
                                    $query->whereRaw(
                                        'strftime("%Y", event_date) = ?',
                                        [$year]
                                    )
                            )
                    ),

                Tables\Filters\TrashedFilter::make(),

            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(
                        fn (Gallery $record) =>
                            route(
                                'public.gallery.detail',
                                ['slug' => $record->slug]
                            )
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('duplicate')
                    ->label('Duplikat')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (Gallery $record) {

                        $copy = $record->replicate();

                        $copy->title =
                            $record->title . ' - Copy';

                        $copy->slug =
                            $record->slug .
                            '-copy-' .
                            time();

                        $copy->status = 'draft';
                        $copy->featured = false;
                        $copy->published_at = null;
                        $copy->scheduled_at = null;

                        $copy->save();

                        foreach ($record->photos as $photo) {
                            $newPhoto = $photo->replicate();
                            $newPhoto->gallery_id = $copy->id;
                            $newPhoto->save();
                        }

                        foreach ($record->videos as $video) {
                            $newVideo = $video->replicate();
                            $newVideo->gallery_id = $copy->id;
                            $newVideo->save();
                        }
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Trash'),

                Tables\Actions\RestoreAction::make(),

                Tables\Actions\ForceDeleteAction::make()
                    ->label('Delete Permanently'),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(
                            fn ($records) =>
                                $records->each(
                                    fn (Gallery $gallery) =>
                                        $gallery->update([
                                            'status' => 'published',
                                            'published_at' =>
                                                $gallery->published_at
                                                ?? now(),
                                        ])
                                )
                        ),

                    Tables\Actions\BulkAction::make('draft')
                        ->label('Jadikan Draft')
                        ->icon('heroicon-o-pencil')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(
                            fn ($records) =>
                                $records->each(
                                    fn (Gallery $gallery) =>
                                        $gallery->update([
                                            'status' => 'draft',
                                        ])
                                )
                        ),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Bulk Delete'),

                    Tables\Actions\RestoreBulkAction::make()
                        ->label('Bulk Restore'),

                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('Delete Permanently'),

                ]),

            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount([
                'photos',
                'videos',
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGalleries::route('/'),
        ];
    }
}
