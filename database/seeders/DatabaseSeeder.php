<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Report;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin gestu_ndox_mi',
            'email' => 'gestundoxmi@outlook.com',
            'password' => '@dming2025',
        ]);

        Report::create([
            'nom' => 'Testeur Plateau',
            'email' => 'reporter@example.com',
            'telephone' => '+221 77 000 00 00',
            'type_probleme' => 'fuite',
            'description' => 'Fuite sur conduite à Dakar Plateau, proximité Place de l’Indépendance.',
            'latitude' => 14.6753,
            'longitude' => -17.4370,
            'adresse' => 'Dakar Plateau, Sénégal',
            'statut' => 'en attente',
        ]);
    }
}
