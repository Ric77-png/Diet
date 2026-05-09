<?php

namespace App\Controllers;

use App\Models\ActiviteModel;

class ActiviteController extends BaseController
{
    protected $activiteModel;
    protected $session;

    public function __construct()
    {
        $this->activiteModel = new ActiviteModel();
        $this->session = \Config\Services::session();
    }

    private function isAdmin()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return false;
        }
        return true;
    }

    // LISTE des activités
    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $data['activites'] = $this->activiteModel->findAll();
        return view('admin/activites/index', $data);
    }

    // FORMULAIRE AJOUT
    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        return view('admin/activites/create');
    }

    // ENREGISTRER une activité
    public function store()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $rules = [
            'nom'               => 'required|min_length[3]',
            'duree_minutes'     => 'required|integer|greater_than[0]|less_than[480]',
            'calories_par_heure'=> 'required|integer|greater_than[0]|less_than[2000]',
            'difficulte'        => 'required|in_list[facile,moyen,difficile]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->activiteModel->insert([
            'nom'                => $this->request->getPost('nom'),
            'duree_minutes'      => $this->request->getPost('duree_minutes'),
            'calories_par_heure' => $this->request->getPost('calories_par_heure'),
            'difficulte'         => $this->request->getPost('difficulte')
        ]);

        session()->setFlashdata('success', 'Activité ajoutée avec succès');
        return redirect()->to('/admin/activites');
    }

    // FORMULAIRE MODIFICATION
    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $data['activite'] = $this->activiteModel->find($id);
        
        if (!$data['activite']) {
            session()->setFlashdata('error', 'Activité non trouvée');
            return redirect()->to('/admin/activites');
        }

        return view('admin/activites/edit', $data);
    }

    // METTRE À JOUR une activité
    public function update($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $rules = [
            'nom'               => 'required|min_length[3]',
            'duree_minutes'     => 'required|integer|greater_than[0]|less_than[480]',
            'calories_par_heure'=> 'required|integer|greater_than[0]|less_than[2000]',
            'difficulte'        => 'required|in_list[facile,moyen,difficile]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->activiteModel->update($id, [
            'nom'                => $this->request->getPost('nom'),
            'duree_minutes'      => $this->request->getPost('duree_minutes'),
            'calories_par_heure' => $this->request->getPost('calories_par_heure'),
            'difficulte'         => $this->request->getPost('difficulte')
        ]);

        session()->setFlashdata('success', 'Activité modifiée avec succès');
        return redirect()->to('/admin/activites');
    }

    // SUPPRIMER une activité (AJAX)
    public function delete($id)
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $activite = $this->activiteModel->find($id);
        
        if (!$activite) {
            return $this->response->setJSON(['success' => false, 'message' => 'Activité non trouvée']);
        }

        $this->activiteModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Activité supprimée']);
    }
}