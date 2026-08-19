<?php

namespace App\Filament\Resources\FaqResource\Pages;

use App\Filament\Imports\FaqImporter;
use App\Filament\Resources\FaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFaqs extends ManageRecords
{
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(FaqImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
