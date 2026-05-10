<?php

namespace App\Controllers;

use App\Models\ParametreModel;

class ParametreController extends BaseController
{
    protected $parametreModel;
    protected $session;

    public function __construct()
    {
        $this->parametreModel = new ParametreModel();
        $this->session = \Config\Services::session();
    }

    private function isAdmin()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return false;
        }
        return true;
    }

    // LISTE des paramètres
    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $data['parametres'] = $this->parametreModel->findAll();
        return view('admin/parametres/index', $data);
    }

    // METTRE À JOUR un paramètre
    public function update($cle)
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $valeur = $this->request->getPost('valeur');
        
        $this->parametreModel->where('cle', $cle)->set(['valeur' => $valeur])->update();

        session()->setFlashdata('success', 'Paramètre "' . $cle . '" mis à jour');
        return redirect()->to('/admin/parametres');
    }
}