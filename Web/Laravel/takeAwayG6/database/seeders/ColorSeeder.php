<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json='./resources/json/colores.json';
        $json = file_get_contents($archivo_json);
        $colores = json_decode($json, true);

        foreach($colores as $color){
            Color::create([
                'nom'=>$color['nom'],
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
