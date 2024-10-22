<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json='./resources/json/marcas.json';
        $json = file_get_contents($archivo_json);

        $marcas = json_decode($json, true);

        foreach($marcas as $marca){
            Marca::create([
                'nom'=>$category['nom'],
                'imagen'=>$category['imagen'],
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

    }
}
