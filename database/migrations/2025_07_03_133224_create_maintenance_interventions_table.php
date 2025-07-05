<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('maintenance_interventions', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->time('start_time')->nullable();
        $table->time('end_time')->nullable();
        $table->string('zone');
        $table->string('company');
        $table->string('intervenant');
        $table->text('work_details')->nullable();
        $table->text('materials_used')->nullable();
        $table->string('site_clean')->nullable();
        $table->string('production_ongoing')->nullable();
        $table->time('cleaning_end_time')->nullable();
        $table->string('risk_level')->nullable(); // Élevé / Moyen / Faible
        $table->string('product_safety_risk')->nullable(); // Oui / Non
        $table->string('risk_description')->nullable(); // "Lequel?"
        $table->string('location_signed')->nullable();
        $table->date('date_signed')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_interventions');
    }
};
