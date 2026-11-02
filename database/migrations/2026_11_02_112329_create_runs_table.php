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
        Schema::create('runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('run_date');
            $table->decimal('distance_km', 7, 2);
            $table->unsignedInteger('duration_seconds');
            $table->unsignedSmallInteger('average_hr')->nullable();
            $table->unsignedSmallInteger('max_hr')->nullable();
            $table->unsignedInteger('elevation_gain_m')->default(0);
            $table->string('run_type', 30)->default('Easy');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runs');
    }
};
