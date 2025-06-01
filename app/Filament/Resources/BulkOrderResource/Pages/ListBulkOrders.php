<?php

namespace App\Filament\Resources\BulkOrderResource\Pages;

use App\Filament\Resources\BulkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBulkOrders extends ListRecords
{
    protected static string $resource = BulkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
