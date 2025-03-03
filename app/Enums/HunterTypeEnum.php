<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HunterTypeEnum: string implements HasLabel
{
    case FIGTHER = 'fighter';
    case MAGE = 'mage';
    case ASSASSIN = 'assassin';
    case TANK = 'tank';
    case MARKSMAN = 'marksman';
    CASE HEALER =  'healer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FIGTHER => 'Fighter',
            self::MAGE => 'Mage',
            self::TANK => 'Tank',
            self::ASSASSIN => 'Assassin',
            self::MARKSMAN => 'Marksman',
            self::HEALER => 'Healer',
        };
    }
}
