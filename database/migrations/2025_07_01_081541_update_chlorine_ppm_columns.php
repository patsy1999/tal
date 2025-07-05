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
    Schema::table('chlorine_controls', function (Blueprint $table) {
        $table->float('chlorine_ppm_min')->after('sampling_point');
        $table->float('chlorine_ppm_max')->after('chlorine_ppm_min');
        $table->dropColumn('chlorine_ppm'); // remove old column
    });
}

public function down(): void
{
    Schema::table('chlorine_controls', function (Blueprint $table) {
        $table->float('chlorine_ppm');
        $table->dropColumn('chlorine_ppm_min');
        $table->dropColumn('chlorine_ppm_max');
    });
}

};
