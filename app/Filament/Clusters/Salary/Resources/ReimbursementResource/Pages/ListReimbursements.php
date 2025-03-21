<?php

namespace App\Filament\Clusters\Salary\Resources\ReimbursementResource\Pages;

use App\Filament\Clusters\Salary\Resources\ReimbursementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReimbursements extends ListRecords
{
    protected static string $resource = ReimbursementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
