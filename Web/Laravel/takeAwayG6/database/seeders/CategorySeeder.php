<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json='./resources/json/category.json';
        $json = file_get_contents($archivo_json);
                
        $categories = json_decode($json, true);

        foreach($categories as $category){
            Categoria::create([
                'nom'=>$category['nom'],
                'imagen'=>$category['imagen'],
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
