<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivo_json = './resources/json/user.json';
        $json = file_get_contents($archivo_json);
        $users = json_decode($json, true);

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'rol' => $user['rol'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
