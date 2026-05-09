<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentsModel extends Model
{
    protected $table = 'Aliments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nom',
        'description',
        'calories',
        'glucides',
        'proteines',
        'lipides',
        'fibre',
        'vitamines',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'nom' => 'required|min_length[3]',
        'calories' => 'required|numeric|greater_than_equal_to[0]',
        'glucides' => 'numeric|greater_than_equal_to[0]',
        'proteines' => 'numeric|greater_than_equal_to[0]',
        'lipides' => 'numeric|greater_than_equal_to[0]'
    ];
}