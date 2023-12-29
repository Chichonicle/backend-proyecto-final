<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
        UserSeeder::class,
       ]);
       \App\Models\User::factory(15)->create();

         $this->call([
          SeriesSeeder::class,
         ]);
         $this->call([
          SalaSeeder::class,
         ]);
    }
}
