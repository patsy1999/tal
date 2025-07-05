<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Update existing NULL values to a default non-null string
        \DB::table('mosquito_checks')
            ->whereNull('month_label')
            ->update(['month_label' => 'unknown']);

        // Step 2: Change the column to NOT NULL
        Schema::table('mosquito_checks', function (Blueprint $table) {
            $table->string('month_label')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('mosquito_checks', function (Blueprint $table) {
            $table->string('month_label')->nullable()->change();
        });
    }
};
