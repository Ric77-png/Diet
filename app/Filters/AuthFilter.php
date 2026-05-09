<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Exécuté avant la route (Do the before filtering)
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter d\'abord');
        }
    }

    /**
     * Exécuté après la route
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Aucune action spécifique après
    }
}