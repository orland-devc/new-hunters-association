<?php

namespace App\Filament\Clusters\Salary\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\Salary\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
