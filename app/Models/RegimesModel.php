<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimesModel extends Model
{
    protected $table = 'Regimes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nom',
        'description',
        'calories_min',
        'calories_max',
        'objectif_id',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'nom' => 'required|min_length[3]',
        'objectif_id' => 'required|numeric',
        'calories_min' => 'required|numeric|greater_than[0]',
        'calories_max' => 'required|numeric|greater_than[0]'
    ];
}