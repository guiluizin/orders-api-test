<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextEntry::make('number')
                        ->label(__('resources.number'))
                        ->inlineLabel(),

                    TextEntry::make('customer.name')
                        ->label(__('resources.customer'))
                        ->inlineLabel(),

                    TextEntry::make('brl_total_price')
                        ->label(__('resources.value'))
                        ->inlineLabel()
                        ->money('BRL'),

                    TextEntry::make('payment_status')
                        ->label(__('resources.payment_status'))
                        ->inlineLabel()
                        ->formatStateUsing(fn($state) => match($state) {
                            1 => __('resources.pending'),
                            2 => __('resources.authorized'),
                            3 => __('resources.paid')
                        })
                        ->color(fn($state) => match($state) {
                            1 => 'warning',
                            2 => 'info',
                            3 => 'success'
                        })
                        ->badge(),

                        TextEntry::make('processed_at')
                            ->label(__('resources.processed_at'))
                            ->inlineLabel()
                            ->dateTime('d/m/Y - H:i'),
                ])
                ->heading(__('resources.order_info'))
                ->columnSpanFull(),

                Section::make([
                    TextEntry::make('orderProducts.product.name')
                        ->label(__('resources.name'))
                        ->inlineLabel(),

                    TextEntry::make('orderProducts.product.sku')
                        ->label('SKU')
                        ->inlineLabel(),

                    TextEntry::make('orderProducts.unit_quantity')
                        ->label(__('resources.quantity'))
                        ->inlineLabel(),

                    TextEntry::make('orderProducts.package_quantity')
                        ->label(__('resources.package'))
                        ->formatStateUsing(fn($state) => __('resources.package_quantity', ['number' => $state]))
                        ->inlineLabel(),

                    TextEntry::make('orderProducts.price')
                        ->label(__('resources.total_price'))
                        ->money('BRL')
                        ->inlineLabel()
                ])
                ->heading(__('resources.product_info'))
                ->columnSpanFull(),

                Section::make([
                    TextEntry::make('fulfillment_status')
                    ->label(__('resources.fulfillment_status'))
                    ->inlineLabel()
                    ->formatStateUsing(fn($state) => match($state) {
                        'Fully Fulfilled' => __('resources.delivered'),
                        'Partially Fulfilled' => __('resources.send'),
                        'Unfulfilled' => __('resources.not_sent'),
                    })
                    ->color(fn($state) => match($state) {
                        'Fully Fulfilled' => 'success',
                        'Partially Fulfilled' => 'warning',
                        'Unfulfilled' => 'danger'
                    })
                    ->badge(),

                    TextEntry::make('shipping.carrier')
                        ->label(__('resources.carrier'))
                        ->inlineLabel(),

                    TextEntry::make('shipping.tracking')
                        ->label(__('resources.tracking'))
                        ->inlineLabel(),

                    TextEntry::make('full_address')
                        ->label(__('resources.address'))
                        ->inlineLabel()
                        ->state(fn($record) => "{$record->address_street}, {$record->address_province} {$record->address_zip}, {$record->address_country}"),
                ])
                ->columnSpanFull()
                ->heading(__('resources.shipping_info'))
                ->hidden(fn($record) => !$record->shipping)
            ]);
    }
}
