<?php

namespace App\Filament\Clusters\Salary\Resources\PayslipResource\Pages;

use App\Filament\Clusters\Salary\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayslip extends CreateRecord
{
    protected static string $resource = PayslipResource::class;
}
