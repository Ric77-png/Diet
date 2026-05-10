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

        // Créer une demande d'achat Gold (statut en attente)
        $goldPurchaseModel = new \App\Models\GoldPurchaseModel();
        $purchaseId = $goldPurchaseModel->insert([
            'user_id' => $userId,
            'montant' => $prix,
            'statut' => 'en_attente'
        ]);

        // Créer une notification pour l'admin
        $notificationModel = new \App\Models\NotificationModel();
        $admins = $this->userModel->where('role', 'admin')->findAll();
        
        foreach ($admins as $admin) {
            $notificationModel->createNotification(
                $admin['id'],
                'Nouveau paiement Gold en attente',
                $user['nom'] . ' a payé ' . number_format($prix, 2, ',', ' ') . ' € pour l\'abonnement Gold',
                'warning',
                ['user_id' => $userId, 'purchase_id' => $purchaseId]
            );
        }

        // Déduire du portefeuille immédiatement
        $nouveauSolde = $user['wallet_balance'] - $prix;
        $this->userModel->update($userId, [
            'wallet_balance' => $nouveauSolde
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Paiement reçu ! En attente de validation par l\'administrateur',
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

    // Afficher les achats Gold en attente (ADMIN)
    public function managePurchases()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/client');
        }

        $goldPurchaseModel = new \App\Models\GoldPurchaseModel();
        
        // Récupérer les achats en attente
        $purchases = $goldPurchaseModel
            ->where('statut', 'en_attente')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Enrichir avec les données utilisateur
        foreach ($purchases as &$purchase) {
            $purchase['user'] = $this->userModel->find($purchase['user_id']);
        }

        // Statistiques
        $en_attente = $goldPurchaseModel->where('statut', 'en_attente')->countAllResults();
        $montant_total = $goldPurchaseModel
            ->where('statut', 'en_attente')
            ->selectSum('montant')
            ->get()
            ->getRow();
        
        $codes_assignes = $goldPurchaseModel->where('statut', 'approuve')->countAllResults();

        // Codes disponibles
        $available_codes = $this->goldCodeModel
            ->where('utilise', false)
            ->findAll();

        return view('admin/gold_purchases', [
            'purchases' => $purchases,
            'en_attente' => $en_attente,
            'montant_total' => $montant_total ? $montant_total->montant : 0,
            'codes_assignes' => $codes_assignes,
            'available_codes' => $available_codes
        ]);
    }

    // Assigner un code à un achat et approuver (ADMIN - AJAX)
    public function assignCodeToPurchase()
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Accès refusé']);
        }

        $purchaseId = $this->request->getPost('purchase_id');
        $codeGoldId = $this->request->getPost('code_gold_id');

        if (!$purchaseId || !$codeGoldId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Paramètres invalides']);
        }

        $goldPurchaseModel = new \App\Models\GoldPurchaseModel();
        $purchase = $goldPurchaseModel->find($purchaseId);
        $code = $this->goldCodeModel->find($codeGoldId);

        if (!$purchase || !$code) {
            return $this->response->setJSON(['success' => false, 'message' => 'Achat ou code non trouvé']);
        }

        if ($purchase['statut'] !== 'en_attente') {
            return $this->response->setJSON(['success' => false, 'message' => 'Cet achat a déjà été traité']);
        }

        if ($code['utilise']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ce code a déjà été utilisé']);
        }

        // Mettre à jour l'achat
        $goldPurchaseModel->update($purchaseId, [
            'statut' => 'approuve',
            'code_gold_id' => $codeGoldId
        ]);

        // Marquer le code comme utilisé
        $this->goldCodeModel->update($codeGoldId, [
            'utilise' => true,
            'utilisateur_id' => $purchase['user_id']
        ]);

        // TODO: Envoyer un email au client avec le code

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Code assigné et achat approuvé'
        ]);
    }

    // Vérifier si l'utilisateur est admin
    private function isAdmin()
    {
        return $this->session->get('role') === 'admin';
    }

    // Afficher les codes Gold et les achats en attente (dashboard admin)
    public function codesAndPurchases()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/client');
        }

        $goldPurchaseModel = new \App\Models\GoldPurchaseModel();
        
        // Récupérer tous les codes Gold avec info utilisateur
        $codes = $this->goldCodeModel->findAll();
        foreach ($codes as &$code) {
            if ($code['utilisateur_id']) {
                $code['user'] = $this->userModel->find($code['utilisateur_id']);
            }
        }

        // Récupérer les achats en attente
        $purchasesAttente = $goldPurchaseModel
            ->where('statut', 'en_attente')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($purchasesAttente as &$purchase) {
            $purchase['user'] = $this->userModel->find($purchase['user_id']);
        }

        // Récupérer les achats approuvés
        $purchasesApprouves = $goldPurchaseModel
            ->where('statut', 'approuve')
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        foreach ($purchasesApprouves as &$purchase) {
            $purchase['user'] = $this->userModel->find($purchase['user_id']);
            if ($purchase['code_gold_id']) {
                $purchase['code'] = $this->goldCodeModel->find($purchase['code_gold_id']);
            }
        }

        // Statistiques
        $stats = [
            'codes_total' => count($codes),
            'codes_utilises' => count(array_filter($codes, fn($c) => $c['utilise'])),
            'codes_disponibles' => count(array_filter($codes, fn($c) => !$c['utilise'])),
            'achats_en_attente' => count($purchasesAttente),
            'achats_approuves' => count($purchasesApprouves),
        ];

        return view('admin/gold_codes_and_purchases', [
            'codes' => $codes,
            'purchasesAttente' => $purchasesAttente,
            'purchasesApprouves' => $purchasesApprouves,
            'stats' => $stats
        ]);
    }

    // Envoyer un code Gold au client (crée une notification)
    public function sendCodeToClient()
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Accès refusé']);
        }

        $purchaseId = $this->request->getPost('purchase_id');
        $codeId = $this->request->getPost('code_id');

        if (!$purchaseId || !$codeId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Données manquantes']);
        }

        $goldPurchaseModel = new \App\Models\GoldPurchaseModel();
        $notificationModel = new \App\Models\NotificationModel();

        // Vérifier que la demande d'achat existe
        $purchase = $goldPurchaseModel->find($purchaseId);
        if (!$purchase) {
            return $this->response->setJSON(['success' => false, 'message' => 'Demande non trouvée']);
        }

        // Vérifier que le code existe
        $code = $this->goldCodeModel->find($codeId);
        if (!$code) {
            return $this->response->setJSON(['success' => false, 'message' => 'Code non trouvé']);
        }

        // Vérifier que le code n'est pas déjà utilisé
        if ($code['utilise']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ce code a déjà été utilisé']);
        }

        // Récupérer le client
        $client = $this->userModel->find($purchase['user_id']);

        // Marquer le code comme utilisé et l'assigner au client
        $this->goldCodeModel->update($codeId, [
            'utilise' => 1,
            'utilisateur_id' => $purchase['user_id']
        ]);

        // Activer Gold pour le client
        $this->userModel->update($purchase['user_id'], [
            'is_gold' => 1,
            'gold_purchased_at' => date('Y-m-d H:i:s')
        ]);

        // Mettre à jour la demande d'achat
        $goldPurchaseModel->update($purchaseId, [
            'statut' => 'approuve',
            'code_gold_id' => $codeId
        ]);

        // Créer une notification pour le client
        $notificationModel->createNotification(
            $purchase['user_id'],
            'Code Gold reçu !',
            'Votre demande Gold a été approuvée. Voici votre code: ' . $code['code'] . ' (' . $code['duree_jours'] . ' jours)',
            'success',
            ['code' => $code['code'], 'duree_jours' => $code['duree_jours']]
        );

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Code envoyé au client ' . $client['nom']
        ]);
    }
}

