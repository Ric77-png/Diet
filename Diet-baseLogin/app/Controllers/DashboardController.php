<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data['user'] = [
            'nom'   => $this->session->get('nom'),
            'email' => $this->session->get('email')
        ];

        return view('dashboard/index', $data);
    }
}