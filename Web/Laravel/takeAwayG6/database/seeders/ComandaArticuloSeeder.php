<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComandaArticulo;

class ComandaArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json = './resources/json/comandasArticulos.json';
        $json = file_get_contents($archivo_json);
        $comandasArts = json_decode($json ,true);

        foreach ($comandasArts as $comandasArt) {
            ComandaArticulo::create([
                'idProducto' => $comandasArt['idProducto'],
                'idComanda' => $comandasArt['idComanda'],
                'talla' => $comandasArt['talla'],
                'color' => $comandasArt['color'],
                'quantitat' => $comandasArt['quantitat'],
                'preu' => $comandasArt['preu'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
