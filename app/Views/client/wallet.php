<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon portefeuille</title>
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
        
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 { color: #333; margin-bottom: 15px; }
        
        .balance-section {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
        }
        .balance-section h1 { font-size: 48px; margin: 10px 0; }
        .balance-section p { font-size: 18px; opacity: 0.9; }
        
        .recharge-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        
        .custom-input-group {
            display: flex;
            gap: 10px;
            margin: 15px 0;
        }
        
        .custom-input-group input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        button:hover { background: #0056b3; }
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
        
        .gold-section {
            background: linear-gradient(135deg, #d4af37 0%, #ffd700 100%);
            padding: 30px;
            border-radius: 10px;
            color: #333;
            text-align: center;
        }
        
        .gold-section h2 { color: #333; }
        .gold-section p { margin: 10px 0; font-size: 18px; }
        .gold-price {
            font-size: 36px;
            font-weight: bold;
            margin: 15px 0;
        }
        
        .btn-gold {
            background: #ffc107;
            color: #333;
            padding: 12px 30px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        
        .btn-gold:hover {
            background: #ffb300;
        }
        
        .btn-gold:disabled {
            background: #ccc;
            color: #666;
            cursor: not-allowed;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            color: #1565c0;
        }
        
        @media (max-width: 768px) {
            .amount-buttons {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>💰 Mon portefeuille</h2>
        <div>
            <a href="/client">Mon compte</a>
            <a href="/gold/subscribe">Option Gold</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <!-- Solde actuel -->
        <div class="balance-section">
            <p>Solde actuel de votre porte-monnaie</p>
            <h1 id="balance">0.00 €</h1>
        </div>

        <!-- Recharger le wallet -->
        <div class="card">
            <h2>➕ Ajouter de l'argent</h2>
            
            <div class="recharge-section">
                <div class="custom-input-group">
                    <input type="number" id="customAmount" placeholder="Montant à ajouter (€)" min="1" step="0.01">
                    <button id="rechargeCustomBtn">Ajouter</button>
                </div>
                
                <div id="rechargeMessage" class="message"></div>
            </div>
        </div>

        <!-- Abonnement Gold -->
        <div class="card">
            <div class="gold-section">
                <h2>⭐ ABONNEMENT GOLD ⭐</h2>
                <p>Débloquez l'accès premium avec tous les avantages</p>
                <div class="gold-price" id="goldPrice">49.99€</div>
                
                <div class="info-box">
                    <strong>ℹ️ Comment ça marche :</strong>
                    <p style="margin-top: 10px; font-size: 14px;">
                        1. Rechargez votre portefeuille<br>
                        2. Cliquez sur "Acheter maintenant"<br>
                        3. L'administrateur vous enverra un code d'activation par email<br>
                        4. Utilisez le code pour activer votre abonnement
                    </p>
                </div>
                
                <button class="btn-gold" id="buyGoldBtn">💳 Acheter maintenant</button>
                <div id="goldMessage" class="message"></div>
            </div>
        </div>

        <!-- Lien retour -->
        <div class="card" style="text-align: center;">
            <a href="/client" style="color: #007bff; text-decoration: none; font-size: 16px;">← Retour à mon compte</a>
        </div>
    </div>

    <script>
        // Mettre à jour le solde
        function updateBalance() {
            $.get('/wallet/balance', function(response) {
                if (response.success) {
                    $('#balance').text(parseFloat(response.solde).toFixed(2) + ' €');
                }
            });
        }
        
        // Recharger avec boutons prédéfinis
        $(document).on('click', '.amount-btn', function() {
            const amount = $(this).data('amount');
            rechargeWallet(amount);
        });
        
        // Recharger avec montant personnalisé
        $('#rechargeCustomBtn').click(function() {
            const amount = parseFloat($('#customAmount').val());
            if (!amount || amount <= 0) {
                showMessage('rechargeMessage', 'Veuillez entrer un montant valide', 'error');
                return;
            }
            rechargeWallet(amount);
        });
        
        // Fonction pour recharger
        function rechargeWallet(amount) {
            $.post('/wallet/recharge', {montant: amount}, function(response) {
                let $msg = $('#rechargeMessage');
                if (response.success) {
                    $msg.removeClass('error').addClass('success').text(response.message).show();
                    $('#customAmount').val('');
                    updateBalance();
                    setTimeout(() => $msg.hide(), 4000);
                } else {
                    $msg.removeClass('success').addClass('error').text(response.message).show();
                }
            });
        }
        
        // Acheter Gold
        $('#buyGoldBtn').click(function() {
            if (confirm('Êtes-vous sûr de vouloir acheter l\'abonnement Gold ?')) {
                $.post('/wallet/buy-gold', {}, function(response) {
                    let $msg = $('#goldMessage');
                    if (response.success) {
                        $msg.removeClass('error').addClass('success').text(response.message).show();
                        updateBalance();
                        setTimeout(() => {
                            alert('Votre demande a été envoyée à l\'administrateur');
                            location.reload();
                        }, 2000);
                    } else {
                        $msg.removeClass('success').addClass('error').text(response.message).show();
                    }
                });
            }
        });
        
        // Charger le solde au démarrage
        updateBalance();
    </script>
</body>
</html>
