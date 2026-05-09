<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Manager - Connexion</title>
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
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 400px;
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
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            color: #667eea;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .login-header p {
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
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .btn-login:disabled {
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
        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        .login-footer p {
            color: #999;
            font-size: 14px;
            margin: 0;
        }
        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .login-footer a:hover {
            color: #764ba2;
        }
        .loading-spinner {
            display: none;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Diet Manager</h1>
            <p>Gestion intelligente de régimes alimentaires</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div id="ajaxErrors" class="alert alert-danger" style="display: none;"></div>

        <form id="loginForm" method="POST" action="/auth/login">
            <?= csrf_field() ?>

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
                    placeholder="Entrez votre mot de passe"
                    minlength="2"
                    maxlength="50"
                    required
                >
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback" style="display: block;"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-login">
                Se connecter
            </button>
        </form>

        <div class="login-footer">
            <p>Pas de compte? <a href="/auth/register">Créer un compte</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </script>
</body>
</html>