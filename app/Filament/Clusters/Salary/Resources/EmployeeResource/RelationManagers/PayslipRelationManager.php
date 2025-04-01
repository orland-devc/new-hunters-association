<?php

namespace App\Filament\Clusters\Salary\Resources\EmployeeResource\RelationManagers;

use App\Enums\PayslipStatusEnum;
use App\Filament\Clusters\Salary\Resources\PayslipResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayslipRelationManager extends RelationManager
{
    protected static string $relationship = 'payslips';

    public function form(Form $form): Form
    {
        return PayslipResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payment_status')
            ->columns([
                Tables\Columns\TextColumn::make('total_hours')
                ->getStateUsing(function ($record) {
                    $totalMinutes = $record->employee->discordTimeIns()
                        ->whereNotNull('time_out') 
                        ->whereBetween('time_in', [$record->payroll->start_date, $record->payroll->end_date])
                        ->get()
                        ->sum(function ($timeInRecord) {
                            $timeIn = new \Carbon\Carbon($timeInRecord->time_in);
                            $timeOut = new \Carbon\Carbon($timeInRecord->time_out);
            
                            return $timeIn->diffInMinutes($timeOut); 
                        });
            
                    $totalHours = floor($totalMinutes / 60);
                    $remainingMinutes = $totalMinutes % 60;
            
                    $fullDays = floor($totalHours / 8);
                    $remainingHours = $totalHours % 8;
            
                    $dayEquivalent = $fullDays; 
                    if ($remainingHours >= 4) {
                        $dayEquivalent += 0.5; 
                    }
            
                    return "{$totalHours}h {$remainingMinutes}m ({$dayEquivalent} days)";
                })
                ->sortable()
                ->label('Total Hours'),    
                Tables\Columns\TextColumn::make('gross_pay')->money('PHP'),
                Tables\Columns\TextColumn::make('reimbursements')->money('PHP'),
                Tables\Columns\TextColumn::make('deductions')->money('PHP'),
                Tables\Columns\TextColumn::make('net_pay')->money('PHP'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn ($record) => PayslipStatusEnum::tryFrom($record->payment_status)?->getColor())
                    ->icon(fn ($record) => PayslipStatusEnum::tryFrom($record->payment_status)?->getIcon())
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
