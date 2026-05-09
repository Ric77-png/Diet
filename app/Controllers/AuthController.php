<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Page d'authentification
     */
    public function index()
    {
        // Si déjà connecté, rediriger vers dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Traiter la connexion
     */
    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[2]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', ['errors' => $this->validator->getErrors()]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Chercher l'utilisateur
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect');
        }

        // Vérifier le mot de passe
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect');
        }

        // Créer la session
        session()->set([
            'id' => $user['id'],
            'email' => $user['email'],
            'nom' => $user['nom'],
            'isLoggedIn' => true
        ]);

        return redirect()->to('/dashboard');
    }

    /**
     * Page d'enregistrement
     */
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    /**
     * Traiter l'enregistrement
     */
    public function signup()
    {
        $rules = [
            'nom' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[2]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', ['errors' => $this->validator->getErrors()]);
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/')->with('success', 'Inscription réussie! Connectez-vous.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de l\'inscription');
        }
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Déconnecté avec succès');
    }
}