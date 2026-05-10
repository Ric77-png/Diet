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
        // Si déjà connecté, rediriger selon le rôle
        if ($this->session->get('isLoggedIn')) {
            if ($this->session->get('role') == 'admin') {
                return redirect()->to('/admin');
            }
            return redirect()->to('/client');
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
            'userId' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'role' => $user['role'],
            'is_gold' => $user['is_gold'],
            'isLoggedIn' => true
        ]);

        // Redirection selon le rôle
        if ($user['role'] == 'admin') {
            return $this->response->setJSON([
                'success' => true,
                'redirect' => '/admin'
            ]);
        }

        // Pour les clients (non-admin)
        return $this->response->setJSON([
            'success' => true,
            'redirect' => '/client'
        ]);
    }

    // Déconnexion
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

    // Redirection vers l'inscription client (pour compatibilité)
    public function register()
    {
        return redirect()->to('/register-client');
    }

    // Afficher la page d'inscription client
    public function registerClient()
    {
        // Si déjà connecté, rediriger
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/client');
        }

        return view('auth/register_client');
    }

    // Traiter l'inscription client (AJAX)
    public function processRegisterClient()
    {
        $validation = \Config\Services::validation();
        
        // Règles de validation
        $rules = [
            'nom' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Le nom est requis.',
                    'min_length' => 'Le nom doit contenir au moins 3 caractères.',
                    'max_length' => 'Le nom ne doit pas dépasser 100 caractères.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'L\'email est requis.',
                    'valid_email' => 'L\'email doit être valide.',
                    'is_unique' => 'Cet email est déjà utilisé.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Le mot de passe est requis.',
                    'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.'
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'La confirmation du mot de passe est requise.',
                    'matches' => 'Les mots de passe ne correspondent pas.'
                ]
            ],
            'genre' => [
                'rules' => 'required|in_list[M,F]',
                'errors' => [
                    'required' => 'Le genre est requis.',
                    'in_list' => 'Le genre doit être M ou F.'
                ]
            ],
            'taille' => [
                'rules' => 'required|numeric|greater_than[0]|less_than[300]',
                'errors' => [
                    'required' => 'La taille est requise.',
                    'numeric' => 'La taille doit être un nombre.',
                    'greater_than' => 'La taille doit être supérieure à 0.',
                    'less_than' => 'La taille doit être inférieure à 300.'
                ]
            ],
            'poids' => [
                'rules' => 'required|numeric|greater_than[0]|less_than[500]',
                'errors' => [
                    'required' => 'Le poids est requis.',
                    'numeric' => 'Le poids doit être un nombre.',
                    'greater_than' => 'Le poids doit être supérieur à 0.',
                    'less_than' => 'Le poids doit être inférieur à 500.'
                ]
            ],
            'imc' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'L\'IMC est requis.',
                    'numeric' => 'L\'IMC doit être un nombre.'
                ]
            ]
        ];

        if (!$validation->setRules($rules)->run($this->request->getPost())) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        // Créer l'utilisateur
        $passwordHash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $userData = [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'password' => $passwordHash,
            'genre' => $this->request->getPost('genre'),
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids'),
            'imc' => $this->request->getPost('imc'),
            'role' => 'client',
            'is_gold' => 0,
            'wallet_balance' => 0
        ];

        if ($this->userModel->insert($userData)) {
            $user = $this->userModel->where('email', $this->request->getPost('email'))->first();
            
            // Stocker en session
            $this->session->set([
                'userId' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role'],
                'is_gold' => $user['is_gold'],
                'isLoggedIn' => true
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Inscription réussie!',
                'redirect' => '/client'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur s\'est produite lors de l\'inscription.'
            ]);
        }
    }

    // Vérifier la disponibilité de l'email (pour validation AJAX)
    public function checkEmail()
    {
        $email = $this->request->getPost('email');
        
        $user = $this->userModel->where('email', $email)->first();

        return $this->response->setJSON([
            'available' => !$user
        ]);
    }
}