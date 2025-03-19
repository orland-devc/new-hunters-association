<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'discord_id',
        'name', 
        'email', 
        'phone', 
        'address', 
        'position', 
        'department',
        'hire_date', 
        'salary', 
        'salary_type', 
        'bank_account_number',
        'tax_id', 
        'payment_method'
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function discordTimeIns()
    {
        return $this->hasMany(DiscordTimeIn::class, 'discord_user_id', 'discord_id');
    }

    
}
