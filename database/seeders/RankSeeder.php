<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::create(['name' => 'Invitado_Aprendiz', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'Invitado_Maestro', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'Libreton_Aprendiz', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'Invitado_Especialista', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'Invitado_Maestro', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'MiPyme_Hierro', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'MiPyme_Plata', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'MiPyme_Oro', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
        Rank::create(['name' => 'MiPyme_Platino', 'requirements' => '{}', 'points' => 100, 'badge' => 'https://cdn4.iconfinder.com/data/icons/badges-9/66/75-512.png']);
    }
}
