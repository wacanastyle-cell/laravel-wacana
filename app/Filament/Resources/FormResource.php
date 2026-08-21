<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Formulir';

    protected static ?string $modelLabel = 'Formulir';

    protected static ?string $pluralModelLabel = 'Formulir';

    public static function form(Form $form): Form
    {
        return $form->schema([

            /*
            |--------------------------------------------------------------------------
            | INFORMASI FORMULIR
            |--------------------------------------------------------------------------
            */

            Section::make('Informasi Formulir')
                ->description('Buat identitas formulir, pilih kategori, atur thumbnail dan status.')
                ->icon('heroicon-o-document-text')
                ->schema([

                    Grid::make(12)->schema([

                        TextInput::make('title')
                            ->label('Judul Formulir')
                            ->placeholder('Contoh: Pendaftaran Touring Dieng 2026')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn (Forms\Set $set, ?string $state) =>
                                    $set('slug', Str::slug($state ?? ''))
                            )
                            ->columnSpan([
                                'default' => 12,
                                'md' => 8,
                            ]),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'open' => 'Open',
                                'closed' => 'Closed',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required()
                            ->native(false)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                            ]),

                        TextInput::make('slug')
                            ->label('Slug / URL')
                            ->placeholder('otomatis-dari-judul')
                            ->maxLength(255)
                            ->required()
                            ->helperText('Digunakan sebagai alamat formulir publik.')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ]),

                        Select::make('category')
                            ->label('Kategori Formulir')
                            ->placeholder('Pilih kategori')
                            ->options(FormModel::categoryOptions())
                            ->required()
                            ->live()
                            ->native(false)
                            ->helperText('Kategori akan otomatis membuat field peserta.')
                            ->afterStateUpdated(function (
                                ?string $state,
                                Forms\Set $set
                            ): void {

                                if (!$state) {
                                    $set('fields', []);
                                    return;
                                }

                                $set(
                                    'fields',
                                    self::getCategoryFields($state)
                                );

                                $descriptions = [
                                    'touring' =>
                                        'Touring antar kota, touring wisata, touring alam',

                                    'kopdar' =>
                                        'Kopdar rutin, kopdar gabungan, silaturahmi',

                                    'ride_out' =>
                                        'Sunday Ride, Night Ride, Morning Ride',

                                    'jacket_po' =>
                                        'Pemesanan dan pembuatan jaket Wacana Style',
                                ];

                                $set(
                                    'description',
                                    $descriptions[$state] ?? ''
                                );
                            })
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ]),

                        FileUpload::make('thumbnail')
                            ->label('Thumbnail Formulir')
                            ->helperText('Upload JPG, PNG atau WEBP. Disarankan rasio 16:9.')
                            ->image()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(512000)
                            ->disk('public')
                            ->directory('forms/thumbnails')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1280)
                            ->imageResizeTargetHeight(720)
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Deskripsi Formulir')
                            ->placeholder('Deskripsi singkat formulir...')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('confirmation_message')
                            ->label('Pesan Setelah Submit')
                            ->placeholder('Contoh: Terima kasih, data Anda berhasil dikirim.')
                            ->rows(3)
                            ->columnSpanFull(),

                    ]),

                ])
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | JADWAL & NOTIFIKASI
            |--------------------------------------------------------------------------
            */

            Section::make('Jadwal & Notifikasi')
                ->description('Atur periode pendaftaran dan notifikasi formulir.')
                ->icon('heroicon-o-calendar-days')
                ->schema([

                    Grid::make(12)->schema([

                        DateTimePicker::make('starts_at')
                            ->label('Mulai')
                            ->native(false)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ]),

                        DateTimePicker::make('ends_at')
                            ->label('Selesai')
                            ->native(false)
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ]),

                        Checkbox::make('email_notification_enabled')
                            ->label('Kirim email konfirmasi ke user')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ]),

                        Checkbox::make('admin_notification_enabled')
                            ->label('Kirim notifikasi ke admin')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                            ]),

                    ]),

                ])
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            Section::make('Pembayaran')
                ->description('Aktifkan jika formulir membutuhkan pembayaran.')
                ->icon('heroicon-o-credit-card')
                ->schema([

                    Grid::make(12)->schema([

                        Checkbox::make('payment_enabled')
                            ->label('Aktifkan Pembayaran')
                            ->live()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                            ]),

                        TextInput::make('payment_amount')
                            ->label('Nominal Pembayaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->visible(fn (Forms\Get $get): bool =>
                                (bool) $get('payment_enabled')
                            )
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                            ]),

                        Textarea::make('payment_methods')
                            ->label('Metode Pembayaran')
                            ->placeholder("Contoh:\nTransfer Bank\nE-Wallet\nCash")
                            ->rows(3)
                            ->visible(fn (Forms\Get $get): bool =>
                                (bool) $get('payment_enabled')
                            )
                            ->columnSpan([
                                'default' => 12,
                                'md' => 4,
                            ]),

                    ]),

                ])
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | FIELD PESERTA
            |--------------------------------------------------------------------------
            */

            Section::make('Field Peserta Event')
                ->description('Field dibuat otomatis berdasarkan kategori. Anda tetap bebas menambah, menghapus, mengedit dan mengurutkan field.')
                ->icon('heroicon-o-list-bullet')
                ->schema([

                    Repeater::make('fields')
                        ->relationship('fields')
                        ->label('Kolom Peserta')
                        ->defaultItems(0)
                        ->addActionLabel('＋ Tambah Field')
                        ->reorderable()
                        ->collapsible()
                        ->cloneable()
                        ->itemLabel(
                            fn (array $state): string =>
                                $state['label'] ?? 'Field Baru'
                        )
                        ->schema([

                            Grid::make(12)->schema([

                                TextInput::make('label')
                                    ->label('Nama Field')
                                    ->placeholder('Contoh: Nomor WhatsApp')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                    ]),

                                Select::make('type')
                                    ->label('Jenis Jawaban')
                                    ->options([
                                        'text' => 'Teks',
                                        'textarea' => 'Teks Panjang',
                                        'email' => 'Email',
                                        'tel' => 'Nomor Telepon',
                                        'phone' => 'Nomor Telepon',
                                        'number' => 'Angka',
                                        'date' => 'Tanggal',
                                        'time' => 'Waktu',
                                        'select' => 'Pilihan',
                                        'radio' => 'Pilihan Tunggal',
                                        'checkbox' => 'Pilihan Banyak',
                                        'file' => 'Upload File',
                                        'image' => 'Upload Gambar',
                                    ])
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                    ]),

                                TextInput::make('name')
                                    ->label('Nama Sistem')
                                    ->required()
                                    ->helperText('Gunakan nama sederhana, contoh: nomor_whatsapp')
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                    ]),

                                Checkbox::make('is_required')
                                    ->label('Wajib diisi')
                                    ->default(false)
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                    ]),

                                TextInput::make('placeholder')
                                    ->label('Petunjuk / Placeholder')
                                    ->placeholder('Contoh: 08xxxxxxxxxx')
                                    ->columnSpanFull(),

                                Textarea::make('options')
                                    ->label('Pilihan')
                                    ->placeholder("Contoh:\nLaki-laki\nPerempuan")
                                    ->rows(3)
                                    ->visible(
                                        fn (Forms\Get $get): bool =>
                                            in_array(
                                                $get('type'),
                                                ['select', 'radio', 'checkbox']
                                            )
                                    )
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->label('Keterangan Field')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('sort_order')
                                    ->hidden()
                                    ->default(0),

                            ]),

                        ])
                        ->columnSpanFull(),

                ])
                ->collapsible(),

        ]);
    }

    protected static function getCategoryFields(string $category): array
    {
        return FormModel::defaultFields($category);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->square()
                    ->size(55)
                    ->defaultImageUrl(
                        url('/images/default-form-thumbnail.jpg')
                    ),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'touring' =>
                                '🏍️ TOURING',

                            'kopdar' =>
                                '🤝 KOPDAR',

                            'ride_out' =>
                                '🏍️ RIDE OUT',

                            'jacket_po' =>
                                '👕 JAKET / OPEN PO',

                            default =>
                                strtoupper((string) $state),
                        }
                    )
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(
                        fn (string $state): string => match ($state) {
                            'open' => 'success',
                            'draft' => 'gray',
                            'closed' => 'warning',
                            'archived' => 'danger',
                            default => 'primary',
                        }
                    )
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('ends_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

            ])
            ->filters([

                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'open' => 'Open',
                        'closed' => 'Closed',
                        'archived' => 'Archived',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(FormModel::categoryOptions()),

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
            'index' => Pages\ManageForms::route('/'),
        ];
    }
}
