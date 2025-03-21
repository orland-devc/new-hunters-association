<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum CurrencyEnum: string implements HasLabel, HasIcon
{
    case PHP = 'PHP';
    case USD = 'USD';

    public function getLabel(): string
    {
        return match ($this) {
            self::PHP => 'Philippine Peso (PHP)',
            self::USD => 'United States Dollar (USD)',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PHP => 'lucide-philippine-peso',
            self::USD => 'lucide-dollar-sign',
        };
    }

    public function getSymbol(): string
    {
        return match ($this) {
            self::PHP => '₱',
            self::USD => '$',
        };
    }

    public function precision(): int
    {
        return match ($this) {
            self::PHP => 2,
            self::USD => 2,
        };
    }

    public function getDefaultRate(): int
    {
        return match ($this) {
            self::PHP => 1,
            self::USD => 1,
        };
    }

    public function getLocale(): string
    {
        return match ($this) {
            self::PHP => 'en_PH',
            self::USD => 'en_US',
        };
    }
}
