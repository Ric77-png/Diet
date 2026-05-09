<?php

namespace App\Controllers;

use App\Models\PersonneModel;
use App\Models\AlimentsModel;
use App\Models\RegimesModel;

class DashboardController extends BaseController
{
    protected $personneModel;
    protected $alimentsModel;
    protected $regimesModel;

    public function __construct()
    {
        $this->personneModel = new PersonneModel();
        $this->alimentsModel = new AlimentsModel();
        $this->regimesModel = new RegimesModel();
    }

    /**
     * Tableau de bord principal
     */
    public function index()
    {
        // Vérifier si l'utilisateur est connecté (le filtre 'auth' le fait)
        $data = [
            'title' => 'Tableau de bord - Diet Manager',
            'stats' => [
                'total_utilisateurs' => $this->personneModel->countAll(),
                'utilisateurs_hommes' => $this->personneModel->where('genre', 'masculin')->countAllResults(),
                'utilisateurs_femmes' => $this->personneModel->where('genre', 'feminin')->countAllResults(),
                'total_aliments' => $this->alimentsModel->countAll(),
                'total_regimes' => $this->regimesModel->countAll(),
                'imc_moyen' => $this->getIMCMoyen()
            ],
            'graphes' => $this->getDataGraphes(),
            'tableaux' => $this->getTableaux()
        ];

        return view('dashboard/index', $data);
    }

    /**
     * Retourner les statistiques en JSON
     */
    public function getStats()
    {
        return $this->response->setJSON([
            'total_utilisateurs' => $this->personneModel->countAll(),
            'imc_moyen' => $this->getIMCMoyen(),
            'distribution_objectifs' => $this->getDistributionObjectifs(),
            'calories_moyennes' => $this->getCaloriesMoyennes()
        ]);
    }

    /**
     * Gestionnaire des utilisateurs
     */
    public function utilisateurs()
    {
        $data = [
            'title' => 'Gestion des utilisateurs',
            'utilisateurs' => $this->personneModel->findAll()
        ];

        return view('dashboard/utilisateurs', $data);
    }

    /**
     * Gestionnaire des régimes
     */
    public function regimes()
    {
        $data = [
            'title' => 'Gestion des régimes',
            'regimes' => $this->regimesModel->findAll()
        ];

        return view('dashboard/regimes', $data);
    }

    /**
     * Gestionnaire des aliments
     */
    public function aliments()
    {
        $data = [
            'title' => 'Gestion des aliments',
            'aliments' => $this->alimentsModel->findAll()
        ];

        return view('dashboard/aliments', $data);
    }

    /**
     * Calcul de l'IMC moyen
     */
    private function getIMCMoyen()
    {
        $result = $this->personneModel->selectAvg('imc')->first();
        return round($result['imc'] ?? 0, 2);
    }

    /**
     * Distribution des objectifs
     */
    private function getDistributionObjectifs()
    {
        return $this->personneModel
            ->select('o.nom as nom, COUNT(*) as count')
            ->join('Objectifs o', 'Personne.objectif_id = o.id', 'left')
            ->groupBy('o.nom')
            ->findAll();
    }

    /**
     * Calories moyennes par objectif
     */
    private function getCaloriesMoyennes()
    {
        return $this->regimesModel
            ->select('o.nom as nom, AVG((Regimes.calories_min + Regimes.calories_max) / 2) as calories_moyennes')
            ->join('Objectifs o', 'Regimes.objectif_id = o.id')
            ->groupBy('o.nom')
            ->findAll();
    }

    /**
     * Préparer les données pour les graphes
     */
    private function getDataGraphes()
    {
        return [
            'imc_distribution' => $this->getDistributionIMC(),
            'objectifs' => $this->getDistributionObjectifs(),
            'calories' => $this->getCaloriesMoyennes()
        ];
    }

    /**
     * Distribution IMC
     */
    private function getDistributionIMC()
    {
        $personnes = $this->personneModel->where('imc !=', null)->findAll();
        
        $distribution = [
            'Sous-poids' => 0,
            'Normal' => 0,
            'Surpoids' => 0,
            'Obésité' => 0
        ];

        foreach ($personnes as $personne) {
            if ($personne['imc'] < 18.5) {
                $distribution['Sous-poids']++;
            } elseif ($personne['imc'] < 25) {
                $distribution['Normal']++;
            } elseif ($personne['imc'] < 30) {
                $distribution['Surpoids']++;
            } else {
                $distribution['Obésité']++;
            }
        }

        return $distribution;
    }

    /**
     * Préparer les tableaux croisés
     */
    private function getTableaux()
    {
        return [
            'genre_objectif' => $this->getTableauCroiseGenreObjectif(),
            'top_aliments' => $this->getTopAliments()
        ];
    }

    /**
     * Tableau croisé Genre x Objectif
     */
    private function getTableauCroiseGenreObjectif()
    {
        $result = $this->personneModel
            ->select('Personne.genre as genre, o.nom as nom, COUNT(*) as count')
            ->join('Objectifs o', 'Personne.objectif_id = o.id', 'left')
            ->groupBy('Personne.genre, o.nom')
            ->findAll();

        return $result;
    }

    /**
     * Top aliments les plus caloriques
     */
    private function getTopAliments()
    {
        return $this->alimentsModel
            ->orderBy('calories', 'DESC')
            ->limit(10)
            ->findAll();
    }
}