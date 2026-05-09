<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nom',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'nom' => 'required|min_length[3]'
    ];

    protected $validationMessages = [
        'email' => [
            'valid_email' => 'Email invalide',
            'is_unique' => 'Email déjà utilisé'
        ],
        'password' => [
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères'
        ]
    ];
}