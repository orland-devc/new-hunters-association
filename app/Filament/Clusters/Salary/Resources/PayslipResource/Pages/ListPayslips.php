<?php

namespace App\Filament\Clusters\Salary\Resources\PayslipResource\Pages;

use App\Filament\Clusters\Salary\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayslips extends ListRecords
{
    protected static string $resource = PayslipResource::class;
}
