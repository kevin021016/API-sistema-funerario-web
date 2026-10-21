<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colonia;

class ColoniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colonias = [
            ["nombre" => "Zona Centro", "codigo_postal" => "23000"],
            ["nombre" => "Zona Comercial", "codigo_postal" => "23006"],
            ["nombre" => "Agustín Olachea Avilés", "codigo_postal" => "23010"],
            ["nombre" => "Colina del Sol", "codigo_postal" => "23010"],
            ["nombre" => "Pedregal del Cortez", "codigo_postal" => "23018"],
            ["nombre" => "Esterito", "codigo_postal" => "23020"],
            ["nombre" => "Ladrillera", "codigo_postal" => "23020"],
            ["nombre" => "Guerrero", "codigo_postal" => "23020"],
            ["nombre" => "Antonio Navarro Rubio", "codigo_postal" => "23026"],
            ["nombre" => "Guadalupe Victoria", "codigo_postal" => "23030"],
            ["nombre" => "Loma Linda", "codigo_postal" => "23030"],
            ["nombre" => "San Pablo Guelatao", "codigo_postal" => "23030"],
            ["nombre" => "Granjas Manuel Márquez de León", "codigo_postal" => "23038"],
            ["nombre" => "Loma Obrera", "codigo_postal" => "23038"],
            ["nombre" => "La Escondida", "codigo_postal" => "23039"],
            ["nombre" => "Adolfo Ruiz Cortines", "codigo_postal" => "23040"],
            ["nombre" => "La Rinconada", "codigo_postal" => "23040"],
            ["nombre" => "Los Olivos", "codigo_postal" => "23040"],
            ["nombre" => "Perla", "codigo_postal" => "23040"],
            ["nombre" => "I.T.R.", "codigo_postal" => "23050"],
            ["nombre" => "20 de Noviembre", "codigo_postal" => "23052"],
            ["nombre" => "Popular Indeco", "codigo_postal" => "23056"],
            ["nombre" => "Pueblo Nuevo", "codigo_postal" => "23060"],
            ["nombre" => "Balandra", "codigo_postal" => "23075"],
            ["nombre" => "Revolución", "codigo_postal" => "23075"],
            ["nombre" => "3 de Mayo", "codigo_postal" => "23075"],
            ["nombre" => "3 de Mayo II", "codigo_postal" => "23075"],
            ["nombre" => "Villas de Santa María", "codigo_postal" => "23076"],
            ["nombre" => "Libertad", "codigo_postal" => "23078"],
            ["nombre" => "Agua Escondida", "codigo_postal" => "23080"],
            ["nombre" => "El Calandrio I", "codigo_postal" => "23080"],
            ["nombre" => "El Calandrio II", "codigo_postal" => "23080"],
            ["nombre" => "El Calandrio III", "codigo_postal" => "23080"],
            ["nombre" => "Mezquitito", "codigo_postal" => "23080"],
            ["nombre" => "Sudcalifornia (FOVISSSTE)", "codigo_postal" => "23080"],
            ["nombre" => "8 de Octubre 1ª Sección", "codigo_postal" => "23080"],
            ["nombre" => "San Fernando", "codigo_postal" => "23083"],
            ["nombre" => "Solidaridad Mezquitito", "codigo_postal" => "23083"],
            ["nombre" => "Diana Laura", "codigo_postal" => "23084"],
            ["nombre" => "El Dorado", "codigo_postal" => "23084"],
            ["nombre" => "El Progreso", "codigo_postal" => "23084"],
            ["nombre" => "Miramar", "codigo_postal" => "23085"],
            ["nombre" => "Sector UABCS", "codigo_postal" => "23085"],
            ["nombre" => "8 de Octubre 2ª Sección", "codigo_postal" => "23085"],
            ["nombre" => "Santa Fe", "codigo_postal" => "23085"],
            ["nombre" => "Arcoiris I", "codigo_postal" => "23088"],
            ["nombre" => "Ayuntamiento", "codigo_postal" => "23088"],
            ["nombre" => "Calafia", "codigo_postal" => "23088"],
            ["nombre" => "Lázaro Cárdenas", "codigo_postal" => "23088"],
            ["nombre" => "La Fuente", "codigo_postal" => "23088"],
            ["nombre" => "La Laguna Azul", "codigo_postal" => "23088"],
            ["nombre" => "Camino Real", "codigo_postal" => "23088"],
            ["nombre" => "Olas Altas", "codigo_postal" => "23089"],
            ["nombre" => "Benito Juárez", "codigo_postal" => "23090"],
            ["nombre" => "Solidaridad INFONAVIT", "codigo_postal" => "23090"],
            ["nombre" => "El Conchalito", "codigo_postal" => "23090"],
            ["nombre" => "Jardines de la Paz", "codigo_postal" => "23090"],
            ["nombre" => "Los Pericues", "codigo_postal" => "23097"],
            ["nombre" => "Las Arboledas", "codigo_postal" => "23099"],
            ["nombre" => "Centenario", "codigo_postal" => "23201"],
            ["nombre" => "Chametla", "codigo_postal" => "23205"],
            ["nombre" => "La Esperanza", "codigo_postal" => "23300"]
        ];

        // Añadimos las marcas de tiempo (timestamps) de Laravel manualmente
        // ya que el método 'insert' masivo de Query Builder no las genera solas.
        $now = now();
        $data = array_map(function ($colonia) use ($now) {
            return [
                'nombre' => $colonia['nombre'],
                'codigo_postal' => $colonia['codigo_postal'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $colonias);

        // Insertar los datos en la tabla
        Colonia::insert($data);
    }
}