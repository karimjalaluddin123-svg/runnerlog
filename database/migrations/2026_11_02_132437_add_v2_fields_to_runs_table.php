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
        Schema::table('runs', function (Blueprint $table) {
            $table->string('tracking_mode')->default('manual')->after('notes');
            $table->decimal('average_speed_kmh', 6, 2)->nullable()->after('tracking_mode');
            $table->timestamp('started_at')->nullable()->after('average_speed_kmh');
            $table->timestamp('finished_at')->nullable()->after('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('runs', function (Blueprint $table) {
            $table->dropColumn(['tracking_mode', 'average_speed_kmh', 'started_at', 'finished_at']);
        });
    }
};
