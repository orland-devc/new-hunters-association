<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SalaryTypeEnum: string implements HasLabel
{
    case MONTHLY = 'monthly';
    case BIWEEKLY = 'biweekly';
    case WEEKLY = 'weekly';
    case DAILY = 'daily';
    case HOURLY = 'hourly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly',
            self::BIWEEKLY => 'Biweekly',
            self::WEEKLY => 'Weekly',
            self::DAILY => 'Daily',
            self::HOURLY => 'Hourly',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

