<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon =
        'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Formulir';

    protected static ?string $navigationLabel =
        'Formulir Event';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute =
        'title';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 1 - INFORMASI EVENT
                    |--------------------------------------------------------------------------
                    */

                    Step::make('Informasi Event')
                        ->icon('heroicon-o-calendar-days')
                        ->description(
                            'Informasi utama formulir dan event.'
                        )
                        ->schema([

                            Section::make('Kategori Formulir')
                                ->schema([

                                    Select::make('category')
                                        ->label('Kategori')
                                        ->options(
                                            FormModel::categoryOptions()
                                        )
                                        ->required()
                                        ->live()
                                        ->native(false)
                                        ->afterStateUpdated(
                                            function (
                                                Forms\Set $set,
                                                ?string $state
                                            ) {
                                                if (
                                                    $state ===
                                                    'jacket_po'
                                                ) {
                                                    $set(
                                                        'payment_enabled',
                                                        true
                                                    );

                                                    $set(
                                                        'submit_button_text',
                                                        'Pesan Jaket'
                                                    );
                                                }

                                                if (
                                                    $state ===
                                                    'touring'
                                                ) {
                                                    $set(
                                                        'submit_button_text',
                                                        'Ikut Touring'
                                                    );
                                                }

                                                if (
                                                    $state ===
                                                    'ride_out'
                                                ) {
                                                    $set(
                                                        'submit_button_text',
                                                        'Ikut Ride Out'
                                                    );
                                                }

                                                if (
                                                    $state ===
                                                    'kopdar'
                                                ) {
                                                    $set(
                                                        'submit_button_text',
                                                        'Daftar Sekarang'
                                                    );
                                                }
                                            }),

                                ]),

                            Section::make('Informasi Formulir')
                                ->schema([

                                    TextInput::make('title')
                                        ->label('Judul Formulir')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(
                                            function (
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
                                        ->label('Slug / URL')
                                        ->required()
                                        ->unique(
                                            ignoreRecord: true
                                        )
                                        ->maxLength(255),

                                    Select::make('status')
                                        ->label('Status')
                                        ->options([
                                            'draft' =>
                                                'Draft',

                                            'open' =>
                                                'Aktif',

                                            'closed' =>
                                                'Ditutup',

                                            'archived' =>
                                                'Arsip',
                                        ])
                                        ->default('draft')
                                        ->required()
                                        ->native(false),

                                    Textarea::make('description')
                                        ->label('Deskripsi')
                                        ->rows(5)
                                        ->columnSpanFull(),

                                    FileUpload::make('banner')
                                        ->label(
                                            'Banner / Gambar Event'
                                        )
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory(
                                            'forms/banners'
                                        )
                                        ->visibility('public')
                                        ->maxSize(10240)
                                        ->columnSpanFull(),

                                    FileUpload::make('thumbnail')
                                        ->label(
                                            'Thumbnail Daftar Form'
                                        )
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory(
                                            'forms/thumbnails'
                                        )
                                        ->visibility('public')
                                        ->maxSize(10240)
                                        ->columnSpanFull(),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                            Section::make('Informasi Event')
                                ->schema([

                                    DatePicker::make(
                                        'event_date'
                                    )
                                        ->label(
                                            'Tanggal Event'
                                        )
                                        ->native(false),

                                    TimePicker::make(
                                        'event_time'
                                    )
                                        ->label('Jam Event')
                                        ->seconds(false)
                                        ->native(false),

                                    TextInput::make('location')
                                        ->label(
                                            'Lokasi / Titik Kumpul'
                                        )
                                        ->maxLength(255),

                                    TextInput::make(
                                        'google_maps_url'
                                    )
                                        ->label(
                                            'Link Google Maps'
                                        )
                                        ->url(),

                                    DateTimePicker::make(
                                        'registration_start'
                                    )
                                        ->label(
                                            'Mulai Pendaftaran'
                                        )
                                        ->seconds(false)
                                        ->native(false),

                                    DateTimePicker::make(
                                        'registration_end'
                                    )
                                        ->label(
                                            'Batas Akhir Pendaftaran'
                                        )
                                        ->seconds(false)
                                        ->native(false),

                                    TextInput::make('quota')
                                        ->label(
                                            'Kuota Peserta'
                                        )
                                        ->numeric()
                                        ->minValue(1)
                                        ->helperText(
                                            'Kosongkan jika tidak dibatasi.'
                                        ),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                        ]),


                    /*
                    |--------------------------------------------------------------------------
                    | STEP 2 - FORM BUILDER
                    |--------------------------------------------------------------------------
                    */

                    Step::make('Form Builder')
                        ->icon('heroicon-o-list-bullet')
                        ->description(
                            'Atur semua kolom yang akan diisi peserta.'
                        )
                        ->schema([

                            Section::make(
                                'Template Field Kategori'
                            )
                                ->description(
                                    'Field bawaan dibuat saat kategori dipilih. Field tetap bebas diedit.'
                                )
                                ->schema([

                                    Forms\Components\Actions::make([

                                        Forms\Components\Actions\Action::make(
                                            'loadTemplate'
                                        )
                                            ->label(
                                                'Muat Template Field'
                                            )
                                            ->icon(
                                                'heroicon-o-arrow-path'
                                            )
                                            ->color('gray')
                                            ->requiresConfirmation()
                                            ->action(
                                                function (
                                                    Forms\Get $get,
                                                    Forms\Set $set
                                                ) {
                                                    $category =
                                                        $get(
                                                            'category'
                                                        );

                                                    if (!$category) {
                                                        return;
                                                    }

                                                    $set(
                                                        'fields',
                                                        FormModel::defaultFields(
                                                            $category
                                                        )
                                                    );
                                                }
                                            ),

                                    ]),

                                ]),

                            Repeater::make('fields')
                                ->relationship('fields')
                                ->label('Kolom Formulir')
                                ->defaultItems(0)
                                ->addActionLabel(
                                    'Tambah Field'
                                )
                                ->reorderable()
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->cloneable()
                                ->itemLabel(
                                    fn (array $state): string =>
                                        ($state['label'] ?? 'Field Baru')
                                        .
                                        (
                                            !empty($state['type'])
                                            ? ' — ' .
                                              strtoupper(
                                                  $state['type']
                                              )
                                            : ''
                                        )
                                )
                                ->schema([

                                    Section::make(
                                        'Informasi Field'
                                    )
                                        ->schema([

                                            TextInput::make(
                                                'label'
                                            )
                                                ->label(
                                                    'Label'
                                                )
                                                ->required()
                                                ->live(
                                                    onBlur: true
                                                )
                                                ->afterStateUpdated(
                                                    function (
                                                        Forms\Set $set,
                                                        $state
                                                    ) {
                                                        if (
                                                            filled(
                                                                $state
                                                            )
                                                        ) {
                                                            $set(
                                                                'name',
                                                                Str::snake(
                                                                    $state
                                                                )
                                                            );
                                                        }
                                                    }),

                                            TextInput::make(
                                                'name'
                                            )
                                                ->label(
                                                    'Nama / Key Field'
                                                )
                                                ->required()
                                                ->helperText(
                                                    'Contoh: nomor_whatsapp'
                                                ),

                                            Select::make(
                                                'type'
                                            )
                                                ->label(
                                                    'Jenis Field'
                                                )
                                                ->options([
                                                    'text' =>
                                                        'Text',

                                                    'textarea' =>
                                                        'Textarea',

                                                    'number' =>
                                                        'Nomor',

                                                    'email' =>
                                                        'Email',

                                                    'tel' =>
                                                        'Nomor WhatsApp',

                                                    'phone' =>
                                                        'Nomor Telepon',

                                                    'date' =>
                                                        'Tanggal',

                                                    'time' =>
                                                        'Jam',

                                                    'select' =>
                                                        'Dropdown',

                                                    'radio' =>
                                                        'Radio Button',

                                                    'checkbox' =>
                                                        'Checkbox',

                                                    'toggle' =>
                                                        'Toggle',

                                                    'image' =>
                                                        'Upload Gambar',

                                                    'file' =>
                                                        'Upload File',

                                                    'url' =>
                                                        'URL',

                                                    'heading' =>
                                                        'Heading / Judul Bagian',

                                                    'info' =>
                                                        'Teks Informasi',
                                                ])
                                                ->required()
                                                ->live()
                                                ->native(false),

                                            Toggle::make(
                                                'is_required'
                                            )
                                                ->label(
                                                    'Wajib Diisi'
                                                )
                                                ->default(false),

                                        ])
                                        ->columns([
                                            'default' => 1,
                                            'md' => 2,
                                        ]),

                                    Section::make(
                                        'Tampilan & Petunjuk'
                                    )
                                        ->schema([

                                            TextInput::make(
                                                'placeholder'
                                            )
                                                ->label(
                                                    'Placeholder'
                                                )
                                                ->placeholder(
                                                    'Contoh: 08xxxxxxxxxx'
                                                ),

                                            Textarea::make(
                                                'description'
                                            )
                                                ->label(
                                                    'Deskripsi / Petunjuk'
                                                )
                                                ->rows(2),

                                            TextInput::make(
                                                'default_value'
                                            )
                                                ->label(
                                                    'Nilai Default'
                                                ),

                                            Select::make(
                                                'width'
                                            )
                                                ->label(
                                                    'Lebar Field'
                                                )
                                                ->options([
                                                    'full' =>
                                                        '100% / Penuh',

                                                    'half' =>
                                                        '50% / Setengah',

                                                    'third' =>
                                                        '33% / Sepertiga',
                                                ])
                                                ->default(
                                                    'full'
                                                )
                                                ->native(false),

                                            TextInput::make(
                                                'group'
                                            )
                                                ->label(
                                                    'Group / Bagian'
                                                )
                                                ->placeholder(
                                                    'Contoh: Data Peserta'
                                                ),

                                            Toggle::make(
                                                'is_full_width'
                                            )
                                                ->label(
                                                    'Full Width'
                                                )
                                                ->default(false),

                                        ])
                                        ->columns([
                                            'default' => 1,
                                            'md' => 2,
                                        ]),

                                    Section::make(
                                        'Pilihan Jawaban'
                                    )
                                        ->visible(
                                            fn (
                                                Forms\Get $get
                                            ): bool =>
                                                in_array(
                                                    $get('type'),
                                                    [
                                                        'select',
                                                        'radio',
                                                        'checkbox',
                                                    ],
                                                    true
                                                )
                                        )
                                        ->schema([

                                            TagsInput::make(
                                                'options'
                                            )
                                                ->label(
                                                    'Pilihan'
                                                )
                                                ->placeholder(
                                                    'Tambah pilihan'
                                                )
                                                ->helperText(
                                                    'Tekan Enter setelah setiap pilihan.'
                                                )
                                                ->columnSpanFull(),

                                        ]),

                                    Section::make(
                                        'Validasi'
                                    )
                                        ->schema([

                                            TextInput::make(
                                                'min_length'
                                            )
                                                ->label(
                                                    'Minimum Karakter'
                                                )
                                                ->numeric(),

                                            TextInput::make(
                                                'max_length'
                                            )
                                                ->label(
                                                    'Maksimum Karakter'
                                                )
                                                ->numeric(),

                                            TextInput::make(
                                                'min_value'
                                            )
                                                ->label(
                                                    'Minimum Angka'
                                                )
                                                ->numeric(),

                                            TextInput::make(
                                                'max_value'
                                            )
                                                ->label(
                                                    'Maksimum Angka'
                                                )
                                                ->numeric(),

                                            Select::make(
                                                'validation_format'
                                            )
                                                ->label(
                                                    'Format Validasi'
                                                )
                                                ->options([
                                                    'none' =>
                                                        'Tidak Ada',

                                                    'phone' =>
                                                        'Nomor Telepon',

                                                    'email' =>
                                                        'Email',

                                                    'url' =>
                                                        'URL',

                                                    'numeric' =>
                                                        'Angka',

                                                    'alpha' =>
                                                        'Huruf',

                                                    'alpha_num' =>
                                                        'Huruf + Angka',
                                                ])
                                                ->native(false),

                                        ])
                                        ->columns([
                                            'default' => 1,
                                            'md' => 2,
                                        ])
                                        ->collapsible()
                                        ->collapsed(),

                                    Section::make(
                                        'Conditional Field'
                                    )
                                        ->schema([

                                            Toggle::make(
                                                'conditional_enabled'
                                            )
                                                ->label(
                                                    'Aktifkan Kondisi'
                                                )
                                                ->live()
                                                ->default(false),

                                            TextInput::make(
                                                'conditional_field'
                                            )
                                                ->label(
                                                    'Key Field Pemicu'
                                                )
                                                ->placeholder(
                                                    'contoh: membawa_boncengan'
                                                )
                                                ->visible(
                                                    fn (
                                                        Forms\Get $get
                                                    ): bool =>
                                                        (bool)
                                                        $get(
                                                            'conditional_enabled'
                                                        )
                                                ),

                                            Select::make(
                                                'conditional_operator'
                                            )
                                                ->label(
                                                    'Operator'
                                                )
                                                ->options([
                                                    'equals' =>
                                                        'Sama Dengan',

                                                    'not_equals' =>
                                                        'Tidak Sama Dengan',

                                                    'contains' =>
                                                        'Mengandung',

                                                    'not_empty' =>
                                                        'Tidak Kosong',

                                                    'empty' =>
                                                        'Kosong',
                                                ])
                                                ->default(
                                                    'equals'
                                                )
                                                ->native(false)
                                                ->visible(
                                                    fn (
                                                        Forms\Get $get
                                                    ): bool =>
                                                        (bool)
                                                        $get(
                                                            'conditional_enabled'
                                                        )
                                                ),

                                            TextInput::make(
                                                'conditional_value'
                                            )
                                                ->label(
                                                    'Nilai Pemicu'
                                                )
                                                ->placeholder(
                                                    'contoh: Ya'
                                                )
                                                ->visible(
                                                    fn (
                                                        Forms\Get $get
                                                    ): bool =>
                                                        (bool)
                                                        $get(
                                                            'conditional_enabled'
                                                        ) &&
                                                        !in_array(
                                                            $get(
                                                                'conditional_operator'
                                                            ),
                                                            [
                                                                'empty',
                                                                'not_empty',
                                                            ],
                                                            true
                                                        )
                                                ),

                                        ])
                                        ->columns([
                                            'default' => 1,
                                            'md' => 2,
                                        ])
                                        ->collapsible()
                                        ->collapsed(),

                                    Section::make(
                                        'Harga & Urutan'
                                    )
                                        ->schema([

                                            Toggle::make(
                                                'is_price_field'
                                            )
                                                ->label(
                                                    'Field Mempengaruhi Harga'
                                                )
                                                ->default(false),

                                            TextInput::make(
                                                'sort_order'
                                            )
                                                ->label(
                                                    'Urutan'
                                                )
                                                ->numeric()
                                                ->default(0),

                                        ])
                                        ->columns(2)
                                        ->collapsible()
                                        ->collapsed(),

                                ])
                                ->columnSpanFull(),

                        ]),


                    /*
                    |--------------------------------------------------------------------------
                    | STEP 3 - PEMBAYARAN
                    |--------------------------------------------------------------------------
                    */

                    Step::make('Pembayaran')
                        ->icon('heroicon-o-credit-card')
                        ->description(
                            'Gratis, berbayar, rekening dan variasi harga.'
                        )
                        ->schema([

                            Section::make(
                                'Mode Pembayaran'
                            )
                                ->schema([

                                    Toggle::make(
                                        'payment_enabled'
                                    )
                                        ->label(
                                            'Form Berbayar'
                                        )
                                        ->helperText(
                                            'Open PO otomatis selalu berbayar.'
                                        )
                                        ->live()
                                        ->disabled(
                                            fn (
                                                Forms\Get $get
                                            ): bool =>
                                                $get('category') ===
                                                'jacket_po'
                                        )
                                        ->dehydrated()
                                        ->afterStateHydrated(
                                            function (
                                                Toggle $component,
                                                Forms\Get $get
                                            ) {
                                                if (
                                                    $get(
                                                        'category'
                                                    ) ===
                                                    'jacket_po'
                                                ) {
                                                    $component->state(
                                                        true
                                                    );
                                                }
                                            }),

                                ]),

                            Section::make('Harga')
                                ->visible(
                                    fn (
                                        Forms\Get $get
                                    ): bool =>
                                        (bool)
                                        $get(
                                            'payment_enabled'
                                        ) ||
                                        $get('category') ===
                                        'jacket_po'
                                )
                                ->schema([

                                    TextInput::make(
                                        'payment_amount'
                                    )
                                        ->label(
                                            'Harga'
                                        )
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->minValue(0),

                                    TextInput::make(
                                        'promo_price'
                                    )
                                        ->label(
                                            'Harga Promo'
                                        )
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->minValue(0),

                                    DateTimePicker::make(
                                        'payment_deadline'
                                    )
                                        ->label(
                                            'Batas Pembayaran'
                                        )
                                        ->seconds(false)
                                        ->native(false),

                                    Toggle::make(
                                        'payment_proof_required'
                                    )
                                        ->label(
                                            'Wajib Upload Bukti Pembayaran'
                                        )
                                        ->default(false),

                                    Textarea::make(
                                        'payment_instructions'
                                    )
                                        ->label(
                                            'Instruksi Pembayaran'
                                        )
                                        ->rows(4)
                                        ->columnSpanFull(),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                            Section::make(
                                'Transfer Bank'
                            )
                                ->visible(
                                    fn (
                                        Forms\Get $get
                                    ): bool =>
                                        (bool)
                                        $get(
                                            'payment_enabled'
                                        ) ||
                                        $get('category') ===
                                        'jacket_po'
                                )
                                ->schema([

                                    TextInput::make(
                                        'bank_name'
                                    )
                                        ->label('Bank'),

                                    TextInput::make(
                                        'bank_account_number'
                                    )
                                        ->label(
                                            'Nomor Rekening'
                                        ),

                                    TextInput::make(
                                        'bank_account_name'
                                    )
                                        ->label(
                                            'Atas Nama'
                                        ),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 3,
                                ]),

                            Section::make(
                                'E-Wallet & QRIS'
                            )
                                ->visible(
                                    fn (
                                        Forms\Get $get
                                    ): bool =>
                                        (bool)
                                        $get(
                                            'payment_enabled'
                                        ) ||
                                        $get('category') ===
                                        'jacket_po'
                                )
                                ->schema([

                                    TextInput::make(
                                        'ewallet_name'
                                    )
                                        ->label(
                                            'E-Wallet'
                                        )
                                        ->placeholder(
                                            'DANA / OVO / GoPay'
                                        ),

                                    TextInput::make(
                                        'ewallet_number'
                                    )
                                        ->label(
                                            'Nomor E-Wallet'
                                        ),

                                    FileUpload::make(
                                        'qris_image'
                                    )
                                        ->label(
                                            'Upload QRIS'
                                        )
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory(
                                            'forms/qris'
                                        )
                                        ->visibility(
                                            'public'
                                        )
                                        ->maxSize(
                                            10240
                                        )
                                        ->columnSpanFull(),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                            Section::make(
                                'Variasi Harga'
                            )
                                ->visible(
                                    fn (
                                        Forms\Get $get
                                    ): bool =>
                                        (bool)
                                        $get(
                                            'payment_enabled'
                                        ) ||
                                        $get('category') ===
                                        'jacket_po'
                                )
                                ->description(
                                    'Contoh Member/Non Member atau ukuran jaket.'
                                )
                                ->schema([

                                    Repeater::make(
                                        'price_variations'
                                    )
                                        ->label(
                                            'Daftar Variasi'
                                        )
                                        ->addActionLabel(
                                            'Tambah Variasi Harga'
                                        )
                                        ->reorderable()
                                        ->collapsible()
                                        ->cloneable()
                                        ->itemLabel(
                                            fn (
                                                array $state
                                            ): string =>
                                                ($state['label']
                                                    ?? 'Variasi')
                                                .
                                                (
                                                    isset(
                                                        $state[
                                                            'price'
                                                        ]
                                                    )
                                                    ? ' — Rp' .
                                                      number_format(
                                                          (float)
                                                          $state[
                                                              'price'
                                                          ],
                                                          0,
                                                          ',',
                                                          '.'
                                                      )
                                                    : ''
                                                )
                                        )
                                        ->schema([

                                            TextInput::make(
                                                'label'
                                            )
                                                ->label(
                                                    'Nama Variasi'
                                                )
                                                ->placeholder(
                                                    'XL / Member'
                                                )
                                                ->required(),

                                            TextInput::make(
                                                'value'
                                            )
                                                ->label(
                                                    'Value'
                                                )
                                                ->placeholder(
                                                    'xl / member'
                                                )
                                                ->required(),

                                            TextInput::make(
                                                'price'
                                            )
                                                ->label(
                                                    'Harga'
                                                )
                                                ->numeric()
                                                ->prefix('Rp')
                                                ->required()
                                                ->minValue(0),

                                        ])
                                        ->columns([
                                            'default' => 1,
                                            'md' => 3,
                                        ])
                                        ->columnSpanFull(),

                                ]),

                        ]),


                    /*
                    |--------------------------------------------------------------------------
                    | STEP 4 - TAMPILAN
                    |--------------------------------------------------------------------------
                    */

                    Step::make('Tampilan')
                        ->icon('heroicon-o-eye')
                        ->description(
                            'Atur elemen halaman formulir.'
                        )
                        ->schema([

                            Section::make(
                                'Pengaturan Tampilan'
                            )
                                ->schema([

                                    Toggle::make(
                                        'show_title'
                                    )
                                        ->label(
                                            'Tampilkan Judul'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_description'
                                    )
                                        ->label(
                                            'Tampilkan Deskripsi'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_banner'
                                    )
                                        ->label(
                                            'Tampilkan Banner'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_date'
                                    )
                                        ->label(
                                            'Tampilkan Tanggal'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_time'
                                    )
                                        ->label(
                                            'Tampilkan Jam'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_location'
                                    )
                                        ->label(
                                            'Tampilkan Lokasi'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_price'
                                    )
                                        ->label(
                                            'Tampilkan Harga'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_quota'
                                    )
                                        ->label(
                                            'Tampilkan Kuota'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_remaining_quota'
                                    )
                                        ->label(
                                            'Tampilkan Sisa Kuota'
                                        )
                                        ->default(true),

                                    Toggle::make(
                                        'show_registration_count'
                                    )
                                        ->label(
                                            'Tampilkan Jumlah Pendaftar'
                                        )
                                        ->default(false),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'sm' => 2,
                                    'lg' => 3,
                                ]),

                            Section::make(
                                'Tombol Submit'
                            )
                                ->schema([

                                    TextInput::make(
                                        'submit_button_text'
                                    )
                                        ->label(
                                            'Teks Tombol'
                                        )
                                        ->default(
                                            'Kirim Formulir'
                                        )
                                        ->maxLength(100),

                                ]),

                        ]),


                    /*
                    |--------------------------------------------------------------------------
                    | STEP 5 - PREVIEW & PUBLISH
                    |--------------------------------------------------------------------------
                    */

                    Step::make(
                        'Preview & Publish'
                    )
                        ->icon(
                            'heroicon-o-check-circle'
                        )
                        ->description(
                            'Pesan setelah submit dan publikasi.'
                        )
                        ->schema([

                            Section::make(
                                'Pesan Setelah Submit'
                            )
                                ->schema([

                                    TextInput::make(
                                        'success_title'
                                    )
                                        ->label(
                                            'Judul Pesan Berhasil'
                                        )
                                        ->placeholder(
                                            'Pendaftaran Berhasil'
                                        ),

                                    Textarea::make(
                                        'success_message'
                                    )
                                        ->label(
                                            'Isi Pesan Berhasil'
                                        )
                                        ->rows(4),

                                    Textarea::make(
                                        'confirmation_message'
                                    )
                                        ->label(
                                            'Pesan Konfirmasi Lama'
                                        )
                                        ->helperText(
                                            'Dipertahankan untuk kompatibilitas sistem lama.'
                                        )
                                        ->rows(3),

                                    Textarea::make(
                                        'next_instructions'
                                    )
                                        ->label(
                                            'Instruksi Berikutnya'
                                        )
                                        ->rows(4),

                                    Toggle::make(
                                        'show_payment_after_submit'
                                    )
                                        ->label(
                                            'Tampilkan Informasi Pembayaran'
                                        )
                                        ->default(false),

                                    TextInput::make(
                                        'redirect_url'
                                    )
                                        ->label(
                                            'Redirect Setelah Submit'
                                        )
                                        ->url(),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                            Section::make(
                                'WhatsApp Setelah Submit'
                            )
                                ->schema([

                                    Toggle::make(
                                        'open_whatsapp_after_submit'
                                    )
                                        ->label(
                                            'Buka WhatsApp Setelah Submit'
                                        )
                                        ->live()
                                        ->default(false),

                                    TextInput::make(
                                        'whatsapp_number'
                                    )
                                        ->label(
                                            'Nomor WhatsApp'
                                        )
                                        ->placeholder(
                                            '628xxxxxxxxxx'
                                        )
                                        ->visible(
                                            fn (
                                                Forms\Get $get
                                            ): bool =>
                                                (bool)
                                                $get(
                                                    'open_whatsapp_after_submit'
                                                )
                                        ),

                                    Textarea::make(
                                        'whatsapp_message'
                                    )
                                        ->label(
                                            'Template Pesan WhatsApp'
                                        )
                                        ->rows(3)
                                        ->visible(
                                            fn (
                                                Forms\Get $get
                                            ): bool =>
                                                (bool)
                                                $get(
                                                    'open_whatsapp_after_submit'
                                                )
                                        ),

                                ]),

                            Section::make(
                                'Notifikasi'
                            )
                                ->schema([

                                    Toggle::make(
                                        'email_notification_enabled'
                                    )
                                        ->label(
                                            'Email Konfirmasi User'
                                        ),

                                    Toggle::make(
                                        'admin_notification_enabled'
                                    )
                                        ->label(
                                            'Notifikasi Admin'
                                        ),

                                ])
                                ->columns(2),

                            Section::make(
                                'Publikasi'
                            )
                                ->schema([

                                    Select::make('status')
                                        ->label(
                                            'Status Formulir'
                                        )
                                        ->options([
                                            'draft' =>
                                                'Simpan Draft',

                                            'open' =>
                                                'Publish / Aktif',

                                            'closed' =>
                                                'Ditutup',

                                            'archived' =>
                                                'Arsip',
                                        ])
                                        ->required()
                                        ->native(false),

                                    DateTimePicker::make(
                                        'published_at'
                                    )
                                        ->label(
                                            'Tanggal Publish'
                                        )
                                        ->seconds(false)
                                        ->native(false),

                                    DateTimePicker::make(
                                        'starts_at'
                                    )
                                        ->label(
                                            'Mulai Tayang'
                                        )
                                        ->seconds(false)
                                        ->native(false),

                                    DateTimePicker::make(
                                        'ends_at'
                                    )
                                        ->label(
                                            'Selesai Tayang'
                                        )
                                        ->seconds(false)
                                        ->native(false),

                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                        ]),

                ])
                    ->columnSpanFull()
                    ->persistStepInQueryString(),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort(
                'created_at',
                'desc'
            )
            ->columns([

                ImageColumn::make('thumbnail')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(58)
                    ->defaultImageUrl(
                        url(
                            '/images/default-form-thumbnail.jpg'
                        )
                    ),

                TextColumn::make('title')
                    ->label('Formulir')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(
                        fn (
                            FormModel $record
                        ): string =>
                            Str::limit(
                                $record->description
                                    ?: $record->slug,
                                80
                            )
                    )
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(
                        fn (
                            ?string $state
                        ): string =>
                            FormModel::CATEGORIES[
                                $state
                            ]
                            ??
                            strtoupper(
                                (string) $state
                            )
                    )
                    ->sortable(),

                TextColumn::make('payment_enabled')
                    ->label('Biaya')
                    ->badge()
                    ->formatStateUsing(
                        fn (
                            bool $state
                        ): string =>
                            $state
                                ? 'Berbayar'
                                : 'Gratis'
                    )
                    ->color(
                        fn (
                            bool $state
                        ): string =>
                            $state
                                ? 'warning'
                                : 'success'
                    ),

                TextColumn::make(
                    'submissions_count'
                )
                    ->counts('submissions')
                    ->label('Pendaftar')
                    ->suffix(' orang'),

                TextColumn::make('quota')
                    ->label('Kuota')
                    ->placeholder(
                        'Tidak dibatasi'
                    ),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (
                            string $state
                        ): string =>
                            match ($state) {
                                'open' =>
                                    'Aktif',

                                'draft' =>
                                    'Draft',

                                'closed' =>
                                    'Ditutup',

                                'archived' =>
                                    'Arsip',

                                default =>
                                    ucfirst($state),
                            }
                    )
                    ->color(
                        fn (
                            string $state
                        ): string =>
                            match ($state) {
                                'open' =>
                                    'success',

                                'draft' =>
                                    'gray',

                                'closed' =>
                                    'warning',

                                'archived' =>
                                    'danger',

                                default =>
                                    'primary',
                            }
                    ),

                TextColumn::make(
                    'registration_end'
                )
                    ->label(
                        'Batas Pendaftaran'
                    )
                    ->dateTime(
                        'd M Y H:i'
                    )
                    ->placeholder('-')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' =>
                            'Draft',

                        'open' =>
                            'Aktif',

                        'closed' =>
                            'Ditutup',

                        'archived' =>
                            'Arsip',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(
                        FormModel::categoryOptions()
                    ),

                SelectFilter::make(
                    'payment_enabled'
                )
                    ->label('Pembayaran')
                    ->options([
                        0 => 'Gratis',
                        1 => 'Berbayar',
                    ]),

            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make(
                    'preview'
                )
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(
                        fn (
                            FormModel $record
                        ) =>
                            route(
                                'public.form.show',
                                $record->slug
                            )
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make(
                    'duplicate'
                )
                    ->label('Duplikat')
                    ->icon(
                        'heroicon-o-document-duplicate'
                    )
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(
                        function (
                            FormModel $record
                        ) {

                            $copy =
                                $record->replicate();

                            $copy->title =
                                $record->title .
                                ' - Copy';

                            $copy->slug =
                                $record->slug .
                                '-copy-' .
                                time();

                            $copy->status =
                                'draft';

                            $copy->published_at =
                                null;

                            $copy->save();


                            foreach (
                                $record->fields
                                as $field
                            ) {

                                $fieldCopy =
                                    $field->replicate();

                                $fieldCopy->form_id =
                                    $copy->id;

                                $fieldCopy->save();
                            }
                        }
                    ),

                Tables\Actions\DeleteAction::make(),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\BulkAction::make(
                        'publish'
                    )
                        ->label('Publish')
                        ->icon(
                            'heroicon-o-check-circle'
                        )
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(
                            fn ($records) =>
                                $records->each(
                                    fn (
                                        FormModel $form
                                    ) =>
                                        $form->update([
                                            'status' =>
                                                'open',

                                            'published_at' =>
                                                $form
                                                    ->published_at
                                                ?? now(),
                                        ])
                                )
                        ),

                    Tables\Actions\BulkAction::make(
                        'draft'
                    )
                        ->label(
                            'Jadikan Draft'
                        )
                        ->icon(
                            'heroicon-o-pencil'
                        )
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(
                            fn ($records) =>
                                $records->each(
                                    fn (
                                        FormModel $form
                                    ) =>
                                        $form->update([
                                            'status' =>
                                                'draft',
                                        ])
                                )
                        ),

                    Tables\Actions\DeleteBulkAction::make(),

                ]),

            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' =>
                Pages\ManageForms::route('/'),
        ];
    }
}
