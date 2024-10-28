<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;



class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json = './resources/json/stocks.json';
        $json = file_get_contents($archivo_json);
        $stocks = json_decode($json, true);

        foreach ($stocks as $stock) {
            Stock::create([
                'idProducto' => $stock['idProducto'],
                'Nstock' => $stock['Nstock'],
                'Color' => $stock['Color'],
                'TallaCamisa' => $stock['TallaCamisa'],
                'TallaZapato' => $stock['TallaZapato'],
                'created_at'=> now(),
                'updated_at'=> now()
            ]);
        }
    }
}
