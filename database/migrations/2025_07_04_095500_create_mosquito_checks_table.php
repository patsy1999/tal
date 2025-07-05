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
        Schema::create('mosquito_checks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('month_label'); // NOT nullable
            $table->string('D01')->nullable();
            $table->string('D02')->nullable();
            $table->string('D03')->nullable();
            $table->string('D04')->nullable();
            $table->string('D05')->nullable();
            $table->string('D06')->nullable();
            $table->string('D07')->nullable();
            $table->string('D08')->nullable();
            $table->string('D09')->nullable();
            $table->string('D10')->nullable();
            $table->string('D11')->nullable();
            $table->string('D12')->nullable();
            $table->string('D13')->nullable();
            $table->string('D14')->nullable();
            $table->string('D15')->nullable();
            $table->string('moustiquaire')->nullable();
            $table->string('etat_nettoyage')->nullable();
            $table->string('action_corrective')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosquito_checks');
    }
};
