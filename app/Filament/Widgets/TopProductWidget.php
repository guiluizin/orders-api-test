<?php

namespace App\Filament\Widgets;

use App\Models\OrderProduct;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TopProductWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $product = $this->getTopProduct();

        return [
            Stat::make(__('widgets.top_seller_product'), $product->name)
                ->description(__('widgets.top_seller_description', ['count' => $product->count, 'price' => number_format($product->sum / 100, 2, ',', '.')]))
                ->color('success')
                ->icon('solar-inbox-out-outline'),
        ];
    }

    private function getTopProduct() {

        return OrderProduct::select('products.name', DB::raw('COUNT(*) as count'), DB::raw('SUM(price) as sum'))
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->groupBy('products.name')
            ->orderByDesc('count')
            ->first();
    }

    public function getColumns(): int {

        return 1;
    }

    public function getColumnSpan(): int|string|array
    {
        return 1;
    }
}
