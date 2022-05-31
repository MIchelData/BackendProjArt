<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TachesPubliqueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taches_publique')->delete();

        DB::table('taches_publique')->insert([
            'description' => "2 page A4 avec l'ensemble des élèves de la classe",
            'date' => '2020-05-01',
            'duree' => '240',
            'infos' => 'rendu trombinoscope',
            'id_user' => 1,
            'type' => 'devoir']);



        DB::table('taches_publique')->insert([
                'description' => 'tout documents autorisés',
                'date' => '2020-01-01',
                'duree' => '240',
                'infos' => 'examen de prog',
                'id_user' => 2,
                'type' => 'examen']);
        
                DB::table('taches_publique')->insert([
                    'description' => 'tout documents autorisés',
                    'date' => '2020-10-10',
                    'duree' => '60',
                    'infos' => 'Repas canadien comem',
                    'id_user' => 2,
                    'type' => 'autre']);

    }


    /* $table->increments('id');
    $table->timestamps();
    $table->string('type');
    $table->date('date');
    $table->integer('duree');
    $table->string('description');
    $table->string('infos');
    $table->foreignId('id_user')->constrained('users');
}); */






}
