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
                ->description('Total de Pedidos Recebidos')
                ->color('info')
                ->icon('solar-course-up-bold'),

            Stat::make('Receita Total (USD)', $this->totalUSD())
                ->description('Receita obtida em Dólar')
                ->color('danger')
                ->icon('solar-dollar-outline'),

            Stat::make('Receita Total (BRL)', $this->totalBRL())
                ->description('Receita obtida em Real')
                ->color('success')
                ->icon('solar-dollar-outline'),

            Stat::make('Receita Bruta', $this->totalBRL())
                ->description('Receita bruta total')
                ->color('info')
                ->icon('solar-dollar-outline'),

            Stat::make('Receita Líquida', $this->netRevenue())
                ->description('Receita bruta total')
                ->color('info')
                ->icon('solar-dollar-outline'),

            Stat::make('Reembolsos', $this->countRefunds())
                ->description("{$this->refundsPercentual()}% do total")
                ->color($this->getRefundColor())
                ->icon('solar-course-down-bold'),

            Stat::make('Pedidos Entregues', $this->getFulfillment('Fully Fulfilled'))
                ->description("{$this->getFulfillmentPercentual('Fully Fulfilled')}% dos pedidos")
                ->color('success')
                ->icon('solar-delivery-outline'),

            Stat::make('Pedidos Enviados', $this->getFulfillment('Partially Fulfilled'))
                ->description("{$this->getFulfillmentPercentual('Partially Fulfilled')}% dos pedidos")
                ->color('warning')
                ->icon('solar-inbox-out-outline'), 

            Stat::make('Pedidos Não Enviados', $this->getFulfillment('Unfulfilled'))
                ->description("{$this->getFulfillmentPercentual('Unfulfilled')}% dos pedidos")
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