<?php

namespace App\Controllers;

use App\Models\LivreModel;
use App\Models\EmpruntModel;

class Bibliotheque extends BaseController
    {
    protected $livreModel;

        public function __construct()
    {
        $this->livreModel = new LivreModel();
    }

       public function alllivres(): string
    {
        $livres = $this->livreModel->findAll();
        return view('livres/index', [
            'livres' => $livres,
            'title' => 'Liste de tous les livres',
        ]);
    }
    }
