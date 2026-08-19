<?php

namespace App\Filament\Resources\JacketOrderResource\Pages;

use App\Filament\Resources\JacketOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJacketOrder extends ViewRecord
{
    protected static string $resource = JacketOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
