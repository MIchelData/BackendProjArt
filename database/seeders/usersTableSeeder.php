<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
           'nom'=>'Uebelhart',
            'prenom'=>'Calvin',
            'email'=>'calvin.uebelhart@heig-vd.ch',
            'password'=>Hash::make('mdpcalvin'),
            'admin'=>1
        ]);
        DB::table('users')->insert([
            'nom'=>'Claude',
            'prenom'=>'Jonathan',
            'email'=>'jonathan.claude@heig-vd.ch',
            'password'=>Hash::make('mdpjonathan'),
            'admin'=>1
        ]);
        DB::table('users')->insert([
            'nom'=>'Kuter',
            'prenom'=>'Marie',
            'email'=>'marie.kuter@heig-vd.ch',
            'password'=>Hash::make('mariekuter'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Bolli',
            'prenom'=>'Laurent',
            'email'=>'laurent.bolli@heig-vd.ch',
            'password'=>Hash::make('laurentbolli'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Sandoz',
            'prenom'=>'Romain',
            'email'=>'romain.sandoz@heig-vd.ch',
            'password'=>Hash::make('romainsandoz'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Panchard ',
            'prenom'=>' Jacques',
            'email'=>'jaques.panchard@heig-vd.ch',
            'password'=>Hash::make('jaquespanchard'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Renou',
            'prenom'=>' Sylvain',
            'email'=>'sylvain.renou@heig-vd.ch',
            'password'=>Hash::make('sylvainrenou'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Pilipona',
            'prenom'=>' Claude',
            'email'=>'claude.philipona@heig-vd.ch',
            'password'=>Hash::make('claudephilipona'),
            'admin'=>0
        ]);

        DB::table('users')->insert([
            'nom'=>'Alberini ',
            'prenom'=>' Alain',
            'email'=>'alain.alberini@heig-vd.ch',
            'password'=>Hash::make('alainalberini'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Germanier ',
            'prenom'=>' Yves',
            'email'=>'yves.germanier@heig-vd.ch',
            'password'=>Hash::make('yvesgermanier'),
            'admin'=>0
        ]);
        DB::table('users')->insert([
            'nom'=>'Dufour ',
            'prenom'=>' Arnaud',
            'email'=>'arnaud.dufour@heig-vd.ch',
            'password'=>Hash::make('yvesgermanier'),
            'admin'=>0
        ]);


        
        for($i=0; $i<30; $i++){
            DB::table('users')->insert([
                'nom'=>'nom'.$i,
                'prenom'=>'prenom'.$i,
                'email'=>'prenom'.$i.'.nom'.$i.'@heig-vd.ch',
                'password'=>Hash::make('mdp'.$i),
                'admin'=>0
            ]);
        }
    }
}
