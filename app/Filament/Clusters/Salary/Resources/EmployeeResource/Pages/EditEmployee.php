<?php

namespace App\Filament\Clusters\Salary\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\Salary\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
