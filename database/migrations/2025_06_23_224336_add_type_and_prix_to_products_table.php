<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void

    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'prix')) {
                $table->decimal('prix', 8, 2)->nullable()->after('type');
            }
        });
    }


    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('prix');
        });
    }

};
