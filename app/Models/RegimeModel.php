<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom', 
        'description', 
        'pourcentage_viande', 
        'pourcentage_poisson', 
        'pourcentage_volaille', 
        'effet_poids_par_semaine', 
        'prix_par_jour'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}