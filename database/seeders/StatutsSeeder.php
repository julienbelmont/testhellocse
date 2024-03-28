<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuts')->insert([
            'statut' => 'ACTIVE',
            'libelle' => 'Actif'
        ]);
        DB::table('statuts')->insert([
            'statut' => 'PENDING',
            'libelle' => 'En attente'
        ]);
        DB::table('statuts')->insert([
            'statut' => 'INACTIVE',
            'libelle' => 'Inactif'
        ]);
    }
}
