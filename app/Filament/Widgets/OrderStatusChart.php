<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\BulkOrder;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Bulk Order Status Distribution';

    protected function getData(): array
    {
        $statusCounts = BulkOrder::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'datasets' => [
                [
                    'label' => 'Bulk Order Status',
                    'data' => $statusCounts->values(),
                    'backgroundColor' => [
                        '#f87171', // red
                        '#facc15', // yellow
                        '#34d399', // green
                        '#60a5fa', // blue
                        '#a78bfa', // purple
                        '#fb923c', // orange
                        '#6b7280', // gray
                    ],
                ],
            ],
            'labels' => $statusCounts->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
