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
        $table->dropColumn('mesures_correctives');
    });
}

public function down(): void
{
    Schema::table('chlorine_controls', function (Blueprint $table) {
        $table->text('mesures_correctives')->nullable();
    });
}

};
