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
        $table->string('mesures_correctives')->nullable()->after('conforme');
    });
}

public function down(): void
{
    Schema::table('chlorine_controls', function (Blueprint $table) {
        $table->dropColumn('mesures_correctives');
    });
}

};
