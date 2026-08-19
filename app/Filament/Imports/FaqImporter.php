<?php

namespace App\Filament\Imports;

use App\Models\Faq;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class FaqImporter extends Importer
{
    protected static ?string $model = Faq::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('question')
                ->label('Pertanyaan')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']),

            ImportColumn::make('answer')
                ->label('Jawaban')
                ->requiredMapping()
                ->rules(['required', 'string']),

            ImportColumn::make('is_active')
                ->label('Aktif')
                ->boolean()
                ->default(true),

            ImportColumn::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->default(0),
        ];
    }

    public function resolveRecord(): ?Faq
    {
        $question = trim((string) ($this->data['question'] ?? ''));

        if ($question === '') {
            return null;
        }

        return Faq::firstOrNew([
            'question' => $question,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $successful = (int) $import->successful_rows;
        $failed = (int) $import->getFailedRowsCount();

        $body = "Import FAQ selesai. {$successful} baris berhasil diproses.";

        if ($failed > 0) {
            $body .= " {$failed} baris gagal.";
        }

        return $body;
    }
}
