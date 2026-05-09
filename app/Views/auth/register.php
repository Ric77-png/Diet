<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Manager - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h1 {
            color: #667eea;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .register-header p {
            color: #999;
            font-size: 14px;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
        .register-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        .register-footer p {
            color: #999;
            font-size: 14px;
            margin: 0;
        }
        .register-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .register-footer a:hover {
            color: #764ba2;
        }
        .loading-spinner {
            display: none;
            margin-left: 10px;
        }
        .form-hint {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Créer un compte</h1>
            <p>Rejoignez Diet Manager</p>
        </div>

        <div id="ajaxErrors" class="alert alert-danger" style="display: none;"></div>

        <form id="registerForm" method="POST" action="/auth/signup">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="nom" 
                    name="nom" 
                    placeholder="Votre nom"
                    minlength="3"
                    maxlength="100"
                    value="<?= old('nom') ?>"
                    required
                >
                <?php if (isset($errors['nom'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?= $errors['nom'] ?></div>
                <?php endif; ?>
                <div class="form-hint">Minimum 3 caractères</div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="vous@exemple.com"
                    value="<?= old('email') ?>"
                    required
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="Minimum 2 caractères"
                    minlength="2"
                    maxlength="50"
                    required
                >
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?= $errors['password'] ?></div>
                <?php endif; ?>
                <div class="form-hint">Minimum 2 caractères, maximum 50</div>
            </div>

            <button type="submit" class="btn btn-register">
                Créer mon compte
            </button>
        </form>

        <div class="register-footer">
            <p>Déjà inscrit? <a href="/">Se connecter</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     y>
</html>