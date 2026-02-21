<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class TopTenCitiesWidget extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('widgets.top_ten_cities');
    }

    protected function getData(): array
    {
        $cities = $this->getCities();

        return [
            'datasets' => [
                [
                    'label' => __('resources.city'),
                    'data' => $cities->map(fn($city) => $city->count),
                ],
            ],
            'labels' => $cities->map(fn($city) => $city->address_city),
        ];
    }

    protected function getCities() {

        return Order::select('address_city', DB::raw('COUNT(*) as count'))
            ->groupBy('address_city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
