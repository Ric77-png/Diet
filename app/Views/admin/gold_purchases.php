<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achats Gold en attente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f4f4f4; }
        
        .navbar {
            background: #343a40;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .logout-btn { background: #dc3545; }
        
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1, h2 { color: #333; margin-bottom: 15px; }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            color: #333;
        }
        
        .stat-box .number {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-box .label {
            font-size: 14px;
            color: #555;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table thead {
            background: #343a40;
            color: white;
        }
        
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .table tbody tr:hover {
            background: #f5f5f5;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge-attente {
            background: #ffc107;
            color: #333;
        }
        
        .badge-approuve {
            background: #28a745;
            color: white;
        }
        
        .badge-rejete {
            background: #dc3545;
            color: white;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            background: #007bff;
            color: white;
        }
        
        .btn-small:hover { background: #0056b3; }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal.active { display: flex; }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        
        .modal-close {
            float: right;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        
        .modal-close:hover { color: #333; }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .message {
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
            display: none;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>💳 Achats Gold en attente</h2>
        <div>
            <a href="/admin">Tableau de bord</a>
            <a href="/admin/gold">Gestion des codes</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <!-- Statistiques -->
        <div class="stats">
            <div class="stat-box">
                <div class="label">En attente</div>
                <div class="number"><?= $en_attente ?></div>
            </div>
            <div class="stat-box">
                <div class="label">Montant total</div>
                <div class="number"><?= number_format($montant_total, 2) ?> €</div>
            </div>
            <div class="stat-box">
                <div class="label">Codes assignés</div>
                <div class="number"><?= $codes_assignes ?></div>
            </div>
        </div>

        <!-- Liste des achats -->
        <div class="card">
            <h2>📋 Demandes d'achat</h2>

            <?php if (!empty($purchases)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Code assigné</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchases as $purchase): ?>
                            <tr>
                                <td><?= $purchase['user']['nom'] ?></td>
                                <td><?= $purchase['user']['email'] ?></td>
                                <td><?= number_format($purchase['montant'], 2) ?> €</td>
                                <td>
                                    <?php if ($purchase['statut'] == 'en_attente'): ?>
                                        <span class="badge badge-attente">⏳ En attente</span>
                                    <?php elseif ($purchase['statut'] == 'approuve'): ?>
                                        <span class="badge badge-approuve">✓ Approuvé</span>
                                    <?php else: ?>
                                        <span class="badge badge-rejete">✗ Rejeté</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($purchase['code_gold_id']): ?>
                                        <span style="color: #28a745; font-weight: bold;">✓ Assigné</span>
                                    <?php else: ?>
                                        <em style="color: #999;">-</em>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($purchase['created_at'])) ?></td>
                                <td>
                                    <?php if ($purchase['statut'] == 'en_attente'): ?>
                                        <button class="btn-small" onclick="openAssignModal(<?= $purchase['id'] ?>, '<?= $purchase['user']['email'] ?>')">
                                            Assigner un code
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>✓ Aucune demande en attente</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal d'assignation -->
    <div id="assignModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeAssignModal()">&times;</span>
            <h2>Assigner un code Gold</h2>
            
            <div class="form-group">
                <label>Email du client :</label>
                <input type="text" id="clientEmail" disabled>
            </div>

            <div class="form-group">
                <label>Sélectionnez un code disponible :</label>
                <select id="codeSelect">
                    <option value="">-- Choisir un code --</option>
                    <?php foreach ($available_codes as $code): ?>
                        <option value="<?= $code['id'] ?>">
                            <?= $code['code'] ?> (<?= $code['duree_jours'] ?> jours)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="btn-small" style="width: 100%; background: #28a745;" onclick="assignCode()">
                Assigner et approuver
            </button>
            
            <div id="assignMessage" class="message"></div>
        </div>
    </div>

    <script>
        let currentPurchaseId = null;

        function openAssignModal(purchaseId, email) {
            currentPurchaseId = purchaseId;
            $('#clientEmail').val(email);
            $('#codeSelect').val('');
            $('#assignMessage').hide();
            $('#assignModal').addClass('active');
        }

        function closeAssignModal() {
            $('#assignModal').removeClass('active');
            currentPurchaseId = null;
        }

        function assignCode() {
            const codeId = $('#codeSelect').val();
            
            if (!codeId) {
                showMessage('assignMessage', 'Veuillez sélectionner un code', 'error');
                return;
            }

            $.post('/admin/gold-purchases/assign', {
                purchase_id: currentPurchaseId,
                code_gold_id: codeId
            }, function(response) {
                if (response.success) {
                    showMessage('assignMessage', response.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showMessage('assignMessage', response.message, 'error');
                }
            });
        }

        function showMessage(id, text, type) {
            let $msg = $('#' + id);
            $msg.removeClass('success error').addClass(type).text(text).show();
        }

        // Fermer le modal en cliquant en dehors
        $(document).click(function(event) {
            if ($(event.target).is('#assignModal')) {
                closeAssignModal();
            }
        });
    </script>
</body>
</html>
