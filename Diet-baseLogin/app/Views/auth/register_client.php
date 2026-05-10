<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Diet App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Éléments de décoration arrière-plan */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 20%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .register-wrapper {
            position: relative;
            z-index: 1;
        }

        .register-container {
            background: white;
            padding: 50px 40px 40px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(102, 126, 234, 0.1);
            width: 100%;
            max-width: 550px;
            position: relative;
            overflow: hidden;
        }

        /* Décoration supérieure */
        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
        }

        /* En-tête avec icône */
        .header-section {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        h2 {
            color: #333;
            margin-bottom: 12px;
            font-size: 28px;
            font-weight: 700;
        }

        .subtitle {
            color: #999;
            font-size: 14px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select {
            width: 100%;
            padding: 13px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
            background: #fafafa;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), inset 0 1px 3px rgba(0,0,0,0.05);
            background: white;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .row.full {
            grid-template-columns: 1fr;
        }

        .error-message {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 6px;
            display: none;
            font-weight: 500;
        }

        .form-group.has-error input,
        .form-group.has-error select {
            border-color: #d32f2f;
            background-color: #ffebee;
        }

        .imc-display {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            border-radius: 12px;
            border: 2px solid #667eea;
            font-weight: 600;
            color: #333;
            backdrop-filter: blur(10px);
        }

        .imc-value {
            font-size: 24px;
            color: #667eea;
            font-weight: 700;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s ease;
            margin-top: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        button:hover:not(:disabled)::before {
            left: 100%;
        }

        button:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        button:active:not(:disabled) {
            transform: translateY(-1px);
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            border-radius: 12px;
            display: none;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            color: #c62828;
            border: 2px solid #d32f2f;
            box-shadow: 0 3px 10px rgba(211, 47, 47, 0.2);
        }

        .success {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            color: #1b5e20;
            border: 2px solid #2e7d32;
            box-shadow: 0 3px 10px rgba(46, 125, 50, 0.2);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #999;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .passwords-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        button span {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
            position: relative;
            z-index: 1;
        }

        .form-section:last-of-type {
            border-bottom: none;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 20px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
            margin-right: 10px;
        }

        @media (max-width: 600px) {
            .register-container {
                padding: 30px 20px;
                border-radius: 15px;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
                font-size: 30px;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .subtitle {
                font-size: 13px;
            }

            .row {
                grid-template-columns: 1fr;
            }

            .passwords-row {
                grid-template-columns: 1fr;
            }

            button {
                padding: 13px;
                font-size: 15px;
            }

            .message {
                margin-top: 15px;
                padding: 12px;
                font-size: 13px;
            }

            .imc-display {
                padding: 14px;
            }

            .imc-value {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <!-- Header avec logo -->
            <div class="header-section">
                <h2>Créer un compte</h2>
                <p class="subtitle">Rejoignez notre communauté de santé</p>
            </div>

            <form id="registerForm">
                <!-- Section Informations Personnelles -->
                <div class="form-section">
                    <div class="section-title">Informations Personnelles</div>

                    <div class="form-group">
                        <label for="nom">Nom complet *</label>
                        <input type="text" id="nom" name="nom" placeholder="Ex: Jean Dupont" required>
                        <div class="error-message"></div>
                    </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" placeholder="Ex: jean@example.com" required>
                    <div class="error-message"></div>
                </div>

                <div class="passwords-row">
                    <div class="form-group">
                        <label for="password">Mot de passe *</label>
                        <input type="password" id="password" name="password" placeholder="Minimum 6 caractères" required>
                        <div class="error-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmer le mot de passe *</label>
                        <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirmez le mot de passe" required>
                        <div class="error-message"></div>
                    </div>
                </div>
            </div>

            <!-- Section Informations de Santé -->
            <div class="form-section">
                <div class="section-title">Informations de Santé</div>

                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <select id="genre" name="genre" required>
                        <option value="">-- Sélectionnez votre genre --</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                    <div class="error-message"></div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="taille">Taille (cm) *</label>
                        <input type="number" id="taille" name="taille" placeholder="Ex: 175" min="50" max="250" step="0.1" required>
                        <div class="error-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="poids">Poids (kg) *</label>
                        <input type="number" id="poids" name="poids" placeholder="Ex: 75" min="20" max="300" step="0.1" required>
                        <div class="error-message"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="imc">IMC (calculé automatiquement)</label>
                    <div class="imc-display">
                        <span>Votre IMC:</span>
                        <span class="imc-value" id="imcValue">--</span>
                    </div>
                    <input type="hidden" id="imc" name="imc" value="">
                </div>
            </div>

            <button type="submit" id="submitBtn">
                <span>
                    <span class="spinner"></span>
                    <span class="btn-text">S'inscrire</span>
                </span>
            </button>

            <div id="errorMsg" class="message error"></div>
            <div id="successMsg" class="message success"></div>
        </form>

        <div class="login-link">
            Vous avez déjà un compte? <a href="/login">Se connecter</a>
        </div>
    </div>

    <script>
        // Fonction de calcul de l'IMC
        function calculateIMC(taille, poids) {
            if (taille && poids && taille > 0 && poids > 0) {
                // Taille en centimètres, convertir en mètres
                const tailleEnMetres = taille / 100;
                const imc = (poids / (tailleEnMetres * tailleEnMetres)).toFixed(2);
                return imc;
            }
            return null;
        }

        // Mise à jour de l'IMC en temps réel
        function updateIMC() {
            const taille = parseFloat($('#taille').val());
            const poids = parseFloat($('#poids').val());

            if (taille && poids) {
                const imc = calculateIMC(taille, poids);
                $('#imcValue').text(imc);
                $('#imc').val(imc);
            } else {
                $('#imcValue').text('--');
                $('#imc').val('');
            }
        }

        // Écouteurs d'événements pour taille et poids
        $('#taille, #poids').on('input change', function() {
            updateIMC();
        });

        // Soumission du formulaire
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();

            // Réinitialiser les messages d'erreur
            $('.error-message').hide();
            $('.form-group').removeClass('has-error');
            $('#errorMsg').hide();
            $('#successMsg').hide();

            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            $('.spinner').show();

            $.ajax({
                url: '/register-client',
                type: 'POST',
                data: {
                    nom: $('#nom').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirm: $('#password_confirm').val(),
                    genre: $('#genre').val(),
                    taille: $('#taille').val(),
                    poids: $('#poids').val(),
                    imc: $('#imc').val()
                },
                success: function(response) {
                    if (response.success) {
                        $('#registerForm')[0].reset();
                        $('#successMsg')
                            .text(response.message)
                            .show();

                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    } else {
                        if (response.errors) {
                            // Afficher les erreurs de validation
                            $.each(response.errors, function(field, message) {
                                const formGroup = $('[name="' + field + '"]').closest('.form-group');
                                formGroup.addClass('has-error');
                                formGroup.find('.error-message')
                                    .text(message)
                                    .show();
                            });
                        } else {
                            $('#errorMsg')
                                .text(response.message || 'Une erreur s\'est produite.')
                                .show();
                        }
                    }
                },
                error: function() {
                    $('#errorMsg')
                        .text('Une erreur s\'est produite. Veuillez réessayer.')
                        .show();
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    $('.spinner').hide();
                }
            });
        });

        // Validation du champ taille
        $('#taille').on('input', function() {
            const val = parseFloat($(this).val());
            if (val < 0 || val > 250) {
                $(this).closest('.form-group').find('.error-message').text('La taille doit être entre 50 et 250 cm');
            } else {
                $(this).closest('.form-group').find('.error-message').hide();
            }
        });

        // Validation du champ poids
        $('#poids').on('input', function() {
            const val = parseFloat($(this).val());
            if (val < 0 || val > 300) {
                $(this).closest('.form-group').find('.error-message').text('Le poids doit être entre 20 et 300 kg');
            } else {
                $(this).closest('.form-group').find('.error-message').hide();
            }
        });

        // Validation email en temps réel
        $('#email').on('blur', function() {
            const email = $(this).val();
            if (email) {
                $.ajax({
                    url: '/check-email',
                    type: 'POST',
                    data: { email: email },
                    success: function(response) {
                        if (!response.available) {
                            $('#email').closest('.form-group')
                                .addClass('has-error')
                                .find('.error-message')
                                .text('Cet email est déjà utilisé')
                                .show();
                        }
                    }
                });
            }
        });
    </script>
    </div>
</body>
</html>
