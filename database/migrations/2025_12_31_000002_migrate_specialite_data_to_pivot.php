<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing specialite data to the pivot table
        $fornisseurs = DB::table('fornisseurs')->get();
        
        foreach ($fornisseurs as $fornisseur) {
            if (!empty($fornisseur->specialite)) {
                $specialites = [];
                
                // Check if it's JSON format (array)
                if (str_starts_with($fornisseur->specialite, '[')) {
                    $decoded = json_decode($fornisseur->specialite, true);
                    if (is_array($decoded)) {
                        $specialites = $decoded;
                    }
                } else {
                    // Single string value
                    $specialites = [$fornisseur->specialite];
                }
                
                // Insert into pivot table
                foreach (array_unique(array_filter($specialites)) as $specialite) {
                    DB::table('fornisseur_specialite')->insertOrIgnore([
                        'fornisseur_id' => $fornisseur->id,
                        'specialite' => $specialite,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the pivot table
        DB::table('fornisseur_specialite')->truncate();
    }
};
