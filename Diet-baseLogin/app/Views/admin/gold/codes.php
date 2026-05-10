<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des codes Gold</title>
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
            background: linear-gradient(135deg, #d4af37 0%, #ffd700 100%);
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
        
        .generate-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #ffd700;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="number"], input[type="text"], select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
        }
        
        button {
            padding: 10px 20px;
            background: #d4af37;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        button:hover { background: #ffd700; }
        button:disabled { background: #ccc; cursor: not-allowed; }
        
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
        
        .badge-unused {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-used {
            background: #d4edda;
            color: #155724;
        }
        
        .code-display {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #d4af37;
            font-size: 16px;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .btn-assign {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .btn-assign:hover {
            background: #218838;
        }
        
        .filter-section {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .filter-section select {
            width: auto;
            max-width: none;
        }
        
        .codes-generated {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            display: none;
        }
        
        .codes-list {
            background: white;
            padding: 10px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            line-height: 1.8;
        }
        
        .copy-btn {
            background: #007bff;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
            margin-left: 10px;
        }
        
        .copy-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🏆 Gestion des codes Gold</h2>
        <div>
            <a href="/admin">Tableau de bord</a>
            <a href="/admin/clients">Clients</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <!-- Statistiques -->
        <div class="stats">
            <div class="stat-box">
                <div class="label">Codes créés</div>
                <div class="number"><?= $total ?></div>
            </div>
            <div class="stat-box">
                <div class="label">Codes utilisés</div>
                <div class="number"><?= $utilisés ?></div>
            </div>
            <div class="stat-box">
                <div class="label">Codes disponibles</div>
                <div class="number"><?= $inutilisés ?></div>
            </div>
        </div>

        <!-- Génération de codes -->
        <div class="card">
            <h2>➕ Générer de nouveaux codes Gold</h2>
            
            <div class="generate-section">
                <div class="form-group">
                    <label for="quantite">Nombre de codes à générer :</label>
                    <input type="number" id="quantite" value="5" min="1" max="100">
                </div>

                <div class="form-group">
                    <label for="duree">Durée (jours) :</label>
                    <input type="number" id="duree" value="30" min="1" max="365">
                </div>

                <button id="generateBtn">Générer les codes</button>

                <div id="generateMessage" class="message"></div>

                <div id="codesGenerated" class="codes-generated">
                    <h3>✓ Codes générés avec succès :</h3>
                    <div class="codes-list" id="codesList"></div>
                    <button class="copy-btn" id="copyBtn">📋 Copier tous les codes</button>
                </div>
            </div>
        </div>

        <!-- Liste des codes -->
        <div class="card">
            <h2>📋 Liste des codes</h2>

            <div class="filter-section">
                <label for="filterStatus" style="margin-bottom: 0;">Filtrer :</label>
                <select id="filterStatus">
                    <option value="">Tous</option>
                    <option value="unused">Non utilisés</option>
                    <option value="used">Utilisés</option>
                </select>
            </div>

            <?php if (!empty($codes)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Durée (jours)</th>
                            <th>Statut</th>
                            <th>Utilisé par</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($codes as $code): ?>
                            <tr class="code-row" data-status="<?= $code['utilise'] ? 'used' : 'unused' ?>">
                                <td><span class="code-display"><?= $code['code'] ?></span></td>
                                <td><?= $code['duree_jours'] ?> jours</td>
                                <td>
                                    <?php if ($code['utilise']): ?>
                                        <span class="badge badge-used">✓ Utilisé</span>
                                    <?php else: ?>
                                        <span class="badge badge-unused">⏳ Disponible</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($code['utilisateur_id']): ?>
                                        <?php 
                                            $utilisateur = $this->userModel->find($code['utilisateur_id']);
                                            echo $utilisateur ? $utilisateur['nom'] . ' (' . $utilisateur['email'] . ')' : 'N/A';
                                        ?>
                                    <?php else: ?>
                                        <em style="color: #999;">-</em>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($code['created_at'])) ?></td>
                                <td>
                                    <?php if (!$code['utilise']): ?>
                                        <button class="btn-delete" onclick="deleteCode(<?= $code['id'] ?>)">Supprimer</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #999; padding: 40px;">Aucun code créé pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const userModel = {
            find: function(id) {
                // Cette fonction sera appelée via PHP
                return null;
            }
        };

        // Générer des codes
        $('#generateBtn').click(function() {
            const quantite = parseInt($('#quantite').val()) || 1;
            const duree = parseInt($('#duree').val()) || 30;

            if (quantite < 1 || quantite > 100) {
                showMessage('generateMessage', 'Quantité invalide (1-100)', 'error');
                return;
            }

            $.post('/admin/gold/generate', {
                quantite: quantite,
                duree_jours: duree
            }, function(response) {
                let $msg = $('#generateMessage');
                if (response.success) {
                    $msg.removeClass('error').addClass('success').text(response.message).show();
                    
                    // Afficher les codes
                    let codesHtml = response.codes.map(c => '<div>' + c + '</div>').join('');
                    $('#codesList').html(codesHtml);
                    $('#codesGenerated').show();
                    
                    // Recharger la page après 2 secondes
                    setTimeout(() => location.reload(), 2000);
                } else {
                    $msg.removeClass('success').addClass('error').text(response.message).show();
                }
            });
        });

        // Copier tous les codes
        $('#copyBtn').click(function() {
            const codes = $('#codesList').text();
            navigator.clipboard.writeText(codes).then(() => {
                alert('Codes copiés dans le presse-papiers !');
            });
        });

        // Supprimer un code
        function deleteCode(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce code ?')) {
                $.post('/admin/gold/delete', {id: id}, function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Erreur : ' + response.message);
                    }
                });
            }
        }

        // Filtrer les codes
        $('#filterStatus').change(function() {
            const status = $(this).val();
            if (status === '') {
                $('.code-row').show();
            } else {
                $('.code-row').each(function() {
                    $(this).toggle($(this).data('status') === status);
                });
            }
        });

        function showMessage(id, text, type) {
            let $msg = $('#' + id);
            $msg.removeClass('success error').addClass(type).text(text).show();
        }
    </script>
</body>
</html>
