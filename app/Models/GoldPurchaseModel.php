<?php

namespace App\Models;

use CodeIgniter\Model;

class GoldPurchaseModel extends Model
{
    protected $table = 'gold_purchases';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'montant', 'statut', 'code_gold_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
