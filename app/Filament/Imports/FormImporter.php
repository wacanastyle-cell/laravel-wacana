<?php

namespace App\Filament\Imports;

use App\Models\Form;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class FormImporter extends Importer
{
    protected static ?string $model = Form::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),

            ImportColumn::make('slug')
                ->rules(['nullable', 'string', 'max:255']),

            ImportColumn::make('description')
                ->rules(['nullable', 'string']),

            ImportColumn::make('status')
                ->rules(['nullable', 'in:draft,open,closed,archived']),

            ImportColumn::make('starts_at')
                ->rules(['nullable', 'date']),

            ImportColumn::make('ends_at')
                ->rules(['nullable', 'date']),

            ImportColumn::make('confirmation_message')
                ->rules(['nullable', 'string']),

            ImportColumn::make('email_notification_enabled')
                ->boolean()
                ->rules(['nullable', 'boolean']),

            ImportColumn::make('admin_notification_enabled')
                ->boolean()
                ->rules(['nullable', 'boolean']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import formulir selesai. '
            . number_format($import->successful_rows)
            . ' '
            . str('formulir')->plural($import->successful_rows)
            . ' berhasil diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '
                . number_format($failedRowsCount)
                . ' '
                . str('baris')->plural($failedRowsCount)
                . ' gagal diimport.';
        }

        return $body;
    }
}
