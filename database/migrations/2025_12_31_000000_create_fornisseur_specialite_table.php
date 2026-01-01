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
        Schema::create('fornisseur_specialite', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fornisseur_id');
            $table->string('specialite');
            $table->timestamps();

            // Foreign key
            $table->foreign('fornisseur_id')
                ->references('id')
                ->on('fornisseurs')
                ->onDelete('cascade');

            // Unique constraint to prevent duplicates
            $table->unique(['fornisseur_id', 'specialite']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornisseur_specialite');
    }
};
