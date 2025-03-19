<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->char('employee_id', 10)->unique()->nullable();
            $table->string('discord_id')->nullable()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('position');
            $table->string('department')->nullable();
            $table->date('hire_date');
            $table->decimal('salary', 10, 2);
            $table->enum('salary_type', ['hourly', 'daily', 'weekly', 'biweekly', 'monthly'])->default('monthly');
            $table->string('bank_account_number')->nullable();
            $table->string('tax_id')->nullable();
            $table->enum('payment_method', ['bank_transfer', 'cash', 'check'])->default('bank_transfer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
