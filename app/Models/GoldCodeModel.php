<?php

namespace App\Models;

use CodeIgniter\Model;

class GoldCodeModel extends Model
{
    protected $table = 'gold_codes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'duree_jours', 'utilise', 'utilisateur_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;
}
