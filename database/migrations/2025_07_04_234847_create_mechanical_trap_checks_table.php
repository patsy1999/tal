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
    Schema::create('mechanical_trap_checks', function (Blueprint $table) {
        $table->id();
        $table->date('check_date');
        $table->string('trap_code'); // TR01, TR02, ..., TR14
        $table->integer('captures')->default(0);
        $table->string('action_taken')->default('RAS');
        $table->timestamps();

        $table->unique(['check_date', 'trap_code']); // avoid duplicate daily entries
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanical_trap_checks');
    }
};
