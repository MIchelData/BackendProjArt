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
