<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Payslip;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date', 
        'end_date', 
        'total_amount', 
        'status'
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function reimbursements()
    {
        return $this->hasManyThrough(Reimbursement::class, Employee::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($payroll) {
            $employees = Employee::all();
            $totalAmount = 0;

            foreach ($employees as $employee) {
                $totalHours = $employee->discordTimeIns()
                    ->whereNotNull('time_out')
                    ->whereBetween('time_in', [
                        Carbon::parse($payroll->start_date)->startOfDay(),
                        Carbon::parse($payroll->end_date)->endOfDay()
                    ])                    
                    ->get()
                    ->sum(function ($timeInRecord) {
                        $timeIn = new \Carbon\Carbon($timeInRecord->time_in);
                        $timeOut = $timeInRecord->time_out ? new \Carbon\Carbon($timeInRecord->time_out) : now();
                        return $timeIn->diffInHours($timeOut);
                    });

                // Calculate expected hours and OT hours
                $expectedHours = self::countWeekdays($payroll->start_date, $payroll->end_date) * 8;
                $otHours = max(0, $totalHours - $expectedHours);
                $otPay = $otHours * ($employee->salary / 8);

                // Regular Pay Calculation
                $fullDays = floor($totalHours / 8);
                $halfDays = floor(($totalHours % 8) / 4);
                
                if ($employee->salary_type === 'daily') {
                    $grossPay = $employee->salary * $fullDays + ($employee->salary * $halfDays);
                } elseif ($employee->salary_type === 'hourly') {
                    $grossPay = $employee->salary * $totalHours;
                } elseif ($employee->salary_type === 'monthly') {
                    $monthlyRate = $employee->salary / 22;
                    $grossPay = $monthlyRate * ($fullDays + ($halfDays * 0.5));
                }

                // Add OT Pay after regular pay calculation
                $approvedReimbursements = $employee->reimbursements()
                    ->where('status', 'approved')
                    ->whereBetween('requested_at', [$payroll->start_date, $payroll->end_date])
                    ->sum('amount');

                $employee->reimbursements()
                    ->where('status', 'approved')
                    ->whereBetween('requested_at', [$payroll->start_date, $payroll->end_date])
                    ->update(['payroll_id' => $payroll->id]);

                $deductions = ( $grossPay + $otPay )* 0.10;
                $netPay = $grossPay + $approvedReimbursements + $otPay - $deductions;

                Payslip::create([
                    'employee_id' => $employee->id,
                    'payroll_id' => $payroll->id,
                    'total_days' => $fullDays + ($halfDays * 0.5),
                    'ot_hours' => $otHours,
                    'gross_pay' => $grossPay,
                    'overtime_pay' => $otPay,  // Added OT pay field
                    'reimbursements' => $approvedReimbursements,
                    'deductions' => $deductions,
                    'net_pay' => $netPay,
                    'payment_status' => 'pending'
                ]);

                $totalAmount += $netPay;
            }

            $payroll->update(['total_amount' => $totalAmount]);
        });
    }

    /**
     * Count the number of weekdays (Monday–Friday) between two dates.
     */
    public static function countWeekdays($start_date, $end_date)
    {
        $period = CarbonPeriod::create($start_date, $end_date);
        $weekdays = 0;

        foreach ($period as $date) {
            if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $weekdays++;
            }
        }

        return $weekdays;
    }
}
