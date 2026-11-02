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
        Schema::create('run_gps_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('run_id')->constrained()->cascadeOnDelete();
            $table->decimal('latitude', 10, 7); $table->decimal('longitude', 10, 7);
            $table->decimal('altitude', 8, 2)->nullable(); $table->decimal('accuracy', 8, 2)->nullable();
            $table->timestamp('recorded_at'); $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('run_gps_points');
    }
};
