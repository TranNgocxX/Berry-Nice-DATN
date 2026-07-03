<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->cascadeOnDelete();

            $table->dateTime('start_time')->index();
            $table->dateTime('end_time')->index();

            $table->enum('status', [
                'pending',
                'confirmed',
                'rejected',
                'completed',
                'cancelled'
            ])->default('pending')->index();

            $table->decimal('price', 15, 2); // Lưu giá gốc từ bảng services sang
            $table->decimal('total_price', 15, 2); 

            $table->enum('payment_method', ['cash', 'qr'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid')->index();
            $table->index(['service_id', 'status', 'start_time'], 'idx_service_slots_check');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
