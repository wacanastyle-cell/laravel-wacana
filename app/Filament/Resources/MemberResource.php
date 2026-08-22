<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Komunitas';

    protected static ?string $navigationLabel = 'Members';

    protected static ?string $modelLabel = 'Member';

    protected static ?string $pluralModelLabel = 'Members';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Informasi Member')
                    ->description(
                        'Data utama anggota Wacana Style.'
                    )
                    ->icon('heroicon-o-identification')
                    ->schema([

                        Forms\Components\Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([

                                TextInput::make('member_number')
                                    ->label('Nomor Member')
                                    ->placeholder('WS-20260822-0001')
                                    ->maxLength(255)
                                    ->unique(
                                        table: Member::class,
                                        column: 'member_number',
                                        ignoreRecord: true
                                    )
                                    ->helperText(
                                        'Nomor identitas member Wacana Style.'
                                    ),

                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder(
                                        'Masukkan nama lengkap'
                                    ),

                                TextInput::make('whatsapp')
                                    ->label('Nomor WhatsApp')
                                    ->required()
                                    ->tel()
                                    ->maxLength(255)
                                    ->placeholder(
                                        '08xxxxxxxxxx'
                                    ),

                                TextInput::make('motor_type')
                                    ->label('Jenis / Tipe Motor')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder(
                                        'Contoh: Honda Beat Deluxe'
                                    ),

                                TextInput::make('city')
                                    ->label('Domisili')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder(
                                        'Contoh: Kota Tegal'
                                    ),

                                DatePicker::make('joined_at')
                                    ->label('Tanggal Bergabung')
                                    ->native(false)
                                    ->displayFormat('d M Y')
                                    ->default(now()),

                            ]),
                    ])
                    ->collapsible(),


                Section::make('Status Keanggotaan')
                    ->description(
                        'Atur status verifikasi dan keaktifan member.'
                    )
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        Select::make('status')
                            ->label('Status Member')
                            ->required()
                            ->options([
                                'inactive' => 'Menunggu Verifikasi',
                                'active' => 'Aktif',
                            ])
                            ->default('inactive')
                            ->native(false)
                            ->helperText(
                                'Member dari formulir publik otomatis masuk sebagai Menunggu Verifikasi.'
                            ),

                    ])
                    ->columns(1)
                    ->collapsible(),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('member_number')
                    ->label('No. Member')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage(
                        'Nomor member disalin'
                    )
                    ->placeholder('-'),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(
                        fn (Member $record): string =>
                            $record->city ?: '-'
                    ),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->copyMessage(
                        'Nomor WhatsApp disalin'
                    )
                    ->icon('heroicon-o-phone'),

                TextColumn::make('motor_type')
                    ->label('Motor')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string =>
                            match ($state) {
                                'active' =>
                                    'Aktif',

                                'inactive' =>
                                    'Menunggu Verifikasi',

                                default =>
                                    ucfirst(
                                        $state ?: '-'
                                    ),
                            }
                    )
                    ->color(
                        fn (?string $state): string =>
                            match ($state) {
                                'active' =>
                                    'success',

                                'inactive' =>
                                    'warning',

                                default =>
                                    'gray',
                            }
                    )
                    ->sortable(),

                TextColumn::make('joined_at')
                    ->label('Bergabung')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
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
                        'inactive' =>
                            'Menunggu Verifikasi',

                        'active' =>
                            'Aktif',
                    ]),

                SelectFilter::make('city')
                    ->label('Domisili')
                    ->options(
                        fn (): array =>
                            Member::query()
                                ->whereNotNull('city')
                                ->where('city', '!=', '')
                                ->distinct()
                                ->orderBy('city')
                                ->pluck('city', 'city')
                                ->toArray()
                    )
                    ->searchable(),

            ])

            ->actions([

                Tables\Actions\Action::make('aktifkan')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(
                        'Aktifkan Member'
                    )
                    ->modalDescription(
                        'Member akan diubah menjadi status aktif.'
                    )
                    ->visible(
                        fn (Member $record): bool =>
                            $record->status !== 'active'
                    )
                    ->action(
                        function (Member $record): void {
                            $record->update([
                                'status' => 'active',
                            ]);
                        }
                    ),

                Tables\Actions\Action::make('nonaktifkan')
                    ->label('Nonaktifkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(
                        fn (Member $record): bool =>
                            $record->status === 'active'
                    )
                    ->action(
                        function (Member $record): void {
                            $record->update([
                                'status' => 'inactive',
                            ]);
                        }
                    ),

                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(
                        function (Member $record): string {

                            $number = preg_replace(
                                '/[^0-9]/',
                                '',
                                $record->whatsapp ?? ''
                            );

                            if (
                                str_starts_with(
                                    $number,
                                    '0'
                                )
                            ) {
                                $number =
                                    '62' .
                                    substr(
                                        $number,
                                        1
                                    );
                            }

                            return
                                'https://wa.me/' .
                                $number;
                        }
                    )
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\BulkAction::make(
                        'aktifkan'
                    )
                        ->label(
                            'Aktifkan Member'
                        )
                        ->icon(
                            'heroicon-o-check-circle'
                        )
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(
                            function (
                                Collection $records
                            ): void {
                                foreach (
                                    $records
                                    as $record
                                ) {
                                    $record->update([
                                        'status' =>
                                            'active',
                                    ]);
                                }
                            }
                        )
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make(
                        'nonaktifkan'
                    )
                        ->label(
                            'Nonaktifkan Member'
                        )
                        ->icon(
                            'heroicon-o-x-circle'
                        )
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(
                            function (
                                Collection $records
                            ): void {
                                foreach (
                                    $records
                                    as $record
                                ) {
                                    $record->update([
                                        'status' =>
                                            'inactive',
                                    ]);
                                }
                            }
                        )
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus'),

                ]),

            ])

            ->defaultSort(
                'created_at',
                'desc'
            )

            ->striped()

            ->emptyStateHeading(
                'Belum Ada Member'
            )

            ->emptyStateDescription(
                'Member yang mendaftar melalui website akan muncul di sini.'
            )

            ->emptyStateIcon(
                'heroicon-o-user-group'
            );
    }


    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()
            ->where('status', 'inactive')
            ->count();

        return $count > 0
            ? (string) $count
            : null;
    }


    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }


    public static function getPages(): array
    {
        return [
            'index' =>
                Pages\ManageMembers::route('/'),
        ];
    }
}
