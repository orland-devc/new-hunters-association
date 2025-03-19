<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->date('start_date'); // Payroll period start
            $table->date('end_date'); // Payroll period end
            $table->decimal('total_amount', 15, 2)->default(0.00); // Total salary payout
            $table->enum('status', ['pending', 'processed', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
