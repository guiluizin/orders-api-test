<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderProduct;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MediumTicketWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('widgets.medium_ticket'), $this->getMediumTicket())
                ->description(__('widgets.user_medium_ticket'))
                ->color('info')
                ->icon('solar-inbox-out-outline'),
        ];
    }

    private function getMediumTicket() {

        $sumOrders = OrderProduct::sum('price');

        $countOrders = Order::count('id');

        $formated = number_format($sumOrders / $countOrders, 2, ',', '.');

        return "R$ {$formated}";
    }

    public function getColumns(): int {

        return 1;
    }

    public function getColumnSpan(): int|string|array
    {
        return 1;
    }
}
