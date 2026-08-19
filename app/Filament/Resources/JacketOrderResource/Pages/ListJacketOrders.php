<?php

namespace App\Filament\Resources\JacketOrderResource\Pages;

use App\Filament\Resources\JacketOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListJacketOrders extends ListRecords
{
    protected static string $resource = JacketOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
