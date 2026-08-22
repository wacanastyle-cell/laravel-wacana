<?php

namespace App\Filament\Resources\FormSubmissionResource\Pages;

use App\Filament\Resources\FormSubmissionResource;
use App\Filament\Resources\FormSubmissionResource\Widgets\FormSubmissionStats;
use Filament\Resources\Pages\ManageRecords;

class ManageFormSubmissions extends ManageRecords
{
    protected static string $resource =
        FormSubmissionResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            FormSubmissionStats::class,
        ];
    }
}
