<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifsModel extends Model
{
    protected $table = 'Objectifs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nom',
        'description',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    protected $validationRules = [
        'nom' => 'required|min_length[3]',
        'description' => 'required|min_length[10]'
    ];
}