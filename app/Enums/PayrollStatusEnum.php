<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum PayrollStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELED => 'Canceled',
            self::COMPLETED => 'Completed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::CANCELED => 'tertiary',
            self::COMPLETED => 'secondary',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'lucide-clock-3',
            self::APPROVED => 'lucide-circle-check-big',
            self::REJECTED => 'lucide-ban',
            self::CANCELED => 'lucide-circle-x',
            self::COMPLETED => 'lucide-circle-plus',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}

