<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GoldCodeModel;
use App\Models\ParametreModel;

class GoldController extends BaseController
{
    protected $userModel;
    protected $goldCodeModel;
    protected $parametreModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->goldCodeModel = new GoldCodeModel();
        $this->parametreModel = new ParametreModel();
        $this->session = \Config\Services::session();
    }

    private function isLoggedIn()
    {
        if (!$this->session->get('isLoggedIn')) {
            return false;
        }
        return true;
    }

    // Afficher la page d'abonnement Gold
    public function subscribe()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('userId');
        $user = $this->userModel->find($userId);
        
        // Récupérer les paramètres
        $prixGold = $this->parametreModel->where('cle', 'prix_gold')->first();
        $reductionGold = $this->parametreModel->where('cle', 'reduction_gold_pourcent')->first();

        $data = [
            'user' => $user,
            'prix_gold' => $prixGold ? $prixGold['valeur'] : 49.99,
            'reduction_gold' => $reductionGold ? $reductionGold['valeur'] : 15
        ];

        return view('client/gold/subscribe', $data);
    }

    // Acheter l'abonnement Gold avec le portefeuille
    public function purchase()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        $userId = $this->session->get('userId');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur non trouvé']);
        }

        // Vérifier si l'utilisateur a déjà Gold
        if ($user['is_gold']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vous avez déjà l\'abonnement Gold']);
        }

        // Récupérer le prix
        $prixGold = $this->parametreModel->where('cle', 'prix_gold')->first();
        $prix = $prixGold ? (float) $prixGold['valeur'] : 49.99;

        // Vérifier le solde du portefeuille
        if ($user['wallet_balance'] < $prix) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Solde insuffisant. Il vous manque ' . number_format($prix - $user['wallet_balance'], 2) . ' €'
            ]);
        }

        // Déduire du portefeuille
        $nouveauSolde = $user['wallet_balance'] - $prix;

        // Activer Gold
        $this->userModel->update($userId, [
            'is_gold' => true,
            'gold_purchased_at' => date('Y-m-d H:i:s'),
            'wallet_balance' => $nouveauSolde
        ]);

        // Mettre à jour la session
        $this->session->set('is_gold', true);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Félicitations ! Vous êtes maintenant membre Gold',
            'nouveau_solde' => $nouveauSolde
        ]);
    }

    // Activer Gold avec un code (AJAX)
    public function validateCode()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        $code = $this->request->getPost('code');
        $userId = $this->session->get('userId');

        if (empty($code)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code vide']);
        }

        // Vérifier si le code existe
        $goldCode = $this->goldCodeModel->where('code', $code)->first();

        if (!$goldCode) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code Gold invalide']);
        }

        // Vérifier si le code a déjà été utilisé
        if ($goldCode['utilise'] == 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ce code Gold a déjà été utilisé']);
        }

        // Récupérer l'utilisateur
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur non trouvé']);
        }

        // Vérifier si l'utilisateur a déjà Gold
        if ($user['is_gold']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Vous avez déjà l\'abonnement Gold']);
        }

        // Activer Gold
        $this->userModel->update($userId, [
            'is_gold' => true,
            'gold_purchased_at' => date('Y-m-d H:i:s')
        ]);

        // Marquer le code comme utilisé
        $this->goldCodeModel->update($goldCode['id'], [
            'utilise' => 1,
            'utilisateur_id' => $userId
        ]);

        // Mettre à jour la session
        $this->session->set('is_gold', true);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Code validé ! Vous êtes maintenant membre Gold pour ' . $goldCode['duree_jours'] . ' jours'
        ]);
    }

    // ========== MÉTHODES ADMIN ==========

    // Afficher la page de gestion des codes Gold (ADMIN)
    public function manageCodes()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/client');
        }

        // Récupérer tous les codes
        $codes = $this->goldCodeModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Compter les codes utilisés/inutilisés
        $utilisés = $this->goldCodeModel->where('utilise', true)->countAllResults();
        $inutilisés = $this->goldCodeModel->where('utilise', false)->countAllResults();

        return view('admin/gold/codes', [
            'codes' => $codes,
            'userModel' => $this->userModel,
            'total' => count($codes),
            'utilisés' => $utilisés,
            'inutilisés' => $inutilisés
        ]);
    }

    // Générer un nouveau code Gold (AJAX)
    public function generateCode()
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Accès refusé']);
        }

        $duree = $this->request->getPost('duree_jours') ?: 30;
        $quantite = (int) $this->request->getPost('quantite') ?: 1;

        if ($quantite < 1 || $quantite > 100) {
            return $this->response->setJSON(['success' => false, 'message' => 'Quantité invalide']);
        }

        $codesCreés = [];

        for ($i = 0; $i < $quantite; $i++) {
            // Générer un code aléatoire unique
            $code = $this->generateUniqueCode();

            $this->goldCodeModel->insert([
                'code' => $code,
                'duree_jours' => $duree,
                'utilise' => false
            ]);

            $codesCreés[] = $code;
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $quantite . ' code(s) Gold créé(s) avec succès',
            'codes' => $codesCreés
        ]);
    }

    // Générer un code aléatoire unique
    private function generateUniqueCode()
    {
        do {
            // Format : GOLD + 4 chiffres aléatoires + 4 lettres
            $code = 'GOLD' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        } while ($this->goldCodeModel->where('code', $code)->first());

        return $code;
    }

    // Supprimer un code Gold (AJAX)
    public function deleteCode()
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Accès refusé']);
        }

        $codeId = $this->request->getPost('id');

        if (!$codeId) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID invalide']);
        }

        $code = $this->goldCodeModel->find($codeId);

        if (!$code) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code non trouvé']);
        }

        if ($code['utilise']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Impossible de supprimer un code déjà utilisé']);
        }

        $this->goldCodeModel->delete($codeId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Code Gold supprimé'
        ]);
    }

    // Attribuer un code à un client spécifique (optionnel)
    public function assignToClient()
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Accès refusé']);
        }

        $codeId = $this->request->getPost('code_id');
        $clientId = $this->request->getPost('client_id');

        if (!$codeId || !$clientId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Paramètres invalides']);
        }

        $code = $this->goldCodeModel->find($codeId);
        $client = $this->userModel->find($clientId);

        if (!$code || !$client) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code ou client non trouvé']);
        }

        if ($code['utilise']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code déjà utilisé']);
        }

        // Attribuer directement au client
        $this->userModel->update($clientId, [
            'is_gold' => true,
            'gold_purchased_at' => date('Y-m-d H:i:s')
        ]);

        // Marquer le code comme utilisé
        $this->goldCodeModel->update($codeId, [
            'utilise' => true,
            'utilisateur_id' => $clientId
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Code attribué au client avec succès'
        ]);
    }

    // Vérifier si l'utilisateur est admin
    private function isAdmin()
    {
        return $this->session->get('role') === 'admin';
    }
}

