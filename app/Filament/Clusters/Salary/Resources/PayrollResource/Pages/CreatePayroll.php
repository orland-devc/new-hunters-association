<?php

namespace App\Filament\Clusters\Salary\Resources\PayrollResource\Pages;

use App\Filament\Clusters\Salary\Resources\PayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayroll extends CreateRecord
{
    protected static string $resource = PayrollResource::class;
}
