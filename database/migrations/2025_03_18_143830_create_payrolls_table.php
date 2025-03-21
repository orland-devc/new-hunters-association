<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 15, 2)->default(0.00);
            $table->enum('status', ['pending', 'processed', 'completed'])->default('pending');
            $table->decimal('bonus', 10, 2)->nullable()->default(0);
            $table->decimal('overtime_hours', 8, 2)->nullable()->default(0);
            $table->json('deductions_details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
