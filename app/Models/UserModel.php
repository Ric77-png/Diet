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

    // Hasher le mot de passe avant l'insertion/update
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $password = $data['data']['password'];
            // Ne hasher que si ce n'est pas déjà un hash bcrypt
            if (!preg_match('/^\$2[aby]\$/', $password)) {
                $data['data']['password'] = password_hash($password, PASSWORD_BCRYPT);
            }
        }
        return $data;
    }

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Méthode pour hasher les mots de passe existants non-hashés
    public function hashAllPasswords()
    {
        $users = $this->findAll();
        foreach ($users as $user) {
            // Vérifier si le mot de passe n'est pas déjà un hash bcrypt
            if (!preg_match('/^\$2[aby]\$/', $user['password'])) {
                $hashedPassword = password_hash($user['password'], PASSWORD_BCRYPT);
                $this->update($user['id'], ['password' => $hashedPassword]);
            }
        }
        return true;
    }
}