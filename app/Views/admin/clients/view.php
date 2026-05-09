<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du client</title>
    <?= view('admin/styles') ?>
    <style>
        .detail-container { background: white; padding: 30px; border-radius: 10px; max-width: 800px; }
        .detail-row { display: flex; gap: 20px; margin-bottom: 15px; }
        .detail-field { flex: 1; }
        .detail-field label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; }
        .detail-field value { font-size: 16px; color: #333; }
        .badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-gold { background: #ffc107; color: #000; }
        .badge-client { background: #007bff; color: white; }
    </style>
</head>
<body>
    <?= view('admin/navbar') ?>
    
    <div class="page-container">
        <div class="content-container">
            <a href="/admin/clients" class="btn btn-back">← Retour</a>
            
            <h1><?= esc($client['nom']) ?></h1>
            
            <div class="detail-container">
                <div class="detail-row">
                    <div class="detail-field">
                        <label>ID:</label>
                        <value><?= $client['id'] ?></value>
                    </div>
                    <div class="detail-field">
                        <label>Rôle:</label>
                        <value><span class="badge badge-client"><?= ucfirst($client['role']) ?></span></value>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Email:</label>
                        <value><?= esc($client['email']) ?></value>
                    </div>
                    <div class="detail-field">
                        <label>Statut Gold:</label>
                        <value>
                            <?php if($client['is_gold']): ?>
                                <span class="badge badge-gold">✓ GOLD</span>
                            <?php else: ?>
                                <span style="color: #999;">Non</span>
                            <?php endif; ?>
                        </value>
                    </div>
                </div>
                
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
                
                <h3 style="margin-top: 20px; margin-bottom: 15px;">Informations physiques</h3>
                
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Taille (m):</label>
                        <value><?= $client['taille'] ?></value>
                    </div>
                    <div class="detail-field">
                        <label>Poids (kg):</label>
                        <value><?= $client['poids'] ?></value>
                    </div>
                    <div class="detail-field">
                        <label>Genre:</label>
                        <value><?= ucfirst($client['genre']) ?></value>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-field">
                        <label>IMC:</label>
                        <value><?= $client['imc'] ?? 'N/A' ?></value>
                    </div>
                    <div class="detail-field">
                        <label>Objectif:</label>
                        <value><?= $client['objectif_id'] ? 'Objectif #' . $client['objectif_id'] : 'Non défini' ?></value>
                    </div>
                </div>
                
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
                
                <h3 style="margin-top: 20px; margin-bottom: 15px;">Financement</h3>
                
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Solde portefeuille:</label>
                        <value><?= number_format($client['wallet_balance'], 2) ?> €</value>
                    </div>
                    <div class="detail-field">
                        <label>Gold acheté le:</label>
                        <value><?= $client['gold_purchased_at'] ? date('d/m/Y H:i', strtotime($client['gold_purchased_at'])) : '-' ?></value>
                    </div>
                </div>
                
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
                
                <h3 style="margin-top: 20px; margin-bottom: 15px;">Dates</h3>
                
                <div class="detail-row">
                    <div class="detail-field">
                        <label>Inscrit le:</label>
                        <value><?= date('d/m/Y H:i', strtotime($client['created_at'])) ?></value>
                    </div>
                    <div class="detail-field">
                        <label>Dernière modification:</label>
                        <value><?= date('d/m/Y H:i', strtotime($client['updated_at'])) ?></value>
                    </div>
                </div>
                
                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
                    <a href="/admin/clients" class="btn btn-back">← Retour</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
