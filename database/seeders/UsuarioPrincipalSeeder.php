<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioPrincipalSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Lalo', 'apellidos' => 'Mendez', 'rol' => 'Administrador', 'email' => 'lalo12145@test.com', 'tel' => '6121231517'],
            ['name' => 'Ana Sofia', 'apellidos' => 'Casas Reales', 'rol' => 'Asesor', 'email' => 'ana.casas@test.com', 'tel' => '6125550101'],
            ['name' => 'Roberto', 'apellidos' => 'Gomez Farías', 'rol' => 'Vendedor', 'email' => 'roberto.g@test.com', 'tel' => '6125550102'],
            ['name' => 'Lucia', 'apellidos' => 'Villanueva', 'rol' => 'Asesor', 'email' => 'lucia.v@test.com', 'tel' => '6125550103'],
            ['name' => 'Marcos', 'apellidos' => 'Peralta', 'rol' => 'Administrador', 'email' => 'm.peralta@test.com', 'tel' => '6125550104'],
            ['name' => 'Ximena', 'apellidos' => 'Lopez', 'rol' => 'Vendedor', 'email' => 'ximena.l@test.com', 'tel' => '6125550105'],
            ['name' => 'Daniel', 'apellidos' => 'Salazar', 'rol' => 'Asesor', 'email' => 'd.salazar@test.com', 'tel' => '6125550106'],
            ['name' => 'Carla', 'apellidos' => 'Ibarra', 'rol' => 'Vendedor', 'email' => 'c.ibarra@test.com', 'tel' => '6125550107'],
            ['name' => 'Fernando', 'apellidos' => 'Reyes', 'rol' => 'Asesor', 'email' => 'f.reyes@test.com', 'tel' => '6125550108'],
            ['name' => 'Gabriela', 'apellidos' => 'Mendoza', 'rol' => 'Administrador', 'email' => 'g.mendoza@test.com', 'tel' => '6125550109'],
            ['name' => 'Hugo', 'apellidos' => 'Sánchez', 'rol' => 'Vendedor', 'email' => 'h.sanchez@test.com', 'tel' => '6125550110'],
            ['name' => 'Isabel', 'apellidos' => 'Castro', 'rol' => 'Asesor', 'email' => 'i.castro@test.com', 'tel' => '6125550111'],
            ['name' => 'Jorge', 'apellidos' => 'Luis Borges', 'rol' => 'Vendedor', 'email' => 'j.borges@test.com', 'tel' => '6125550112'],
            ['name' => 'Karina', 'apellidos' => 'Valenzuela', 'rol' => 'Asesor', 'email' => 'k.valenzuela@test.com', 'tel' => '6125550113'],
            ['name' => 'Mauricio', 'apellidos' => 'Pacheco', 'rol' => 'Administrador', 'email' => 'm.pacheco@test.com', 'tel' => '6125550114'],
        ];

        foreach ($usuarios as $u) {
            User::create([
                'name' => $u['name'],
                'apellidos' => $u['apellidos'],
                'rol' => $u['rol'],
                'email' => $u['email'],
                'password' => Hash::make('password123'),
                'telefono' => $u['tel'],
                'last_active_at' => now()->subMinutes(rand(1, 1440)), // Actividad aleatoria en las últimas 24h
                'created_at' => now()->subDays(rand(1, 30)), // Creado hace algunos días
            ]);
        }

        $this->command->info('Usuario de prueba creado con éxito: admin@test.com / admin123');
    }
}