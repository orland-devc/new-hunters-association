<?php

use App\Enums\ReimbursementStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reimbursements', function (Blueprint $table) {
            $table->id();
            $table->char('reimbursement_code', 10)->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->char('payroll_id', 10)->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('purpose');
            $table->string('receipt')->nullable();
            $table->string('status')->default('pending')->checkIn(ReimbursementStatusEnum::values());
            $table->date('requested_at');
            $table->date('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reimbursements');
    }
};