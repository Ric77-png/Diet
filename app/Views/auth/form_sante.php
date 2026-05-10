<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Etape 2</title>
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
            width: 420px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }
        .subtitle {
            text-align: center;
            color: #555;
            margin-bottom: 20px;
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
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #0056b3; }
        .error-list {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .hint {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription - Etape 2</h2>
        <div class="subtitle">Informations de sante</div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="error-list">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <div><?= esc($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/register/health">
            <label for="taille">Taille (en metres)</label>
            <input type="number" step="0.01" min="0.5" id="taille" name="taille" value="<?= esc(old('taille') ?? '') ?>" required>
            <div class="hint">Exemple : 1.75</div>

            <label for="poids">Poids (en kg)</label>
            <input type="number" step="0.1" min="1" id="poids" name="poids" value="<?= esc(old('poids') ?? '') ?>" required>

            <label for="objectif_id">Objectif</label>
            <select id="objectif_id" name="objectif_id" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($objectifs as $obj): ?>
                    <option value="<?= esc($obj['id']) ?>" <?= old('objectif_id') == $obj['id'] ? 'selected' : '' ?>>
                        <?= esc($obj['description']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Creer mon compte</button>
        </form>
    </div>
</body>
</html>
