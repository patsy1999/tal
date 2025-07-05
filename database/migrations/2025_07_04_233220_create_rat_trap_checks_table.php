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
    Schema::create('rat_trap_checks', function (Blueprint $table) {
        $table->id();
        $table->date('check_date');
        $table->unsignedTinyInteger('trap_number'); // from 1 to 46
        $table->enum('bait_touched', ['Oui', 'Non']);
        $table->enum('corpse_present', ['Oui', 'Non']);
        $table->string('action_taken')->default('RAS');
        $table->timestamps();

        $table->unique(['check_date', 'trap_number']); // to avoid duplicates
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rat_trap_checks');
    }
};
