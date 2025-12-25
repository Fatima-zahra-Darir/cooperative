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
        Schema::create('filled_capsules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capsule_id')->constrained('capsules')->onDelete('cascade');
            $table->foreignId('herb_id')->constrained('herbs')->onDelete('cascade');
            $table->integer('quantity'); // Quantity of filled cartons
            $table->decimal('herb_quantity', 10, 2); // Quantity of herb used
            $table->date('filled_date'); // Date when capsules were filled
            $table->foreignId('capsule_movement_id')->nullable()->constrained('capsule_stock_movements')->onDelete('set null'); // Reference to the original usage movement
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filled_capsules');
    }
};
