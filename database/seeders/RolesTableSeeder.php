<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Rol::insert([
            ['nombre' => 'Administrador'],
            ['nombre' => 'Almacenista'],
        ]);
    }
}
