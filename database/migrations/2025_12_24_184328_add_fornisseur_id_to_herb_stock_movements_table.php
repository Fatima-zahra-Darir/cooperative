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
        Schema::table('herb_stock_movements', function (Blueprint $table) {
            $table->foreignId('fornisseur_id')->nullable()->after('herb_id')->constrained('fornisseurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('herb_stock_movements', function (Blueprint $table) {
            $table->dropForeign(['fornisseur_id']);
            $table->dropColumn('fornisseur_id');
        });
    }
};
