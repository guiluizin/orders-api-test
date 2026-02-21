<?php

namespace App\Filament\Widgets;

use App\Models\OrderProduct;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UpsellStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('widgets.upsell_orders'), $this->countUpsell())
                ->description(__('widgets.upsell_percentual', ['percentual' => $this->upsellRate()]))
                ->color('success')
                ->icon('solar-course-up-bold'),

            Stat::make(__('widgets.front_orders'), $this->countFront())
                ->description(__('widgets.upsell_percentual', ['percentual' => $this->frontRate()]))
                ->color('warning')
                ->icon('solar-course-up-bold'),
        ];
    }

    private function countUpsell() {

        return OrderProduct::where('upsell', true)->count('upsell');
    }

    private function countFront() {

        return OrderProduct::where('upsell', false)->count('upsell');
    }

    private function upsellRate(): float {

        $upsellCount = OrderProduct::where('upsell', true)->count('upsell');

        $total = OrderProduct::count('id');

        return round($upsellCount * 100 / $total, 2);
    }

    private function frontRate(): float {

        $frontCount = OrderProduct::where('upsell', false)->count('upsell');

        $total = OrderProduct::count('id');

        return round($frontCount * 100 / $total, 2);
    }

    public function getColumns(): int|array|null
    {
        return 2;
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
