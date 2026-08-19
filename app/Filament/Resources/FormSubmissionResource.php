<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormSubmissionResource\Pages;
use App\Models\FormSubmission;
use Filament\Forms;
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
    protected static ?string $model = FormSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    TextInput::make('reference_number')->required(),
                    TextInput::make('submitter_name')->required(),
                    TextInput::make('submitter_email')->email(),
                    TextInput::make('submitter_phone'),
                    Select::make('status')->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])->required(),
                ]),
                Textarea::make('data')->label('Data JSON')->rows(10)->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')->searchable()->sortable(),
                TextColumn::make('submitter_name')->searchable()->sortable(),
                TextColumn::make('form.title')->searchable()->sortable()->label('Formulir'),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'new' => 'gray',
                    'processing' => 'warning',
                    'accepted' => 'success',
                    'rejected' => 'danger',
                    'completed' => 'info',
                    default => 'primary',
                })->sortable(),
                TextColumn::make('submitted_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('form_id')->relationship('form', 'title')->label('Formulir'),
                SelectFilter::make('status')->options([
                    'new' => 'New',
                    'processing' => 'Processing',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                    'completed' => 'Completed',
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
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFormSubmissions::route('/'),
        ];
    }
}
