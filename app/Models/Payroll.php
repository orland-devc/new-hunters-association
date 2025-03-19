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

    public static function boot()
    {
        parent::boot();

        static::created(function ($payroll) {
            $employees = Employee::all();
            $totalAmount = 0;

            foreach ($employees as $employee) {
                $totalHours = $employee->discordTimeIns()
                    ->whereNotNull('time_out')
                    ->whereBetween('time_in', [$payroll->start_date, $payroll->end_date])
                    ->get()
                    ->sum(function ($timeInRecord) {
                        $timeIn = new \Carbon\Carbon($timeInRecord->time_in);
                        $timeOut = $timeInRecord->time_out ? new \Carbon\Carbon($timeInRecord->time_out) : now();
                        return $timeIn->diffInHours($timeOut);
                    });

                // Calculate Days Based on Total Hours
                $fullDays = floor($totalHours / 8);
                $halfDays = floor($totalHours % 4);
                $absentDays = floor(($totalHours % 8) < 4 ? 1 : 0);

                // Salary Calculation
                if ($employee->salary_type === 'daily') {
                    $grossPay = $employee->salary * $fullDays + ($employee->salary * $halfDays);
                } elseif ($employee->salary_type === 'hourly') {
                    $grossPay = $employee->salary * $totalHours;
                } elseif ($employee->salary_type === 'monthly') {
                    $monthlyRate = $employee->salary / 22;
                    $grossPay = $monthlyRate * ($fullDays + ($halfDays * 0.5));
                }

                // Apply a 10% deduction (example)
                $deductions = $grossPay * 0.10;
                $netPay = $grossPay - $deductions;

                // Create Payslip Record
                Payslip::create([
                    'employee_id' => $employee->id,
                    'payroll_id' => $payroll->id,
                    'gross_pay' => $grossPay,
                    'deductions' => $deductions,
                    'net_pay' => $netPay,
                    'payment_status' => 'pending'
                ]);

                $totalAmount += $netPay;
            }

            // Update Payroll Total
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
