<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table = 'parametres';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cle', 'valeur', 'description'];
    protected $useTimestamps = false;
}