<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mission::create(['mission' => 'Crear tu cuenta', 'description' => 'Crea tu primera cuenta e inicia la aventura', 'icon' => 'https://cdna.artstation.com/p/marketplace/presentation_assets/000/314/446/large/file.jpg?1584477152', 'status' => 1]);
        Mission::create(['mission' => 'Verifica tu cuenta', 'description' => 'Inicia el proceso de verificacion y comienza a obtener beneficios', 'icon' => 'https://cdna.artstation.com/p/marketplace/presentation_assets/000/314/446/large/file.jpg?1584477152', 'status' => 1]);
        Mission::create(['mission' => 'Da el siguiente paso y actualiza tu negocio', 'description' => 'Registra tu negocio', 'icon' => 'https://cdna.artstation.com/p/marketplace/presentation_assets/000/314/446/large/file.jpg?1584477152', 'status' => 1]);
        Mission::create(['mission' => 'Completa tu informacion fiscal', 'description' => 'Completa los requisitos de tu Negocio', 'icon' => 'https://cdna.artstation.com/p/marketplace/presentation_assets/000/314/446/large/file.jpg?1584477152', 'status' => 1]);
        Mission::create(['mission' => 'Solicita tu tarjeta MiPyme personalizada', 'description' => 'Solicita tu tarjeta personalizada', 'icon' => 'https://cdna.artstation.com/p/marketplace/presentation_assets/000/314/446/large/file.jpg?1584477152', 'status' => 1]);
    }
}
