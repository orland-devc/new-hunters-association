<?php

namespace App\Models;

use App\Enums\ReimbursementStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\SegmentAble;

class Reimbursement extends Model 
{
    use HasFactory, SegmentAble;

    protected $fillable = [
        'reimbursement_code',
        'employee_id',
        'amount',
        'purpose',
        'receipt',
        'status',
        'requested_at',
        'approved_at',
    ];

    protected $casts = [
        'status' => ReimbursementStatusEnum::class,
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payslips()
    {
        return $this->belongsToMany(Payslip::class);
    }

    
    public function getSegmentColumn(): string
    {
        return 'reimbursement_code';
    }
}
