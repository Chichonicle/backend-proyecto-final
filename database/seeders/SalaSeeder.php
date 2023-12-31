<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('salas')->insert([
            "name" => "Dragon Ball Z",
            "series_id" => 1,


        ]);

        DB::table('salas')->insert([
            "name" => "Los caballeros del zodiaco",
            "series_id" => 2,

        ]);

        DB::table('salas')->insert([
            "name" => "Dragones y Mazmorras",
            "series_id" => 3,
        ]);


        DB::table('salas')->insert([
            "name" => "Chicho Terremoto",
            "series_id" => 4,

        ]);


        DB::table('salas')->insert([
            "name" => "Voltron",
            "series_id" => 5,

        ]);


        DB::table('salas')->insert([
            "name" => "He-Man",
            "series_id" => 6,

        ]);


        DB::table('salas')->insert([
            "name" => "Conan el barbaro",
            "series_id" => 7,

        ]);

        DB::table('salas')->insert([
            "name" => "Oliver y Benji",
            "series_id" => 8,

        ]);
        DB::table('salas')->insert([
            "name" => "Los mosqueperros",
            "series_id" => 9,

        ]);
    }
}
