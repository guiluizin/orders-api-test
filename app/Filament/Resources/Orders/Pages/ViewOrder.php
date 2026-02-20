<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewTracking')
                ->label(__('resources.view_tracking'))
                ->url(fn($record) => "https://tools.usps.com/go/TrackConfirmAction?tLabels={$record->shipping->tracking}")
                ->hidden(fn($record) => !$record->shipping),
        ];
    }
}
