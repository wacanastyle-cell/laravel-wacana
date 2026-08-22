<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Pendaftaran';
    protected static ?string $navigationLabel = 'Calon Member';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    TextInput::make('member_number')->required()->maxLength(255),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('slug')->maxLength(255)->nullable()->helperText('Akan otomatis dibuat jika kosong'),
                    Select::make('status')->options(['active' => 'Aktif', 'inactive' => 'Nonaktif'])->default('active')->required(),
                    TextInput::make('motor_type')->maxLength(255),
                    TextInput::make('motor_year')->maxLength(10),
                    TextInput::make('city')->maxLength(255),
                    TextInput::make('whatsapp')->maxLength(255),
                    TextInput::make('instagram')->maxLength(255),
                    DatePicker::make('joined_at')->label('Tanggal Bergabung'),
                    Textarea::make('bio')->rows(5)->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member_number')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('motor_type')->label('Motor')->searchable()->sortable(),
                TextColumn::make('whatsapp')->label('WhatsApp')->searchable(),
                TextColumn::make('city')->searchable()->sortable(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => $state === 'active' ? 'success' : 'warning')->sortable(),
                TextColumn::make('joined_at')->date('d M Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(['active' => 'Aktif', 'inactive' => 'Nonaktif']),
                SelectFilter::make('city')->options(Member::query()->distinct()->pluck('city', 'city')->filter()->toArray()),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')
                    ->label('Kirim Pesan WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (Member $record): string => filled($record->whatsapp)
                        ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->whatsapp)
                        : '#')
                    ->openUrlInNewTab()
                    ->visible(fn (Member $record): bool => filled($record->whatsapp)),
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

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMembers::route('/'),
        ];
    }
}
