<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom',
        'email',
        'password',
        'genre',
        'taille',
        'poids',
        'imc',
        'objectif_id',
        'role',
        'is_gold',
        'gold_purchased_at',
        'wallet_balance'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}