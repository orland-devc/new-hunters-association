<?php

namespace App\Filament\Resources\HunterResource\Pages;

use App\Filament\Resources\HunterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHunter extends EditRecord
{
    protected static string $resource = HunterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
