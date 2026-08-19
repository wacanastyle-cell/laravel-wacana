<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    TextInput::make('title')->required()->maxLength(255),
                    TextInput::make('slug')->maxLength(255)->nullable()->helperText('Akan otomatis dibuat jika kosong'),
                    Select::make('status')->options([
                        'draft' => 'Draft',
                        'open' => 'Open',
                        'closed' => 'Closed',
                        'archived' => 'Archived',
                    ])->default('draft')->required(),
                    DateTimePicker::make('starts_at')->label('Mulai'),
                    DateTimePicker::make('ends_at')->label('Selesai'),
                    Checkbox::make('email_notification_enabled')->label('Kirim email konfirmasi ke user'),
                    Checkbox::make('admin_notification_enabled')->label('Kirim notifikasi ke admin'),
                ]),
                Textarea::make('description')->rows(3)->columnSpanFull(),
                Textarea::make('confirmation_message')->label('Pesan setelah submit')->rows(3)->columnSpanFull(),
                Repeater::make('fields')
                    ->relationship('fields')
                    ->label('Field Formulir')
                    ->schema([
                        TextInput::make('label')->required(),
                        TextInput::make('name')->required()->helperText('Gunakan nama pendek, contoh: ukuran_jaket'),
                        Select::make('type')->options([
                            'text' => 'Text',
                            'textarea' => 'Textarea',
                            'email' => 'Email',
                            'phone' => 'Phone',
                            'number' => 'Number',
                            'date' => 'Date',
                            'select' => 'Select',
                            'radio' => 'Radio',
                            'checkbox' => 'Checkbox',
                            'file' => 'File',
                            'image' => 'Image',
                        ])->required(),
                        TextInput::make('placeholder'),
                        Textarea::make('description')->rows(2),
                        Textarea::make('options')->label('Pilihan (JSON atau satu per baris)')->rows(2)->helperText('Contoh: ["S","M","L"] atau S,M,L'),
                        Textarea::make('validation_rules')->label('Validation Rules JSON')->rows(2),
                        Checkbox::make('is_required')->default(false),
                        TextInput::make('sort_order')->numeric()->default(0),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->reorderable(true)
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'open' => 'success',
                    'draft' => 'gray',
                    'closed' => 'warning',
                    'archived' => 'danger',
                    default => 'primary',
                })->sortable(),
                TextColumn::make('starts_at')->dateTime('d M Y')->sortable(),
                TextColumn::make('ends_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'draft' => 'Draft',
                    'open' => 'Open',
                    'closed' => 'Closed',
                    'archived' => 'Archived',
                ]),
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
