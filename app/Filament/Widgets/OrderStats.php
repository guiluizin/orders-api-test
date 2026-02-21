<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Refund;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('widgets.orders_count'), $this->countOrders())
                ->description(__('widgets.total_orders'))
                ->color('info')
                ->icon('solar-course-up-bold'),

            Stat::make(__('widgets.usd_total'), $this->totalUSD())
                ->description(__('widgets.usd_revenue'))
                ->color('danger')
                ->icon('solar-dollar-outline'),

            Stat::make(__('widgets.brl_total'), $this->totalBRL())
                ->description(__('widgets.brl_revenue'))
                ->color('success')
                ->icon('solar-dollar-outline'),

            Stat::make(__('widgets.gross_revenue'), $this->totalBRL())
                ->description(__('widgets.total_gross_revenue'))
                ->color('info')
                ->icon('solar-dollar-outline'),

            Stat::make(__('widgets.net_revenue'), $this->netRevenue())
                ->description(__('widgets.total_net_revenue'))
                ->color('info')
                ->icon('solar-dollar-outline'),

            Stat::make(__('widgets.refunds'), $this->countRefunds())
                ->description(__('widgets.refunds_percentual', ['percentual' => $this->refundsPercentual()]))
                ->color($this->getRefundColor())
                ->icon('solar-course-down-bold'),

            Stat::make(__('widgets.orders_delivered'), $this->getFulfillment('Fully Fulfilled'))
                ->description(__('widgets.orders_percentual', ['percentual' => $this->getFulfillmentPercentual('Fully Fulfilled')]))
                ->color('success')
                ->icon('solar-delivery-outline'),

            Stat::make(__('widgets.orders_send'), $this->getFulfillment('Partially Fulfilled'))
                ->description(__('widgets.orders_percentual', ['percentual' => $this->getFulfillmentPercentual('Partially Fulfilled')]))
                ->color('warning')
                ->icon('solar-inbox-out-outline'), 

            Stat::make(__('widgets.orders_not_sent'), $this->getFulfillment('Unfulfilled'))
                ->description(__('widgets.orders_percentual', ['percentual' => $this->getFulfillmentPercentual('Unfulfilled')]))
                ->color('danger')
                ->icon('solar-square-transfer-vertical-outline'), 
        ];
    }

    private function countOrders(): int {

        return Order::count('id');
    }

    private function countRefunds(): int {

        return Refund::count('id');
    }

    private function totalUSD(): string {
        
        $total = Order::sum('usd_total_price');

        $formated = number_format($total / 100, 2, ',', '.');

        return "US$ {$formated}";
    }

    private function totalBRL(): string {
        
        $total = Order::sum('brl_total_price');

        $formated = number_format($total / 100, 2, ',', '.');

        return "R$ {$formated}";
    }

    private function getFulfillment(string $status) {

        return Order::where('fulfillment_status', $status)->count('fulfillment_status');
    }

    private function getFulfillmentPercentual(string $status): float {

        $countTotal = Order::count('fulfillment_status');

        $countStatus = Order::where('fulfillment_status', $status)->count('fulfillment_status');

        return $countStatus / $countTotal * 100;
    }

    private function netRevenue(): string {

        $total = Order::doesntHave('refund')->sum('brl_total_price');

        $formated = number_format($total / 100, 2, ',', '.');

        return "R$ {$formated}";
    }

    private function refundsPercentual(): float {

        $countTotal = Order::count('id');

        $countRefunds = Refund::count('id');

        return $countRefunds / $countTotal * 100;
    }

    private function getRefundColor(): string {

        $rate = $this->refundsPercentual();

        return match(true) {
            $rate <= 3 => 'success',
            $rate <= 7 => 'warning',
            default => 'danger',
        };
    }
}