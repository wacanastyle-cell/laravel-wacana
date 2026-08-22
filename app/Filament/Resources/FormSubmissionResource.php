<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages;
use App\Models\Form as EventForm;
use App\Models\FormSubmission;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FormSubmissionResource extends Resource
{
    protected static ?string $model =
        FormSubmission::class;

    protected static ?string $navigationIcon =
        'heroicon-o-users';

    protected static ?string $navigationGroup =
        'Formulir';

    protected static ?string $navigationLabel =
        'Pendaftar';

    protected static ?string $modelLabel =
        'Pendaftar';

    protected static ?string $pluralModelLabel =
        'Pendaftar';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute =
        'reference_number';


    public static function getNavigationBadge(): ?string
    {
        $count = FormSubmission::query()
            ->where(
                'registration_status',
                'pending'
            )
            ->count();

        return $count > 0
            ? (string) $count
            : null;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Pendaftar')
                    ->icon('heroicon-o-user')
                    ->schema([

                        TextInput::make(
                            'reference_number'
                        )
                            ->label(
                                'Nomor Referensi'
                            )
                            ->disabled(),

                        Select::make('form_id')
                            ->label('Form / Event')
                            ->relationship(
                                'form',
                                'title'
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make(
                            'submitter_name'
                        )
                            ->label('Nama'),

                        TextInput::make(
                            'submitter_phone'
                        )
                            ->label(
                                'Nomor WhatsApp'
                            ),

                        TextInput::make(
                            'submitter_email'
                        )
                            ->label('Email')
                            ->email(),

                        TextInput::make(
                            'submitted_at'
                        )
                            ->label(
                                'Waktu Submit'
                            )
                            ->disabled(),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make(
                    'Status Pendaftaran'
                )
                    ->icon(
                        'heroicon-o-clipboard-document-check'
                    )
                    ->schema([

                        Select::make(
                            'registration_status'
                        )
                            ->label(
                                'Status Pendaftaran'
                            )
                            ->options(
                                FormSubmission::REGISTRATION_STATUSES
                            )
                            ->required()
                            ->native(false),

                        Textarea::make(
                            'admin_notes'
                        )
                            ->label(
                                'Catatan Admin'
                            )
                            ->rows(3),

                    ]),

                Section::make(
                    'Pembayaran'
                )
                    ->icon(
                        'heroicon-o-credit-card'
                    )
                    ->schema([

                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([

                                Select::make(
                                    'payment_status'
                                )
                                    ->label(
                                        'Status Pembayaran'
                                    )
                                    ->options(
                                        FormSubmission::PAYMENT_STATUSES
                                    )
                                    ->required()
                                    ->native(false),

                                TextInput::make(
                                    'payment_amount'
                                )
                                    ->label(
                                        'Jumlah Pembayaran'
                                    )
                                    ->numeric()
                                    ->prefix('Rp'),

                                TextInput::make(
                                    'payment_method'
                                )
                                    ->label(
                                        'Metode Pembayaran'
                                    ),

                                FileUpload::make(
                                    'payment_proof'
                                )
                                    ->label(
                                        'Bukti Pembayaran'
                                    )
                                    ->disk('public')
                                    ->directory(
                                        'form-payments'
                                    )
                                    ->visibility(
                                        'public'
                                    )
                                    ->image(),

                            ]),

                        Textarea::make(
                            'payment_notes'
                        )
                            ->label(
                                'Catatan Pembayaran'
                            )
                            ->rows(3),

                    ]),

                Section::make(
                    'Jawaban Custom Field'
                )
                    ->description(
                        'Semua jawaban yang dikirim peserta.'
                    )
                    ->icon(
                        'heroicon-o-list-bullet'
                    )
                    ->schema([

                        KeyValue::make('data')
                            ->label(
                                'Data Jawaban'
                            )
                            ->keyLabel('Field')
                            ->valueLabel('Jawaban')
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull(),

                    ])
                    ->collapsible(),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort(
                'submitted_at',
                'desc'
            )

            ->headerActions([

                Tables\Actions\Action::make(
                    'export_csv'
                )
                    ->label('Export CSV')
                    ->icon(
                        'heroicon-o-arrow-down-tray'
                    )
                    ->color('gray')
                    ->url(
                        fn () =>
                            route(
                                'admin.form-submissions.csv'
                            )
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make(
                    'export_excel'
                )
                    ->label('Export Excel')
                    ->icon(
                        'heroicon-o-table-cells'
                    )
                    ->color('success')
                    ->url(
                        fn () =>
                            route(
                                'admin.form-submissions.excel'
                            )
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make(
                    'print_all'
                )
                    ->label('Print')
                    ->icon(
                        'heroicon-o-printer'
                    )
                    ->url(
                        fn () =>
                            route(
                                'admin.form-submissions.print'
                            )
                    )
                    ->openUrlInNewTab(),

            ])

            ->columns([

                TextColumn::make(
                    'reference_number'
                )
                    ->label('Referensi')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make(
                    'submitter_name'
                )
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make(
                    'submitter_phone'
                )
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->placeholder('-'),

                TextColumn::make(
                    'form.title'
                )
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make(
                    'form.category'
                )
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state) =>
                            EventForm::CATEGORIES[
                                $state
                            ]
                            ?? strtoupper(
                                (string) $state
                            )
                    )
                    ->toggleable(),

                TextColumn::make(
                    'registration_status'
                )
                    ->label(
                        'Pendaftaran'
                    )
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state) =>
                            FormSubmission::REGISTRATION_STATUSES[
                                $state
                            ]
                            ?? $state
                    )
                    ->color(
                        fn (string $state) =>
                            match ($state) {
                                'accepted' =>
                                    'success',

                                'pending' =>
                                    'warning',

                                'rejected' =>
                                    'danger',

                                'cancelled' =>
                                    'gray',

                                default =>
                                    'gray',
                            }
                    ),

                TextColumn::make(
                    'payment_status'
                )
                    ->label(
                        'Pembayaran'
                    )
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state) =>
                            FormSubmission::PAYMENT_STATUSES[
                                $state
                            ]
                            ?? $state
                    )
                    ->color(
                        fn (string $state) =>
                            match ($state) {
                                'paid' =>
                                    'success',

                                'verification' =>
                                    'warning',

                                'rejected' =>
                                    'danger',

                                'refunded' =>
                                    'gray',

                                default =>
                                    'gray',
                            }
                    ),

                TextColumn::make(
                    'payment_amount'
                )
                    ->label('Nominal')
                    ->money(
                        'IDR',
                        locale: 'id'
                    )
                    ->placeholder('Rp0')
                    ->toggleable(),

                TextColumn::make(
                    'submitted_at'
                )
                    ->label('Tanggal')
                    ->dateTime(
                        'd M Y H:i'
                    )
                    ->sortable()
                    ->toggleable(),

            ])

            ->filters([

                SelectFilter::make(
                    'form_id'
                )
                    ->label('Event')
                    ->relationship(
                        'form',
                        'title'
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make(
                    'category'
                )
                    ->label('Kategori')
                    ->relationship(
                        'form',
                        'category'
                    )
                    ->options(
                        EventForm::categoryOptions()
                    ),

                SelectFilter::make(
                    'registration_status'
                )
                    ->label(
                        'Status Pendaftaran'
                    )
                    ->options(
                        FormSubmission::REGISTRATION_STATUSES
                    ),

                SelectFilter::make(
                    'payment_status'
                )
                    ->label(
                        'Status Pembayaran'
                    )
                    ->options(
                        FormSubmission::PAYMENT_STATUSES
                    ),

            ])

            ->actions([

                Tables\Actions\EditAction::make()
                    ->label('Detail / Edit'),

                Tables\Actions\Action::make(
                    'accept'
                )
                    ->label('Terima')
                    ->icon(
                        'heroicon-o-check-circle'
                    )
                    ->color('success')
                    ->visible(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record
                                ->registration_status
                            !== 'accepted'
                    )
                    ->requiresConfirmation()
                    ->action(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record->update([
                                'registration_status'
                                    => 'accepted',
                            ])
                    ),

                Tables\Actions\Action::make(
                    'reject_registration'
                )
                    ->label(
                        'Tolak Pendaftaran'
                    )
                    ->icon(
                        'heroicon-o-x-circle'
                    )
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record->update([
                                'registration_status'
                                    => 'rejected',
                            ])
                    ),

                Tables\Actions\Action::make(
                    'verify_payment'
                )
                    ->label(
                        'Verifikasi Bayar'
                    )
                    ->icon(
                        'heroicon-o-banknotes'
                    )
                    ->color('success')
                    ->visible(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record
                                ->payment_status
                            !== 'paid'
                    )
                    ->requiresConfirmation()
                    ->action(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record->update([
                                'payment_status'
                                    => 'paid',

                                'payment_verified_at'
                                    => now(),
                            ])
                    ),

                Tables\Actions\Action::make(
                    'reject_payment'
                )
                    ->label(
                        'Tolak Pembayaran'
                    )
                    ->icon(
                        'heroicon-o-no-symbol'
                    )
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record->update([
                                'payment_status'
                                    => 'rejected',

                                'payment_verified_at'
                                    => null,
                            ])
                    ),

                Tables\Actions\Action::make(
                    'proof'
                )
                    ->label(
                        'Bukti Bayar'
                    )
                    ->icon(
                        'heroicon-o-photo'
                    )
                    ->visible(
                        fn (
                            FormSubmission $record
                        ): bool =>
                            filled(
                                $record
                                    ->paymentProofUrl()
                            )
                    )
                    ->url(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record
                                ->paymentProofUrl()
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make(
                    'whatsapp'
                )
                    ->label('WhatsApp')
                    ->icon(
                        'heroicon-o-chat-bubble-left-right'
                    )
                    ->color('success')
                    ->visible(
                        fn (
                            FormSubmission $record
                        ): bool =>
                            filled(
                                $record->whatsappUrl()
                            )
                    )
                    ->url(
                        fn (
                            FormSubmission $record
                        ) =>
                            $record->whatsappUrl()
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make(
                    'print'
                )
                    ->label('Print')
                    ->icon(
                        'heroicon-o-printer'
                    )
                    ->url(
                        fn (
                            FormSubmission $record
                        ) =>
                            route(
                                'admin.form-submissions.print-one',
                                $record
                            )
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\DeleteAction::make(),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\BulkAction::make(
                        'accept'
                    )
                        ->label(
                            'Terima Pendaftar'
                        )
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(
                            fn ($records) =>
                                $records->each(
                                    fn (
                                        FormSubmission $record
                                    ) =>
                                        $record->update([
                                            'registration_status'
                                                => 'accepted',
                                        ])
                                )
                        ),

                    Tables\Actions\BulkAction::make(
                        'paid'
                    )
                        ->label(
                            'Tandai Lunas'
                        )
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(
                            fn ($records) =>
                                $records->each(
                                    fn (
                                        FormSubmission $record
                                    ) =>
                                        $record->update([
                                            'payment_status'
                                                => 'paid',

                                            'payment_verified_at'
                                                => now(),
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
                Pages\ManageFormSubmissions::route('/'),
        ];
    }
}
