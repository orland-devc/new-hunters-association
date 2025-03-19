<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::insert([
            [
                'discord_id' => '1183775956222099499',
                'name' => 'Orland Sayson',
                'email' => 'orland@outsoar.ph',
                'phone' => '1234567890',
                'address' => '123 Main St, Cityville',
                'position' => 'Software Engineer',
                'department' => 'IT',
                'hire_date' => Carbon::parse('2023-01-15'),
                'salary' => 1200.00,
                'salary_type' => 'monthly',
                'bank_account_number' => '123456789',
                'tax_id' => 'TX123456',
                'payment_method' => 'bank_transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discord_id' => '1203969762011512901',
                'name' => 'Chris Cabatbat',
                'email' => 'chris@outsoar.ph',
                'phone' => '0987654321',
                'address' => '456 Oak St, Townsville',
                'position' => 'HR Manager',
                'department' => 'Human Resources',
                'hire_date' => Carbon::parse('2022-07-01'),
                'salary' => 1000.00,
                'salary_type' => 'monthly',
                'bank_account_number' => '987654321',
                'tax_id' => 'TX654321',
                'payment_method' => 'bank_transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discord_id' => '1290567568565866562',
                'name' => 'Aaron Arenas',
                'email' => 'aaron@outsoar.ph',
                'phone' => '1122334455',
                'address' => '789 Pine St, Villagetown',
                'position' => 'Accountant',
                'department' => 'Finance',
                'hire_date' => Carbon::parse('2021-11-10'),
                'salary' => 900.00,
                'salary_type' => 'monthly',
                'bank_account_number' => '112233445',
                'tax_id' => 'TX987654',
                'payment_method' => 'check',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discord_id' => '977920727749636147',
                'name' => 'Aranjit Pogi',
                'email' => 'jit@outsoar.ph',
                'phone' => '1122334455',
                'address' => '789 Pine St, Villagetown',
                'position' => 'PlayBook Master',
                'department' => 'Development',
                'hire_date' => Carbon::parse('2021-11-10'),
                'salary' => 900.00,
                'salary_type' => 'monthly',
                'bank_account_number' => '112233445',
                'tax_id' => 'TX987654',
                'payment_method' => 'check',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discord_id' => '1335800648494485515',
                'name' => 'Dexter Pogi',
                'email' => 'dex@outsoar.ph',
                'phone' => '1122334455',
                'address' => '789 Pine St, Villagetown',
                'position' => 'UI Designer',
                'department' => 'Design',
                'hire_date' => Carbon::parse('2021-11-10'),
                'salary' => 900.00,
                'salary_type' => 'monthly',
                'bank_account_number' => '112233445',
                'tax_id' => 'TX987654',
                'payment_method' => 'check',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
