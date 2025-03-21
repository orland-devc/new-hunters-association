<?php

namespace App\Filament\Clusters\Salary\Resources\ReimbursementResource\Pages;

use App\Filament\Clusters\Salary\Resources\ReimbursementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReimbursement extends CreateRecord
{
    protected static string $resource = ReimbursementResource::class;
}
