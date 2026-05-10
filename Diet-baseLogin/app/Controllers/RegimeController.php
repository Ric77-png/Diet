<?php

namespace App\Controllers;

use App\Models\RegimeModel;

class RegimeController extends BaseController
{
    protected $regimeModel;
    protected $session;

    public function __construct()
    {
        $this->regimeModel = new RegimeModel();
        $this->session = \Config\Services::session();
    }

    private function isAdmin()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $data['regimes'] = $this->regimeModel->findAll();
        return view('admin/regimes/index', $data);
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        return view('admin/regimes/create');
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $rules = [
            'nom'                    => 'required|min_length[3]',
            'pourcentage_viande'     => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_poisson'    => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_volaille'   => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'effet_poids_par_semaine'=> 'required|decimal',
            'prix_par_jour'          => 'required|decimal|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Vérifier que les pourcentages totalisent 100%
        $total = $this->request->getPost('pourcentage_viande') +
                 $this->request->getPost('pourcentage_poisson') +
                 $this->request->getPost('pourcentage_volaille');

        if ($total != 100) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%');
        }

        $this->regimeModel->insert([
            'nom'                      => $this->request->getPost('nom'),
            'description'              => $this->request->getPost('description'),
            'pourcentage_viande'       => $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson'      => $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille'     => $this->request->getPost('pourcentage_volaille'),
            'effet_poids_par_semaine'  => $this->request->getPost('effet_poids_par_semaine'),
            'prix_par_jour'            => $this->request->getPost('prix_par_jour')
        ]);

        session()->setFlashdata('success', 'Régime ajouté avec succès');
        return redirect()->to('/admin/regimes');
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $data['regime'] = $this->regimeModel->find($id);
        
        if (!$data['regime']) {
            session()->setFlashdata('error', 'Régime non trouvé');
            return redirect()->to('/admin/regimes');
        }

        return view('admin/regimes/edit', $data);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $rules = [
            'nom'                    => 'required|min_length[3]',
            'pourcentage_viande'     => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_poisson'    => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'pourcentage_volaille'   => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'effet_poids_par_semaine'=> 'required|decimal',
            'prix_par_jour'          => 'required|decimal|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $total = $this->request->getPost('pourcentage_viande') +
                 $this->request->getPost('pourcentage_poisson') +
                 $this->request->getPost('pourcentage_volaille');

        if ($total != 100) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%');
        }

        $this->regimeModel->update($id, [
            'nom'                      => $this->request->getPost('nom'),
            'description'              => $this->request->getPost('description'),
            'pourcentage_viande'       => $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson'      => $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille'     => $this->request->getPost('pourcentage_volaille'),
            'effet_poids_par_semaine'  => $this->request->getPost('effet_poids_par_semaine'),
            'prix_par_jour'            => $this->request->getPost('prix_par_jour')
        ]);

        session()->setFlashdata('success', 'Régime modifié avec succès');
        return redirect()->to('/admin/regimes');
    }

    // SUPPRIMER un régime (AJAX)
    public function delete($id)
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $regime = $this->regimeModel->find($id);
        
        if (!$regime) {
            return $this->response->setJSON(['success' => false, 'message' => 'Régime non trouvé']);
        }

        $this->regimeModel->delete($id);
        return $this->response->setJSON(['success' => true, 'message' => 'Régime supprimé']);
    }
}