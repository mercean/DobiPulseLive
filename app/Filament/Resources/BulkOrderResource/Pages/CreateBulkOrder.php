<?php

namespace App\Filament\Resources\BulkOrderResource\Pages;

use App\Filament\Resources\BulkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBulkOrder extends CreateRecord
{
    protected static string $resource = BulkOrderResource::class;
}
