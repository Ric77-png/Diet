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

    // Afficher la liste des clients
    public function index()
    {
        $clients = $this->userModel
            ->where('role', 'client')
            ->findAll();

        return view('admin/clients/index', ['clients' => $clients]);
    }

    // Afficher les détails d'un client
    public function view($id)
    {
        $client = $this->userModel->find($id);

        if (!$client || $client['role'] !== 'client') {
            return redirect()->to('/admin/clients')->with('error', 'Client non trouvé');
        }

        return view('admin/clients/view', ['client' => $client]);
    }

    // Supprimer un client
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
