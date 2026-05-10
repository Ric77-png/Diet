<?php

namespace App\Controllers;

use App\Models\UserModel;

class MaintenanceController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Hasher tous les mots de passe non-hashés
    public function hashPasswords()
    {
        $result = $this->userModel->hashAllPasswords();
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Tous les mots de passe ont été hashés avec succès'
        ]);
    }
}
