<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class modulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $listemodulesnommodules = ['Bases scientifiques et techniques','Bases théoriques de la communication','Economie des médias','Bases théoriques et pratiques du marketing',
            'Technologie des médias','Anglais 1-2', 'Analyse de marché et stratégie marketing', 'Bases pratiques de la communication','Bases scientifiques et conceptuelles',
            'Evolution et métiers des média','Gestion budgétaire','Technologies web','Applications web','Contenus média', 'E-commerce et marketing stratégique', 'Gestion de projet',
            'Interopérabilité et infrastructure','Méthodologie de recherche', 'Sociologie des médias', 'Conception de produit média','Développement de produit média', 'Droit des médias',
            'Interfaces et interactions utilisateur',"Modèles d'affaires des média","Projet d'articulation","Veille sociétale","Vendre un produit média", "Développement hypermédia",
            "Evaluation et optimisation de produit/processusmédia", "Profil professionnel", "Rentabilité de projets/produit", "User eXperience lab", "Veille technologique",
            "Digital trends","Innovation Crunch Time","Projet d'intégration","Stage professionnel", "Travail de bachelor",];
        $listeabreviations = ["BaScienTec","ThéoCom","EcoMédia","BaseMark", "TecMédia", "Anglais-12", "AnaStraMar","BasPratCom","BaScienCo", "EvolMétMéd","GesBudget", "TecWeb", "AppWeb", "ContMédia",
            "EMarket", "GesProj", "InterInfra", "MétRecher", "Socio", "ConProdMéd", "DévProdMéd", "DroitMéd", "InterUtil", "ModAffMed", "ProjArt", "VeillSoc", "VendreProd", "DévHyper", "ArchiOWeb",
            "EvalPro", "ProfilPro", "Renta", "UserExpLab", "VeillTech", "DigiTrend", "CRUNCH", "ProjInt", "Stage", "TB" ];

        DB::table('modules')->delete();

        foreach($listemodulesnommodules as $key => $value){
            DB::table('modules')->insert([
                'nom'=>$value,
                'abreviation'=>$listeabreviations[$key],
                //'nombredecredits'=>$listecredits[$key] //ajouter abreviation à la table
            ]);
    }

    }
}
