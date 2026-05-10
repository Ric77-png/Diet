<?php

namespace App\Controllers;

use App\Models\UserModel;

class ClientController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Dashboard client
    public function dashboard()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        // Vérifier que l'utilisateur existe
        if (!$user) {
            return redirect()->to('/login');
        }

        return view('client/dashboard', [
            'user' => $user,
            'solde' => $user['wallet_balance'] ?? 0
        ]);
    }

    // Page des régimes du client
    public function regimes()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        return view('client/regimes', ['user' => $user]);
    }

    // Page des activités du client
    public function activites()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        return view('client/activites', ['user' => $user]);
    }

    // Page du portefeuille
    public function wallet()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        return view('client/wallet', ['user' => $user]);
    }

    // Afficher la liste des clients (admin)
    public function index()
    {
        $clients = $this->userModel
            ->where('role', 'client')
            ->findAll();

        return view('admin/clients/index', ['clients' => $clients]);
    }

    // Afficher les détails d'un client (admin)
    public function view($id)
    {
        $client = $this->userModel->find($id);

        if (!$client || $client['role'] !== 'client') {
            return redirect()->to('/admin/clients')->with('error', 'Client non trouvé');
        }

        return view('admin/clients/view', ['client' => $client]);
    }

    // Supprimer un client (admin)
    public function delete($id)
    {
        $client = $this->userModel->find($id);

        if (!$client || $client['role'] !== 'client') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Client non trouvé'
            ]);
        }

        $this->userModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Client supprimé avec succès'
        ]);
    }
}
