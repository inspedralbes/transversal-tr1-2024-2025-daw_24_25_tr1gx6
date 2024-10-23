<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comanda;

class ComandaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json = './resources/json/comanda.json';
        $json = file_get_contents($archivo_json);
        $comandas = json_decode($json, true);

        foreach ($comandas as $comanda) {
            Comanda::create([
                'idUser' => $comanda['idUser'],
                'estat' => $comanda['estat'],
                'total' => $comanda['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
