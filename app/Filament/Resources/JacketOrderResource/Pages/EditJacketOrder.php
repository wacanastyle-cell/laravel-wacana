<?php

namespace App\Filament\Resources\JacketOrderResource\Pages;

use App\Filament\Resources\JacketOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJacketOrder extends EditRecord
{
    protected static string $resource = JacketOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
