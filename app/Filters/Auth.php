<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Vérifier que l'utilisateur a accès à la route en fonction de son rôle
        $uri = $request->getUri()->getPath();
        $role = $session->get('role');

        // Les administrateurs peuvent accéder aux routes /admin
        if (strpos($uri, '/admin') === 0 && $role !== 'admin') {
            return redirect()->to('/client');
        }

        // Les clients ne peuvent accéder qu'aux routes /client
        if (strpos($uri, '/client') === 0 && $role === 'admin') {
            return redirect()->to('/admin');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien après
    }
}