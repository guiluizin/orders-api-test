<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class BestFiveSellersTable extends TableWidget
{
    public function getTableHeading(): string|Htmlable|null
    {
        return __('widgets.top_five_revenue');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Product::query()
                ->withSum('orderProducts', 'price')
                ->withCount('orderProducts')
                ->orderBy('order_products_sum_price', 'desc')
                ->limit(5)
            )
            ->columns([
                TextColumn::make('name'),

                TextColumn::make('sku')
                    ->label('SKU'),

                TextColumn::make('order_products_count')
                    ->label('Vendas'),

                TextColumn::make('order_products_sum_price')
                    ->label('Receita')
                    ->money('BRL', 100),
            ])
            ->paginated(false);
    }

    public function getTableRecordsPerPage(): int|string|null
    {
        return 5;
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
