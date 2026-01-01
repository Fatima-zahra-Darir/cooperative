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
        // Add type_emballage to products table
        Schema::table('products', function (Blueprint $table) {
            $table->enum('type_emballage', ['PILULIER', 'BOUCHON'])->nullable()->after('name');
        });

        // Create commande_emballages table - stores packaging selections for orders
        Schema::create('commande_emballages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('product_stock_id'); // Emballage product stock
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('commande_id')
                ->references('id')
                ->on('commandes')
                ->onDelete('cascade');

            $table->foreign('product_stock_id')
                ->references('id')
                ->on('product_stock')
                ->onDelete('cascade');
        });

        // Create commande_filled_capsules table - stores filled capsule selections
        Schema::create('commande_filled_capsules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('filled_capsule_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('commande_id')
                ->references('id')
                ->on('commandes')
                ->onDelete('cascade');

            $table->foreign('filled_capsule_id')
                ->references('id')
                ->on('filled_capsules')
                ->onDelete('cascade');
        });

        // Add capsules_per_unit to commandes table
        Schema::table('commandes', function (Blueprint $table) {
            $table->integer('capsules_per_unit')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type_emballage');
        });

        Schema::dropIfExists('commande_emballages');
        Schema::dropIfExists('commande_filled_capsules');

        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('capsules_per_unit');
        });
    }
};
