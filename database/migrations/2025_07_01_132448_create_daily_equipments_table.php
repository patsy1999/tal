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
        Schema::create('daily_equipments', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // The date of the check
            $table->string('equipment_name');
            $table->boolean('is_good')->default(true); // true for 'oui', false for 'non'
            $table->text('observation')->nullable(); // 'ras' or any notes
            $table->timestamps();

            $table->unique(['date', 'equipment_name']); // Only one entry per equipment per day
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_equipments');
    }
};
