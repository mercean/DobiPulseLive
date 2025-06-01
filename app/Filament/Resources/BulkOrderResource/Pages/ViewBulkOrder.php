<?php

namespace App\Filament\Resources\BulkOrderResource\Pages;

use App\Filament\Resources\BulkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBulkOrder extends ViewRecord
{
    protected static string $resource = BulkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
