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

         
         //$this->call(TachesPubliquesTableSeeder::class); 
        
        //$this->call(ClasseTableSeeder::class);
        //$this->call(MatieresTableSeeder::class);
        //$this->call(PeriodesTableSeeder::class);
        //$this->call(sallesTableSeeder::class);
        //$this->call(EnseignantMatiereTableSeeder::class);  
        //$this->call(EnseignantsTableSeeder::class);
        //$this->call(ElevesTableSeeder::class);
      $this->call(TachesPubliquesTableSeeder::class); 




        //$this->call(ClasseTableSeeder::class);
        //$this->call(MatieresTableSeeder::class);
       $this->call(PeriodesTableSeeder::class);
       // $this->call(sallesTableSeeder::class);
        $this->call(EnseignantMatiereTableSeeder::class);
        $this->call(EleveMatiereTableSeeder::class);
       // $this->call(EnseignantsTableSeeder::class);

     // $this->call(TachesPubliquesTableSeeder::class);
          //$this->call(ElevesTableSeeder::class);


         //$this->call(TachesPubliquesTableSeeder::class);





    }
}
