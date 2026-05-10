<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'titre',
        'message',
        'type',
        'lu',
        'data_json'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Marquer une notification comme lue
    public function markAsRead($id)
    {
        return $this->update($id, ['lu' => 1]);
    }

    // Obtenir les notifications non lues d'un utilisateur
    public function getUnread($userId)
    {
        return $this->where('user_id', $userId)
            ->where('lu', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // Créer une notification
    public function createNotification($userId, $titre, $message, $type = 'info', $data = null)
    {
        return $this->insert([
            'user_id'   => $userId,
            'titre'     => $titre,
            'message'   => $message,
            'type'      => $type,
            'lu'        => 0,
            'data_json' => $data ? json_encode($data) : null,
        ]);
    }
}
