<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       //$this->call(usersTableSeeder::class);
       // $this->call(taches_priveeTableSeeder::class);
       // $this->call(salleTableSeeder::class);

       // $this->call(modulesTableSeeder::class);
     //$this->call(ClasseTableSeeder::class);
      //  $this->call(ConfigCoursTableSeeder::class);
       //$this->call(classeCoursTableSeeder::class);
        //$this->call(EnseignantsTableSeeder::class);
       
      // $this->call(EnseignantMatiereTableSeeder::class);
        //$this->call(MatieresTableSeeder::class);
       // $this->call(EnseignantMatiereTableSeeder::class);
        $this->call(MatieresTableSeeder::class);
       // $this->call(PeriodesTableSeeder::class);


    }
}
