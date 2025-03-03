<?php

namespace App\Filament\Clusters\Salary\Resources\RaidsResource\Pages;

use App\Filament\Clusters\Salary\Resources\RaidsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRaids extends EditRecord
{
    protected static string $resource = RaidsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
