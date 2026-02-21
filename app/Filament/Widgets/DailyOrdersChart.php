<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class DailyOrdersChart extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('widgets.daily_orders');
    }

    protected function getData(): array
    {
        $orders = $this->getOrders();

        return [
            'datasets' => [
                [
                    'label' => __('resources.order'),
                    'borderColor' => '#10B981',
                    'data' => $orders->map(fn($order) => $order->count),
                ],
            ],
            'labels' => $orders->map(fn($order) => $order->day_month),
        ];
    }

    protected function getOrders() {

        return Order::select(
                DB::raw("DATE_FORMAT(created_at, '%d/%b') as day_month"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as full_date"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"),
                DB::raw("DATE_FORMAT(created_at, '%d/%b')")
            )
            ->orderBy('full_date', 'asc')
            ->get();
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
