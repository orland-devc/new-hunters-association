<?php

namespace App\Filament\Clusters\Salary\Resources\PayrollResource\Pages;

use App\Filament\Clusters\Salary\Resources\PayrollResource;
use App\Models\Payroll;
use App\Models\Payslip;
use App\Models\Reimbursement;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Http;

class EditPayroll extends EditRecord
{
    protected static string $resource = PayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approve')
                ->icon('lucide-circle-check')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn () => $this->approvePayroll())
                ->after(fn () => $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->record->id])))
                ->visible(fn ($record) => $record->status !== 'approved'),

            Action::make('notify-employees')
                ->label('Notify Employees')
                ->icon('lucide-megaphone')
                ->color('secondary')
                ->requiresConfirmation()
                ->action(fn () => $this->notifyEmployees())
                ->visible(fn ($record) => $record->status === 'approved'),

            Actions\DeleteAction::make()
                ->icon('lucide-trash-2'),
        ];
    }

    protected function approvePayroll(): void
    {
        $payroll = $this->record;

        $payroll->update(['status' => 'approved']);

        Payslip::where('payroll_id', $payroll->id)->update(['payment_status' => 'approved']);
        Reimbursement::where('payroll_id', $payroll->id)->update(['status' => 'added']);
    }

    protected function notifyEmployees(): void
    {
        $payroll = $this->record;
        $payslips = Payslip::where('payroll_id', $payroll->id)->get();
    
        $employees = [];
    
        foreach ($payslips as $payslip) {
            $employee = $payslip->employee;
            if ($employee && $employee->discord_id) {
                // Base payslip data
                $employeeData = [
                    'discord_id' => $employee->discord_id,
                    'name' => $employee->name,
                    'pay_grosspay' => $payslip->gross_pay,
                    'deduction' => $payslip->deductions,
                    'payslip_amount' => $payslip->net_pay, // Matching the expected key                    
                    'payslip_id' => $payslip->id, // Needed for Discord interaction
                ];
    
                // Conditionally add extra fields
                if ($payslip->ot_hours > 0) {
                    $employeeData['overtime_pay'] = $payslip->overtime_pay;
                }
                if ($payslip->reimbursements > 0) {
                    $employeeData['reimbursement_pay'] = $payslip->reimbursements;
                }
                if ($payslip->professional_fee > 0) {
                    $employeeData['professional_fee'] = $payslip->professional_fee;
                }
    
                $employees[] = $employeeData;
            }
        }
    
        if (!empty($employees)) {
            Http::post('http://localhost:3000/notify-employees', [
                'payroll_id' => $payroll->id,
                'employees' => $employees,
            ]);
        }
    }
    
}
