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
}
