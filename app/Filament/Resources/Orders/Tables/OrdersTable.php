<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label(__('resources.number'))
                    ->sortable(),

                TextColumn::make('orderProducts.product.name')
                    ->label(__('resources.product'))
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label(__('resources.customer'))
                    ->searchable(),
                    
                TextColumn::make('brl_total_price')
                    ->label(__('resources.value'))
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label(__('resources.payment_status'))
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
                    ->alignCenter()
                    ->badge(),

                ImageColumn::make('payment_brand')
                    ->label('')
                    ->defaultImageUrl(fn($state) => $state ? asset("images/brands/{$state}.png") : '')
                    ->alignCenter(),

                TextColumn::make('fulfillment_status')
                    ->label(__('resources.fulfillment_status'))
                    ->formatStateUsing(fn($state) => match($state) {
                        'Fully Fulfilled' => __('resources.delivered'),
                        'Partially Fulfilled' => __('resources.send'),
                        'Unfulfilled' => __('resources.not_sent'),
                    })
                    ->color(fn($state) => match($state) {
                        'Fully Fulfilled' => 'success',
                        'Partially Fulfilled' => 'warning',
                        'Unfulfilled' => 'danger',
                    })
                    ->alignCenter()
                    ->badge(),
            ])
            ->filters([
                //
            ]);
    }
}
