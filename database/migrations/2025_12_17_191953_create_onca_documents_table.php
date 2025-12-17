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
        Schema::create('onca_documents', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // health, pest, cleaning, batch, storage
            $table->string('reference');
            $table->string('title');
            $table->string('version')->default('01');
            $table->date('date');
            $table->string('responsible')->nullable();
            $table->json('content')->nullable(); // Stores the dynamic fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onca_documents');
    }
};
