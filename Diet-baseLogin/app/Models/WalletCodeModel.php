<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletCodeModel extends Model
{
    protected $table = 'wallet_codes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'montant', 'utilise', 'utilisateur_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}