<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WalletCodeModel;

class WalletController extends BaseController
{
    protected $userModel;
    protected $walletCodeModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->walletCodeModel = new WalletCodeModel();
        $this->session = \Config\Services::session();
    }

    private function isLoggedIn()
    {
        if (!$this->session->get('isLoggedIn')) {
            return false;
        }
        return true;
    }

    // Valider un code (AJAX)
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
        $walletCode = $this->walletCodeModel->where('code', $code)->first();

        if (!$walletCode) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code invalide']);
        }

        // Vérifier si le code a déjà été utilisé
        if ($walletCode['utilise'] == 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ce code a déjà été utilisé']);
        }

        // Récupérer l'utilisateur
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur non trouvé']);
        }

        // Ajouter le montant au wallet
        $nouveauSolde = $user['wallet_balance'] + $walletCode['montant'];

        $this->userModel->update($userId, [
            'wallet_balance' => $nouveauSolde
        ]);

        // Marquer le code comme utilisé
        $this->walletCodeModel->update($walletCode['id'], [
            'utilise' => 1,
            'utilisateur_id' => $userId
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Code validé ! ' . $walletCode['montant'] . ' € ajoutés à votre porte-monnaie',
            'nouveau_solde' => $nouveauSolde
        ]);
    }

    // Récupérer le solde actuel (AJAX)
    public function getBalance()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        $userId = $this->session->get('userId');
        $user = $this->userModel->find($userId);

        return $this->response->setJSON([
            'success' => true,
            'solde' => $user['wallet_balance']
        ]);
    }

    // Recharger le wallet (ajout fantôme)
    public function recharge()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        $montant = (float) $this->request->getPost('montant');
        $userId = $this->session->get('userId');

        if ($montant <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Montant invalide']);
        }

        $user = $this->userModel->find($userId);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur non trouvé']);
        }

        // Ajouter l'argent au wallet (paiement fantôme)
        $nouveauSolde = $user['wallet_balance'] + $montant;
        
        $this->userModel->update($userId, [
            'wallet_balance' => $nouveauSolde
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Recharge de ' . number_format($montant, 2) . ' € effectuée',
            'nouveau_solde' => $nouveauSolde
        ]);
    }

    // Acheter un abonnement Gold (créer une demande)
    public function buyGold()
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

        // Récupérer le prix du Gold
        $parametreModel = new \App\Models\ParametreModel();
        $prixGold = $parametreModel->where('cle', 'prix_gold')->first();
        $prix = $prixGold ? (float) $prixGold['valeur'] : 49.99;

        // Vérifier le solde
        if ($user['wallet_balance'] < $prix) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Solde insuffisant. Il vous manque ' . number_format($prix - $user['wallet_balance'], 2) . ' €'
            ]);
        }

        // Créer une demande d'achat
        $goldPurchaseModel = new \App\Models\GoldPurchaseModel();
        
        $goldPurchaseModel->insert([
            'user_id' => $userId,
            'montant' => $prix,
            'statut' => 'en_attente'
        ]);

        // Déduire du wallet
        $nouveauSolde = $user['wallet_balance'] - $prix;
        $this->userModel->update($userId, [
            'wallet_balance' => $nouveauSolde
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Demande d\'achat Gold créée. L\'administrateur vous enverra un code d\'activation par email.'
        ]);
    }
}