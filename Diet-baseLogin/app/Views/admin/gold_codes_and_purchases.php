<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codes Gold et Achats</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        
        .navbar {
            background: #343a40;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .navbar a:hover {
            background: rgba(255,255,255,0.1);
        }
        .logout-btn { background: #dc3545; }
        .logout-btn:hover { background: #c82333; }
        
        .container { 
            max-width: 1400px; 
            margin: 30px auto; 
            padding: 0 20px; 
        }
        
        .page-title {
            font-size: 32px;
            color: #333;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
            color: #d4af37;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 5px solid #d4af37;
        }

        .stat-card h3 {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }

        .stat-card.pending {
            border-left-color: #ffc107;
        }

        .stat-card.approved {
            border-left-color: #28a745;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #d4af37;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #d4af37;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f8f9fa;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        .code-badge {
            background: #d4af37;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-family: monospace;
            font-size: 12px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-align: center;
            min-width: 100px;
        }

        .status-used {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-available {
            background: #e8f5e9;
            color: #388e3c;
        }

        .status-pending {
            background: #fff3e0;
            color: #f57c00;
        }

        .status-approved {
            background: #e8f5e9;
            color: #388e3c;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-email {
            font-size: 12px;
            color: #666;
        }

        .date-small {
            font-size: 12px;
            color: #666;
        }

        .badge-icon {
            margin-right: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            table th, table td {
                padding: 8px;
            }

            .page-title {
                font-size: 24px;
            }

            .section-title {
                font-size: 16px;
            }

            .stat-card .value {
                font-size: 28px;
            }
        }

        .form-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            background: white;
        }

        .form-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Diet Admin</h1>
        <div>
            <a href="/admin">Tableau de bord</a>
            <a href="/admin/gold">Codes Gold</a>
            <a href="/admin/gold-purchases">Achats Gold</a>
            <a href="/admin/gold/codes-and-purchases">Codes et Achats</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <div class="page-title">
            <i class="fas fa-crown"></i>
            Codes Gold et Achats en Attente
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Codes Totaux</h3>
                <div class="value"><?= $stats['codes_total'] ?></div>
            </div>
            <div class="stat-card approved">
                <h3>Codes Disponibles</h3>
                <div class="value"><?= $stats['codes_disponibles'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Codes Utilisés</h3>
                <div class="value"><?= $stats['codes_utilises'] ?></div>
            </div>
            <div class="stat-card pending">
                <h3>Achats en Attente</h3>
                <div class="value"><?= $stats['achats_en_attente'] ?></div>
            </div>
            <div class="stat-card approved">
                <h3>Achats Approuvés</h3>
                <div class="value"><?= $stats['achats_approuves'] ?></div>
            </div>
        </div>

        <!-- Section: Achats en Attente (Notifications) -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-bell"></i>
                Notifications - Clients Attendent Leurs Codes
            </div>

            <?php if (count($purchasesAttente) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Montant</th>
                            <th>Date de Demande</th>
                            <th>Statut</th>
                            <th>Code à Envoyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchasesAttente as $purchase): ?>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <span class="user-name"><?= esc($purchase['user']['nom']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-email"><?= esc($purchase['user']['email']) ?></span>
                                </td>
                                <td>
                                    <strong><?= number_format($purchase['montant'], 2, ',', ' ') ?> €</strong>
                                </td>
                                <td>
                                    <span class="date-small"><?= date('d/m/Y H:i', strtotime($purchase['created_at'])) ?></span>
                                </td>
                                <td>
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-badge-icon fa-hourglass-half"></i>
                                        En Attente
                                    </span>
                                </td>
                                <td>
                                    <select class="form-select code-select" data-purchase-id="<?= $purchase['id'] ?>">
                                        <option value="">-- Sélectionner un code --</option>
                                        <?php 
                                        $availableCodes = array_filter($codes, fn($c) => !$c['utilise']);
                                        foreach ($availableCodes as $code): 
                                        ?>
                                            <option value="<?= $code['id'] ?>"><?= esc($code['code']) ?> (<?= $code['duree_jours'] ?> jours)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-success send-code-btn" data-purchase-id="<?= $purchase['id'] ?>">
                                        <i class="fas fa-paper-plane"></i> Envoyer
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <p>Aucun client en attente de code Gold</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Section: Achats Approuvés -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-check-circle"></i>
                Achats Approuvés avec Code Assigné
            </div>

            <?php if (count($purchasesApprouves) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Montant</th>
                            <th>Code Assigné</th>
                            <th>Durée</th>
                            <th>Date d'Approbation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchasesApprouves as $purchase): ?>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <span class="user-name"><?= esc($purchase['user']['nom']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-email"><?= esc($purchase['user']['email']) ?></span>
                                </td>
                                <td>
                                    <strong><?= number_format($purchase['montant'], 2, ',', ' ') ?> €</strong>
                                </td>
                                <td>
                                    <?php if (isset($purchase['code']) && $purchase['code']): ?>
                                        <span class="code-badge"><?= esc($purchase['code']['code']) ?></span>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($purchase['code']) && $purchase['code']): ?>
                                        <strong><?= $purchase['code']['duree_jours'] ?> jours</strong>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="date-small"><?= date('d/m/Y H:i', strtotime($purchase['updated_at'])) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Aucun achat approuvé</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Section: Codes Gold -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-key"></i>
                Tous les Codes Gold
            </div>

            <?php if (count($codes) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Durée</th>
                            <th>Statut</th>
                            <th>Utilisé Par</th>
                            <th>Email</th>
                            <th>Date d'Utilisation</th>
                            <th>Créé le</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($codes as $code): ?>
                            <tr>
                                <td>
                                    <span class="code-badge"><?= esc($code['code']) ?></span>
                                </td>
                                <td>
                                    <strong><?= $code['duree_jours'] ?> jours</strong>
                                </td>
                                <td>
                                    <?php if ($code['utilise']): ?>
                                        <span class="status-badge status-used">
                                            <i class="fas fa-check"></i> Utilisé
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge status-available">
                                            <i class="fas fa-check"></i> Disponible
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($code['utilise'] && isset($code['user']) && $code['user']): ?>
                                        <div class="user-info">
                                            <span class="user-name"><?= esc($code['user']['nom']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($code['utilise'] && isset($code['user']) && $code['user']): ?>
                                        <span class="user-email"><?= esc($code['user']['email']) ?></span>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($code['utilise']): ?>
                                        <span class="date-small"><?= date('d/m/Y H:i', strtotime($code['updated_at'])) ?></span>
                                    <?php else: ?>
                                        <span style="color: #999;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="date-small"><?= date('d/m/Y H:i', strtotime($code['created_at'])) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-ban"></i>
                    <p>Aucun code Gold créé</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Envoyer un code au client
        $('.send-code-btn').on('click', function() {
            const btn = $(this);
            const purchaseId = btn.data('purchase-id');
            const codeId = btn.closest('tr').find('.code-select').val();

            if (!codeId) {
                alert('Veuillez sélectionner un code à envoyer');
                return;
            }

            btn.prop('disabled', true).text('Envoi en cours...');

            $.ajax({
                url: '/admin/gold/send-code-to-client',
                type: 'POST',
                data: {
                    purchase_id: purchaseId,
                    code_id: codeId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Erreur: ' + response.message);
                        btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Envoyer');
                    }
                },
                error: function() {
                    alert('Erreur serveur');
                    btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Envoyer');
                }
            });
        });
    </script>
</body>
</html>
