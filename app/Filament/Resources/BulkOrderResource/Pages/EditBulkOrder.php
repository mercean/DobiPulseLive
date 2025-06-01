<?php

namespace App\Filament\Resources\BulkOrderResource\Pages;

use App\Filament\Resources\BulkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBulkOrder extends EditRecord
{
    protected static string $resource = BulkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
