<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
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
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email incorrect'
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            if (hash_equals((string) $user['password'], $password)) {
                $this->userModel->update($user['id'], [
                    'password' => $password
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Mot de passe incorrect'
                ]);
            }
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

    // Afficher l'inscription (infos personnelles)
    public function register()
    {
        return view('auth/form_person');
    }

    // Stocker les infos personnelles avant l'etape sante
    public function storePersonal()
    {
        $rules = [
            'nom' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'genre' => 'required|in_list[masculin,feminin]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->session->set('form_person', [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'genre' => $this->request->getPost('genre')
        ]);

        return redirect()->to('/register/health');
    }

    // Afficher le formulaire sante
    public function healthForm()
    {
        $personal = $this->session->get('form_person');
        if (!$personal) {
            return redirect()->to('/register')
                ->with('error', 'Veuillez commencer par les informations personnelles.');
        }

        $objectifs = $this->db->table('objectifs')
            ->select('id, nom, description')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return view('auth/form_sante', [
            'objectifs' => $objectifs,
            'personal' => $personal
        ]);
    }

    // Enregistrer le compte a partir des infos sante
    public function storeHealth()
    {
        $personal = $this->session->get('form_person');
        if (!$personal) {
            return redirect()->to('/register')
                ->with('error', 'Veuillez commencer par les informations personnelles.');
        }

        $rules = [
            'taille' => 'required|decimal|greater_than[0]',
            'poids' => 'required|decimal|greater_than[0]',
            'objectif_id' => 'required|is_not_unique[objectifs.id]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $taille = (float) $this->request->getPost('taille');
        $poids = (float) $this->request->getPost('poids');
        $imc = $taille > 0 ? round($poids / ($taille * $taille), 2) : null;

        $data = [
            'nom' => $personal['nom'],
            'email' => $personal['email'],
            'password' => $personal['password'],
            'genre' => $personal['genre'],
            'taille' => $taille,
            'poids' => $poids,
            'imc' => $imc,
            'objectif_id' => (int) $this->request->getPost('objectif_id'),
            'role' => 'client'
        ];

        $this->userModel->insert($data);
        $this->session->remove('form_person');

        return redirect()->to('/login')
            ->with('success', 'Compte cree avec succes. Vous pouvez vous connecter.');
    }
}