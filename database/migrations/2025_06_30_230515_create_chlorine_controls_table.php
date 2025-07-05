<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('chlorine_controls', function (Blueprint $table) {
            $table->id();
            $table->date('date');                    // Example: 2025-06-30
            $table->string('heure');                 // Example: 09:00 or 14:00
            $table->string('sampling_point');        // Example: Réfectoire or Lave-mains
            $table->float('chlorine_ppm');           // Example: 1.2
            $table->boolean('conforme');
            $table->string('mesures_correctives')->nullable()->default('R.A.S');
            $table->timestamps();                    // created_at, updated_at
        });
    }

    public function down(): void {
        Schema::dropIfExists('chlorine_controls');
    }
};
