<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\AccountWidget as BaseWidget;

class AccountWidget extends BaseWidget
{
    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
