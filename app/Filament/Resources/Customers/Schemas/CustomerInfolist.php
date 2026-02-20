<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextEntry::make('name')
                        ->label(__('resources.name'))
                        ->inlineLabel(),

                    TextEntry::make('email')
                        ->label('E-mail')
                        ->inlineLabel(),

                    TextEntry::make('phone')
                        ->label(__('resources.phone'))
                        ->inlineLabel()
                ])
                ->columnSpanFull()
            ]);
    }
}
