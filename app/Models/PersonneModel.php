<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonneModel extends Model
{
    protected $table = 'Personne';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nom',
        'email',
        'genre',
        'poids',
        'taille',
        'imc',
        'objectif_id',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nom' => 'required|min_length[3]',
        'email' => 'required|valid_email',
        'genre' => 'required|in_list[masculin,feminin]',
        'poids' => 'required|numeric|greater_than[0]',
        'taille' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'poids' => [
            'greater_than' => 'Le poids doit être supérieur à 0'
        ],
        'taille' => [
            'greater_than' => 'La taille doit être supérieure à 0'
        ]
    ];

    /**
     * Calculer l'IMC automatiquement
     */
    public function calculerIMC(&$data)
    {
        if (isset($data['poids']) && isset($data['taille'])) {
            $taille_m = $data['taille'] / 100; // Convertir cm en m
            $data['imc'] = round($data['poids'] / ($taille_m ** 2), 2);
        }
    }

    /**
     * Hook avant insertion/mise à jour
     */
    protected function beforeInsert(array $data)
    {
        $this->calculerIMC($data['data']);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $this->calculerIMC($data['data']);
        return $data;
    }

    /**
     * Obtenir le statut IMC
     */
    public function getStatutIMC($imc)
    {
        if ($imc < 18.5) {
            return 'Sous-poids';
        } elseif ($imc < 25) {
            return 'Poids normal';
        } elseif ($imc < 30) {
            return 'Surpoids';
        } else {
            return 'Obésité';
        }
    }
}