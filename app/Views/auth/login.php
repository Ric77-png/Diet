<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Diet App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            display: none;
        }
        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
            display: none;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (session()->getFlashdata('success')): ?>
            <div id="successMsg" class="success" style="display:block;">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php else: ?>
            <div id="successMsg" class="success"></div>
        <?php endif; ?>
        <form id="loginForm">
            <input type="email" id="email" placeholder="Email" required>
            <input type="password" id="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
            <div id="errorMsg" class="error"></div>
        </form>
        <div class="register-link">
            <a href="/register">Pas encore de compte ? S'inscrire</a>
        </div>
    </div>

    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $('#errorMsg').hide();
            $('#successMsg').hide();
            
            $.ajax({
                url: '/login',
                type: 'POST',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#successMsg').text('Connexion réussie...').show();
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1000);
                    } else {
                        $('#errorMsg').text(response.message).show();
                    }
                },
                error: function() {
                    $('#errorMsg').text('Erreur serveur').show();
                }
            });
        });
    </script>
</body>
</html>