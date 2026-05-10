<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnement Gold</title>
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
        
        .container { max-width: 900px; margin: 30px auto; }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card.gold-banner {
            background: linear-gradient(135deg, #d4af37 0%, #ffd700 100%);
            color: #333;
            text-align: center;
        }
        h1 { color: #333; margin-bottom: 15px; }
        h2 { color: #333; margin-bottom: 15px; font-size: 28px; }
        .gold-banner h1 { color: #333; font-size: 48px; text-shadow: 2px 2px 4px rgba(0,0,0,0.1); }
        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .feature {
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #ffd700;
            border-radius: 5px;
        }
        .feature strong { color: #d4af37; }
        .price-section {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        .price {
            font-size: 42px;
            font-weight: bold;
            color: #d4af37;
            margin: 10px 0;
        }
        .price-description {
            color: #666;
            font-size: 14px;
        }
        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
            margin-right: 10px;
        }
        button {
            padding: 12px 30px;
            background: #d4af37;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        button:hover { background: #ffd700; }
        button:disabled { background: #ccc; cursor: not-allowed; }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .wallet-info {
            font-size: 18px;
            margin: 15px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .balance {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-wallet {
            flex: 1;
            background: #28a745;
        }
        .btn-wallet:hover { background: #218838; }
        .btn-code {
            flex: 1;
            background: #007bff;
        }
        .btn-code:hover { background: #0056b3; }
        .code-input-group {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }
        .code-input-group input {
            flex: 1;
        }
        .code-input-group button {
            flex: 0 0 auto;
            width: auto;
        }
        .badge-gold {
            display: inline-block;
            background: #d4af37;
            color: #333;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🏠 Option Gold</h2>
        <div>
            <a href="/client">Mon compte</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <!-- Banner Gold -->
        <div class="card gold-banner">
            <h1>⭐ GOLD MEMBERSHIP ⭐</h1>
            <p style="font-size: 20px; margin-top: 10px;">Accédez à l'expérience premium</p>
        </div>

        <?php if($user['is_gold']): ?>
            <div class="card" style="background: #d4edda; border-left: 4px solid #28a745;">
                <h2 style="color: #155724;">✓ Vous êtes membre Gold <span class="badge-gold">ACTIF</span></h2>
                <p style="color: #155724; margin-top: 10px;">Depuis le : <?= date('d/m/Y', strtotime($user['gold_purchased_at'])) ?></p>
                <p style="margin-top: 10px;">Profitez de tous les avantages de votre abonnement Gold !</p>
            </div>
        <?php else: ?>
            <!-- Avantages Gold -->
            <div class="card">
                <h2>✨ Avantages Gold</h2>
                <div class="features">
                    <div class="feature">
                        <strong>📊</strong> Suivi avancé
                        <p>Analyses détaillées de votre progression</p>
                    </div>
                    <div class="feature">
                        <strong>🎯</strong> Plans personnalisés
                        <p>Régimes et activités sur mesure</p>
                    </div>
                    <div class="feature">
                        <strong>💬</strong> Support prioritaire
                        <p>Assistance 24/7 dédiée</p>
                    </div>
                    <div class="feature">
                        <strong>🎁</strong> <?= $reduction_gold ?>% de réduction
                        <p>Sur tous les régimes premium</p>
                    </div>
                </div>
            </div>

            <!-- Prix -->
            <div class="card">
                <div class="price-section">
                    <h2>Tarif</h2>
                    <div class="price"><?= number_format($prix_gold, 2) ?> €</div>
                    <div class="price-description">Pour un mois d'accès illimité</div>
                </div>

                <!-- Solde du portefeuille -->
                <div class="wallet-info">
                    <div>Solde de votre porte-monnaie :</div>
                    <div class="balance" id="walletBalance"><?= number_format($user['wallet_balance'], 2) ?> €</div>
                </div>

                <!-- Options d'achat -->
                <div class="buttons">
                    <button class="btn-wallet" id="purchaseBtn">💳 Acheter avec mon porte-monnaie</button>
                </div>

                <div id="purchaseMessage" class="message" style="margin-top: 15px;"></div>
            </div>

            <!-- Code d'activation -->
            <div class="card">
                <h2>🎫 Vous avez un code Gold ?</h2>
                <p style="margin-bottom: 15px;">Entrez votre code d'activation pour débloquer Gold gratuitement</p>
                <div class="code-input-group">
                    <input type="text" id="goldCode" placeholder="Entrez votre code Gold" maxlength="50">
                    <button id="validateCodeBtn">Valider</button>
                </div>
                <div id="codeMessage" class="message"></div>
            </div>
        <?php endif; ?>

        <!-- Retour -->
        <div class="card" style="text-align: center;">
            <a href="/client" style="color: #007bff; text-decoration: none; font-size: 16px;">← Retour à mon compte</a>
        </div>
    </div>

    <script>
        // Acheter avec portefeuille
        $('#purchaseBtn').click(function() {
            if (confirm('Confirmer l\'achat de Gold pour <?= number_format($prix_gold, 2) ?> € ?')) {
                $.post('/wallet/buy-gold', {}, function(response) {
                    let $msg = $('#purchaseMessage');
                    if (response.success) {
                        $msg.removeClass('error').addClass('success').text(response.message).show();
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        $msg.removeClass('success').addClass('error').text(response.message).show();
                    }
                });
            }
        });

        // Valider code Gold
        $('#validateCodeBtn').click(function() {
            let code = $('#goldCode').val().trim();
            if (!code) {
                $('#codeMessage').removeClass('success').addClass('error').text('Veuillez entrer un code').show();
                return;
            }

            $.post('/gold/validate-code', {code: code}, function(response) {
                let $msg = $('#codeMessage');
                if (response.success) {
                    $msg.removeClass('error').addClass('success').text(response.message).show();
                    setTimeout(() => location.reload(), 2000);
                } else {
                    $msg.removeClass('success').addClass('error').text(response.message).show();
                }
            });
        });

        // Récupérer le solde à l'arrivée
        function updateBalance() {
            $.get('/wallet/balance', function(response) {
                if (response.success) {
                    $('#walletBalance').text(response.solde + ' €');
                }
            });
        }
        updateBalance();
    </script>
</body>
</html>
