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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('image')->nullable();
            $table->integer('duration'); // phút
            $table->integer('max_slot'); // slot - số ca có thể phục vụ tối đa trong 1 khung giờ
            $table->decimal('price', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
