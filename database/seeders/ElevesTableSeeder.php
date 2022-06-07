<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ElevesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function getEleve()
    {
        
        $ListeEtudiantChemin = storage_path('app' . DIRECTORY_SEPARATOR . 'Liste_Etudiants.csv') ;;
        $ListeEtudiants = [];
        $f = fopen( $ListeEtudiantChemin ,"r");
        if ($f === false) {
            die('Cannot open the file ' . $ListeEtudiantChemin);
        }
        while (($row = fgetcsv($f,10000,";")) !== false) {
            $ListeEtudiants[] = $row;
        }
        fclose($f); 
        return $ListeEtudiants;
        /* dd($ListeEtudiants[2][2]); */
        /* list($email, $nom, $prenom) = explode(";", $Liste); */
        /*  list($email, $nom, $prenom) = explode(":", $ListeEtudiants); */
        /* foreach ($ListeEtudiants[0] as $Liste) {
           
            $str_arr = explode(";", $Liste);
            foreach ($str_arr as $value) {
                array_push($ListeEtudiants, $value);
            }

            dd($ListeEtudiants[1]);
        } */
    }
    public function run()
    {
        DB::table('eleves')->delete();
        $listedesetudiants = $this->getEleve();
        $classe= [];
        for ($i=1; $i < count($listedesetudiants); $i++) { 
            switch ($i) {
                case $i<20 :
                    $classe[]="M48";
                    break;
                
                case $i<50 :
                    $classe[]="M49-1";
                    break;
                case $i<75 :
                    $classe[]="M49-2";
                    break;
               case $i<100 :
                    $classe[]="M49-3";
                    break;  
                case $i<125 :
                    $classe[]="M50-1";
                    break; 
                case $i<150 : 
                    $classe[]="M50-2";
                    break;         

                case $i>150 :
                    $classe[]="M50-3";
                    break;    
            }
        }
        /* dd($classe);  */
        
        $t=0;
        foreach($listedesetudiants as $key=>$value){
            /* dd($value[1]); */
            DB::table('eleves')->insert([
                'nom' => $value[1],
                'prenom' => $value[2],
                'email' => $value[0],
                'password' => Hash::make($value[2]."".$value[1]),
                'taux_absence' => rand(0,100),
                'classe' => $classe[$t]
                
            ]);
            $t++;
        }
        //$t=1;
        
       /*  DB::table('eleves')->delete();
        for ($i=1; $i<=146 ; $i++) { 
        DB::table('eleves')->insert([
                'taux_absenses' => rand(0,100),
                'id_classe' => rand(1,3)]);
         }    */
    }
}
