<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace client</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f4f4f4; }
        
        .navbar {
            background: #2e81d4;
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
        
        .container { max-width: 800px; margin: 30px auto; }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 { color: #333; margin-bottom: 15px; }
        .wallet-balance {
            font-size: 32px;
            font-weight: bold;
            color: #28a745;
        }
        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 200px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2> Mon espace client</h2>
        <div>
            <a href="/client">Mon compte</a>
            <a href="/gold/subscribe">Option Gold</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2> Bonjour, <?= session()->get('nom') ?></h2>
            <p>Email : <?= session()->get('email') ?></p>
            <?php if(session()->get('is_gold')): ?>
                <p style="color: #d4af37; font-weight: bold;"> Membre Gold </p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2> Mon porte-monnaie</h2>
            <p>Solde actuel : <span class="wallet-balance" id="walletBalance">0</span> €</p>
        </div>

        <div class="card">
            <h2> Ajouter de l'argent</h2>
            <input type="number" id="montant" placeholder="Montant à ajouter (€)" min="1" step="0.01">
            <button id="ajouterBtn">Ajouter</button>
            <div id="message" class="message"></div>
        </div>
    </div>

    <script>
        // Charger le solde au chargement de la page
        function loadBalance() {
            $.ajax({
                url: '/wallet/balance',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#walletBalance').text(response.solde.toFixed(2));
                    }
                }
            });
        }

        // Ajouter de l'argent au portefeuille
        $('#ajouterBtn').on('click', function() {
            var montant = parseFloat($('#montant').val());
            
            if (!montant || montant <= 0) {
                showMessage('Veuillez entrer un montant valide', 'error');
                return;
            }

            $.ajax({
                url: '/wallet/recharge',
                type: 'POST',
                data: { montant: montant },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showMessage(response.message, 'success');
                        $('#montant').val('');
                        loadBalance(); // Recharger le solde
                    } else {
                        showMessage(response.message, 'error');
                    }
                },
                error: function() {
                    showMessage('Erreur serveur', 'error');
                }
            });
        });

        function showMessage(msg, type) {
            var messageDiv = $('#message');
            messageDiv.text(msg);
            messageDiv.removeClass('success error');
            messageDiv.addClass(type);
            messageDiv.show();
            
            setTimeout(function() {
                messageDiv.fadeOut();
            }, 3000);
        }

        // Initialisation
        loadBalance();
    </script>
</body>
</html>