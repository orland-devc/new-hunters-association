<?php

namespace App\Filament\Resources\TimeInResource\Pages;

use App\Filament\Resources\TimeInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeIn extends EditRecord
{
    protected static string $resource = TimeInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
