<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 
        'payroll_id', 
        'gross_pay', 
        'reimbursements',
        'ot_hours',
        'total_days',
        'overtime_pay',
        'deductions', 
        'professional_fee',
        'net_pay', 
        'payment_status'
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function reimbursements()
    {
        return $this->hasMany(Reimbursement::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Listen for the updated event
        static::updated(function ($payslip) {
            // If net_pay was modified, update the parent payroll's total
            if ($payslip->isDirty('net_pay')) {
                $payslip->updatePayrollTotal();
            }
        });

        // Listen for the created event (just in case a new payslip is created after the payroll)
        static::created(function ($payslip) {
            $payslip->updatePayrollTotal();
        });

        // Listen for the deleted event (in case a payslip is removed)
        static::deleted(function ($payslip) {
            $payslip->updatePayrollTotal();
        });
    }

    /**
     * Update the payroll's total amount based on all its payslips.
     */
    protected function updatePayrollTotal()
    {
        if ($this->payroll_id) {
            $payroll = Payroll::find($this->payroll_id);
            
            if ($payroll) {
                // Calculate the new total from all payslips
                $newTotal = $payroll->payslips()->sum('net_pay');
                
                // Update the payroll's total amount
                $payroll->update(['total_amount' => $newTotal]);
            }
        }
    }

    /**
     * Override the save method to ensure net_pay is calculated correctly
     */
    public function save(array $options = [])
    {
        // Calculate the net pay before saving
        $this->calculateNetPay();
        
        return parent::save($options);
    }
    
    /**
     * Calculate the net pay based on other fields
     */
    protected function calculateNetPay()
    {
        // Get professional_fee with default value of 0
        $professionalFee = $this->professional_fee ?? 0;
        
        // Calculate net pay
        $this->net_pay = $this->gross_pay + 
                         $this->reimbursements + 
                         $this->overtime_pay - 
                         $this->deductions + 
                         $professionalFee;
    }
}