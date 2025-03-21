<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('payroll_id')->constrained()->onDelete('cascade');
            $table->string('total_days')->nullable();
            $table->string('ot_hours')->nullable();
            $table->decimal('gross_pay', 15, 2);
            $table->decimal('deductions', 15, 2)->default(0.00);
            $table->decimal('reimbursements', 15, 2)->default(0.00);
            $table->decimal('overtime_pay', 15, 2)->default(0.00);
            $table->decimal('professional_fee', 15, 2)->default(0.00);
            $table->decimal('net_pay', 15, 2);
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
