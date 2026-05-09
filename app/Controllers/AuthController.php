<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    // Afficher la page de login
    public function login()
    {
        // Si déjà connecté, rediriger vers dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    // Traiter la tentative de connexion (AJAX)
    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email incorrect'
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mot de passe incorrect'
            ]);
        }

        // Stocker en session
        $this->session->set([
            'userId'     => $user['id'],
            'nom'        => $user['nom'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true
        ]);

        return $this->response->setJSON([
            'success' => true,
            'redirect' => '/dashboard'
        ]);
    }

    // Déconnexion
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}