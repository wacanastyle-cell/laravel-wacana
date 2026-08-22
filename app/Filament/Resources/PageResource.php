<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
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

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Halaman')
                    ->description('Informasi utama halaman website.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        TextInput::make('title')
                            ->label('Judul Halaman')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (
                                Forms\Set $set,
                                $state
                            ) {
                                if (filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->columnSpanFull(),

                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([

                            TextInput::make('slug')
                                ->label('Slug / URL')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),

                            Select::make('status')
                                ->label('Status Halaman')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                    'private' => 'Private',
                                    'scheduled' => 'Scheduled',
                                ])
                                ->default('draft')
                                ->required()
                                ->native(false),

                        ]),

                        Textarea::make('excerpt')
                            ->label('Deskripsi Singkat / Excerpt')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('pages')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->columnSpanFull(),

                    ])
                    ->collapsible(),

                Section::make('Konten Halaman')
                    ->description('Isi utama halaman.')
                    ->icon('heroicon-o-code-bracket')
                    ->schema([

                        Textarea::make('content')
                            ->label('Konten Halaman / HTML')
                            ->required()
                            ->rows(35)
                            ->columnSpanFull()
                            ->helperText(
                                'HTML lama tetap dapat digunakan.'
                            )
                            ->extraAttributes([
                                'style' =>
                                    'font-family: monospace; font-size: 13px; line-height: 1.65; min-height: 650px;',
                                'spellcheck' => 'false',
                                'wrap' => 'off',
                            ]),

                    ])
                    ->collapsible(),

                Section::make('Publikasi')
                    ->description('Atur status dan waktu publikasi.')
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
                                    'private' => 'Private',
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

                Section::make('Struktur Halaman')
                    ->description('Template, parent page, dan urutan halaman.')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([

                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([

                            Select::make('template')
                                ->label('Template Halaman')
                                ->options([
                                    'default' => 'Default',
                                    'full-width' => 'Full Width',
                                    'blank' => 'Blank / Canvas',
                                ])
                                ->default('default')
                                ->required()
                                ->native(false),

                            Select::make('parent_id')
                                ->label('Parent Page / Halaman Induk')
                                ->relationship('parent', 'title')
                                ->searchable()
                                ->preload()
                                ->nullable(),

                            TextInput::make('menu_order')
                                ->label('Urutan Halaman / Menu Order')
                                ->numeric()
                                ->default(0),

                            Toggle::make('comments_enabled')
                                ->label('Aktifkan Komentar')
                                ->default(false),

                        ]),

                    ])
                    ->collapsible(),

                Section::make('Pengaturan Tampilan')
                    ->description('Atur elemen yang ditampilkan pada halaman publik.')
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

                            Toggle::make('show_excerpt')
                                ->label('Tampilkan Deskripsi')
                                ->default(true),

                            Toggle::make('show_featured_image')
                                ->label('Tampilkan Featured Image')
                                ->default(true),

                            Toggle::make('show_breadcrumb')
                                ->label('Tampilkan Breadcrumb')
                                ->default(true),

                            Toggle::make('show_header')
                                ->label('Tampilkan Header')
                                ->default(true),

                            Toggle::make('show_footer')
                                ->label('Tampilkan Footer')
                                ->default(true),

                            Toggle::make('show_sidebar')
                                ->label('Tampilkan Sidebar')
                                ->default(false),

                            Toggle::make('show_published_date')
                                ->label('Tampilkan Tanggal Publikasi')
                                ->default(false),

                            Toggle::make('show_author')
                                ->label('Tampilkan Nama Penulis')
                                ->default(false),

                        ]),

                    ])
                    ->collapsible(),

                Section::make('SEO')
                    ->description('Optimasi halaman untuk mesin pencari.')
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

                        Textarea::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->rows(2)
                            ->helperText(
                                'Opsional. Pisahkan keyword dengan koma.'
                            ),

                        TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->url(),

                        Toggle::make('seo_index')
                            ->label('Index di Search Engine')
                            ->helperText(
                                'OFF = noindex, nofollow.'
                            )
                            ->default(true),

                        FileUpload::make('og_image')
                            ->label('Open Graph Image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('pages/og')
                            ->visibility('public')
                            ->maxSize(10240),

                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Advanced')
                    ->description('Pengaturan tambahan halaman.')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->schema([

                        TextInput::make('custom_css_class')
                            ->label('Custom CSS Class')
                            ->placeholder(
                                'contoh: page-formulir clean-page'
                            )
                            ->maxLength(255),

                        KeyValue::make('custom_fields')
                            ->label('Custom Fields')
                            ->keyLabel('Nama Field')
                            ->valueLabel('Nilai')
                            ->addActionLabel('Tambah Field')
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->collapsed(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('menu_order')
            ->columns([

                ImageColumn::make('featured_image')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(54),

                TextColumn::make('title')
                    ->label('Halaman')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(
                        fn (Page $record): string =>
                            Str::limit(
                                $record->excerpt ?: $record->slug,
                                80
                            )
                    )
                    ->wrap(),

                TextColumn::make('template')
                    ->label('Template')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string =>
                            match ($state) {
                                'full-width' => 'Full Width',
                                'blank' => 'Blank / Canvas',
                                default => 'Default',
                            }
                    )
                    ->toggleable(),

                TextColumn::make('parent.title')
                    ->label('Parent')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                        'danger' => 'private',
                    ])
                    ->formatStateUsing(
                        fn (string $state): string =>
                            match ($state) {
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'private' => 'Private',
                                'scheduled' => 'Scheduled',
                                default => ucfirst($state),
                            }
                    ),

                TextColumn::make('menu_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),

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
                        'private' => 'Private',
                        'scheduled' => 'Scheduled',
                    ]),

                SelectFilter::make('template')
                    ->label('Template')
                    ->options([
                        'default' => 'Default',
                        'full-width' => 'Full Width',
                        'blank' => 'Blank / Canvas',
                    ]),

                TrashedFilter::make(),

            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(
                        fn (Page $record) =>
                            route(
                                'public.page',
                                ['slug' => $record->slug]
                            )
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('duplicate')
                    ->label('Duplikat')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (Page $record) {

                        $copy = $record->replicate();

                        $copy->title =
                            $record->title . ' - Copy';

                        $copy->slug =
                            $record->slug .
                            '-copy-' .
                            time();

                        $copy->status = 'draft';

                        $copy->published_at = null;

                        $copy->scheduled_at = null;

                        $copy->save();
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
                                    fn (Page $page) =>
                                        $page->update([
                                            'status' => 'published',
                                            'published_at' =>
                                                $page->published_at
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
                                    fn (Page $page) =>
                                        $page->update([
                                            'status' => 'draft',
                                        ])
                                )
                        ),

                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\RestoreBulkAction::make(),

                    Tables\Actions\ForceDeleteBulkAction::make(),

                ]),

            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePages::route('/'),
        ];
    }
}
