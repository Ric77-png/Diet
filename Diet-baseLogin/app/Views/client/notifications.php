<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notifications</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            font-size: 20px;
            font-weight: 700;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.2);
        }

        .logout-btn { 
            background: #dc3545;
        }

        .logout-btn:hover { 
            background: #c82333;
        }
        
        .container { 
            max-width: 800px; 
            margin: 30px auto; 
            padding: 0 20px; 
        }

        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
            color: #667eea;
            font-size: 32px;
        }

        .notification-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 5px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.3s;
        }

        .notification-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .notification-card.unread {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-left-color: #667eea;
        }

        .notification-card.read {
            opacity: 0.8;
            border-left-color: #ccc;
        }

        .notification-card.success {
            border-left-color: #28a745;
        }

        .notification-card.warning {
            border-left-color: #ffc107;
        }

        .notification-card.error {
            border-left-color: #dc3545;
        }

        .notification-card.info {
            border-left-color: #17a2b8;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-badge {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: #667eea;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .notification-badge.read {
            display: none;
        }

        .notification-message {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .notification-meta {
            font-size: 12px;
            color: #999;
            display: flex;
            gap: 15px;
        }

        .notification-time {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
            margin-left: 20px;
        }

        .btn-small {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-mark-read {
            background: #667eea;
            color: white;
        }

        .btn-mark-read:hover {
            background: #5568d3;
        }

        .btn-copy {
            background: #28a745;
            color: white;
        }

        .btn-copy:hover {
            background: #218838;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .empty-state i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            color: #999;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #bbb;
            font-size: 14px;
        }

        .notification-code {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: monospace;
            font-weight: bold;
            word-break: break-all;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .navbar a {
                margin-left: 0;
            }

            .notification-actions {
                flex-direction: column;
                gap: 5px;
                margin-left: 0;
                margin-top: 10px;
            }

            .notification-card {
                flex-direction: column;
            }

            .page-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Diet App</h1>
        <div>
            <a href="/client">Mon compte</a>
            <a href="/client/notifications">Notifications</a>
            <a href="/gold/subscribe">Option Gold</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <div class="page-title">
            <i class="fas fa-bell"></i>
            Mes Notifications
        </div>

        <?php if (count($notifications) > 0): ?>
            <div>
                <?php foreach ($notifications as $notif): ?>
                    <div class="notification-card <?= $notif['type'] ?> <?= $notif['lu'] ? 'read' : 'unread' ?>" data-id="<?= $notif['id'] ?>">
                        <div class="notification-content">
                            <div class="notification-title">
                                <?php if (!$notif['lu']): ?>
                                    <span class="notification-badge"></span>
                                <?php endif; ?>
                                <?= esc($notif['titre']) ?>
                            </div>
                            <div class="notification-message">
                                <?= esc($notif['message']) ?>

                                <?php 
                                    $data = $notif['data_json'] ? json_decode($notif['data_json'], true) : null;
                                    if ($data && isset($data['code'])): 
                                ?>
                                    <div style="margin-top: 10px;">
                                        <strong>Votre code:</strong>
                                        <div class="notification-code" id="code-<?= $notif['id'] ?>">
                                            <?= esc($data['code']) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="notification-meta">
                                <span class="notification-time">
                                    <i class="fas fa-clock"></i>
                                    <?= date('d/m/Y H:i', strtotime($notif['created_at'])) ?>
                                </span>
                            </div>
                        </div>

                        <div class="notification-actions">
                            <?php if (!$notif['lu']): ?>
                                <button class="btn-small btn-mark-read" onclick="markAsRead(<?= $notif['id'] ?>)">
                                    <i class="fas fa-check"></i> Lire
                                </button>
                            <?php endif; ?>

                            <?php if (isset($data['code'])) : ?>
                                <button class="btn-small btn-copy" onclick="copyCode('code-<?= $notif['id'] ?>')">
                                    <i class="fas fa-copy"></i> Copier
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h2>Aucune notification</h2>
                <p>Vous n'avez pas encore reçu de notifications</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function markAsRead(id) {
            $.ajax({
                url: '/notifications/mark-as-read/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('[data-id="' + id + '"]').removeClass('unread').addClass('read');
                        $('[data-id="' + id + '"] .notification-badge').remove();
                        $('[data-id="' + id + '"] .btn-mark-read').remove();
                    }
                }
            });
        }

        function copyCode(elementId) {
            const codeElement = document.getElementById(elementId);
            const code = codeElement.textContent.trim();
            
            navigator.clipboard.writeText(code).then(function() {
                alert('Code copié dans le presse-papiers !');
            });
        }
    </script>
</body>
</html>
