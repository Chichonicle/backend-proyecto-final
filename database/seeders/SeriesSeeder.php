<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('series')->insert([
            "name" => "Dragon Ball Z",
            "year" => 1986,
            "genre" => "Anime",
            "url" => "https://www.youtube.com/watch?v=3HT60PKvrfM",
            "picture" => "https://www.crunchyroll.com/imgsrv/display/thumbnail/480x720/catalog/crunchyroll/35e4ac6339f5fdcc164160a5755790cd.jpe",

            

        ]);

        DB::table('series')->insert([
            "name" => "Los caballeros del zodiaco",
            "year" => 1986,
            "genre" => "Anime",
            "url" => "https://www.youtube.com/watch?v=YemEUSOMong",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIvxF1E7o9CadsUNuUYY4OZcdiViDbLN65aUGwTQ62FzMqZTahmouDFtcFtyixYLIN9mc&usqp=CAU",


        ]);
        
        DB::table('series')->insert([
            "name" => "Dragones y Mazmorras",
            "year" => 1985,
            "genre" => "Rol",
            "url" => "https://www.youtube.com/watch?v=8URvPR_Jo-k",
            "picture" => "https://i.pinimg.com/564x/9f/c6/1b/9fc61b0da761affd3c15d23f0f974afc.jpg",


        ]);
        DB::table('series')->insert([
            "name" => "Chicho Terremoto",
            "year" => 1981,
            "genre" => "Deportes",
            "url" => "https://www.youtube.com/watch?v=XsL-VQoC0oc",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSm1FXKJqBRhDtEFJJ5zhIwIHsJdKyAn_YirL2lKSto1xPQ7BJ3oAU9KiggE-XBeXFXCKc&usqp=CAU",


        ]);
        DB::table('series')->insert([
            "name" => "Voltron",
            "year" => 1984,
            "genre" => "Anime",
            "url" => "https://www.youtube.com/watch?v=3HgWCp79nzI",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6vSPJwrr2Nq99M7n8AvdYPM7eqA4CbG8sgQPyjZ0pNOv_jZFKURGgLRmd0Y3qFVWVLIw&usqp=CAU",


        ]);
        DB::table('series')->insert([
            "name" => "He-Man",
            "year" => 1983,
            "genre" => "Anime",
            "url" => "https://www.youtube.com/watch?v=kYCzmjKNNPk",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHd4nLhM119m9YpPdBrqQJ5lvnFUC3pL2ZnrmXgzgrU0KiY7U1Aq_YlTBv0FOi3GiJvW4&usqp=CAU",


        ]);
        DB::table('series')->insert([
            "name" => "Conan el barbaro",
            "year" => 1982,
            "genre" => "Anime",
            "url" => "https://www.youtube.com/watch?v=IEXM9izpSYI",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd9m4ufmjht4HTDZW5xxcytYsAERPLcoTCgh1_bfVqbUlhvyuCmErDs2rlKfwvPUaP7Iw&usqp=CAU",


        ]);
        
        DB::table('series')->insert([
            "name" => "Oliver y Benji",
            "year" => 1983,
            "genre" => "Deportes",
            "url" => "https://www.youtube.com/watch?v=geazMG_mIE4",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmEBhcMUjpMy3fjQACRuSGzoKdiMjClCcwqEt-JaC08qKJrQ0eGJ9X3D69Q9gs2IrChnk&usqp=CAU",


        ]);
        DB::table('series')->insert([
            "name" => "Los mosqueperros",
            "year" => 1983,
            "genre" => "Aventuras",
            "url" => "https://www.youtube.com/watch?v=0bRjnrODhzk",
            "picture" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ163rOBsxdMbKSfu4lPEGN_YRfqu_nvMjf5mXIKimJMuMu2LqkmNcia_NLlghwS87U0BQ&usqp=CAU",


        ]);
    }
}
    

