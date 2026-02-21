<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Refund;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class ProvinceRefundsChart extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('widgets.province_refunds');
    }

    protected function getData(): array
    {
        $provinces = $this->getProvinces();

        return [
            'datasets' => [
                [
                    'label' => __('widgets.province'),
                    'borderColor' => '#dc2626',
                    'data' => $provinces->map(fn($province) => $province->count),
                ],
            ],
            'labels' => $provinces->map(fn($province) => $province->address_province),
        ];
    }

    protected function getProvinces() {

        return Order::select('address_province', DB::raw('COUNT(*) as count'))
            ->with('refund')
            ->groupBy('address_province')
            ->orderBy('count', 'desc')
            ->get();
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
