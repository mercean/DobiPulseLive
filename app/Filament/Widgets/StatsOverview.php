<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Order;
use App\Models\BulkOrder;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('🧍 Total Users', User::count())
                ->description('Registered users')
                ->color('primary'),

            Stat::make('📦 Bulk Orders', BulkOrder::count())
                ->description('Total bulk orders')
                ->color('success'),

            Stat::make('🧺 Normal Orders', Order::count())
                ->description('Total regular orders')
                ->color('warning'),
        ];
    }
}
