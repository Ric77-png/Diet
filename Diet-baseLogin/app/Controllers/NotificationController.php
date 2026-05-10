<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;
    protected $session;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->session = \Config\Services::session();
    }

    // Afficher les notifications du client
    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('userId');
        
        // Récupérer toutes les notifications
        $notifications = $this->notificationModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('client/notifications', [
            'notifications' => $notifications
        ]);
    }

    // Marquer une notification comme lue (AJAX)
    public function markAsRead($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non connecté']);
        }

        $userId = $this->session->get('userId');
        $notif = $this->notificationModel->find($id);

        // Vérifier que la notification appartient à l'utilisateur
        if (!$notif || $notif['user_id'] != $userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Notification non trouvée']);
        }

        $this->notificationModel->markAsRead($id);

        return $this->response->setJSON(['success' => true]);
    }

    // Obtenir le nombre de notifications non lues (AJAX)
    public function getUnreadCount()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $userId = $this->session->get('userId');
        $count = $this->notificationModel
            ->where('user_id', $userId)
            ->where('lu', 0)
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }
}
