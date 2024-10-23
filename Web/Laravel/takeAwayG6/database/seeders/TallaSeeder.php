<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Talla;

class TallaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json = './resources/json/tallas.json';
        $json = file_get_contents($archivo_json);
        $tallas = json_decode($json, true);

        foreach($tallas as $talla){
            Talla::create([
                'medida'=>$talla['medidas'],
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
