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
        Schema::table('capsules', function (Blueprint $table) {
            // Add nombre_capsules column - automatically calculated as nombre_cartons * 125000
            $table->bigInteger('nombre_capsules')->default(0)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capsules', function (Blueprint $table) {
            $table->dropColumn('nombre_capsules');
        });
    }
};
