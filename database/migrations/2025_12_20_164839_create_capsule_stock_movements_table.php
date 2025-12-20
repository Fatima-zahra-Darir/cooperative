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
        Schema::create('capsule_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capsule_id')->constrained('capsules')->onDelete('cascade');
            $table->enum('type', ['restock', 'usage']);
            $table->integer('quantity');
            $table->date('movement_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capsule_stock_movements');
    }
};
