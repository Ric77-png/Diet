<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Etape 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 380px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            margin-top: 18px;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #218838; }
        .error-list {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .link {
            text-align: center;
            margin-top: 12px;
        }
        .link a { color: #28a745; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription - Etape 1</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-list"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="error-list">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <div><?= esc($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/register/personal">
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" value="<?= esc(old('nom') ?? '') ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= esc(old('email') ?? '') ?>" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirm">Confirmer le mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" required>

            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
                <option value="">-- Choisir --</option>
                <option value="masculin" <?= old('genre') === 'masculin' ? 'selected' : '' ?>>Masculin</option>
                <option value="feminin" <?= old('genre') === 'feminin' ? 'selected' : '' ?>>Feminin</option>
            </select>

            <button type="submit">Continuer</button>
        </form>

        <div class="link">
            <a href="/login">Deja un compte ? Se connecter</a>
        </div>
    </div>
</body>
</html>
