<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return redirect()->to('/login');
        }

        return view('admin/index');
    }
}