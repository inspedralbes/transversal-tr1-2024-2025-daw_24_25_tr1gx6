<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json = './resources/json/productos.json';
        $json = file_get_contents($archivo_json);
        $productos = json_decode($json, true);

        foreach ($productos as $producto) {
            Producto::create([
                'nom' => $producto['nom'],
                'desc' => $producto['desc'],
                'stock' => $producto['stock'],
                'preu' => $producto['preu'],
                'img' => $producto['img'],
                'idCategory' => $producto['idCategory'],
                'idMarca' => $producto['idMarca'],
                'idColor' => $producto['idColor'],
                'idTalla' => $producto['idTalla'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
