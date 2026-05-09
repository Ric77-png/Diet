<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une activité</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        h1 { margin-bottom: 20px; color: #333; }
        label { display: block; margin-top: 15px; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .btn-back { background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block; text-align: center; }
        .error { color: red; font-size: 12px; margin-top: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier l'activité</h1>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <form method="post" action="/admin/activites/update/<?= $activite['id'] ?>">
            <label>Nom de l'activité *</label>
            <input type="text" name="nom" value="<?= old('nom', $activite['nom']) ?>" required>
            <?php if(isset($errors['nom'])): ?><div class="error"><?= $errors['nom'] ?></div><?php endif; ?>
            
            <label>Durée (minutes) *</label>
            <input type="number" name="duree_minutes" value="<?= old('duree_minutes', $activite['duree_minutes']) ?>" required>
            <?php if(isset($errors['duree_minutes'])): ?><div class="error"><?= $errors['duree_minutes'] ?></div><?php endif; ?>
            
            <label>Calories brûlées par heure *</label>
            <input type="number" name="calories_par_heure" value="<?= old('calories_par_heure', $activite['calories_par_heure']) ?>" required>
            <?php if(isset($errors['calories_par_heure'])): ?><div class="error"><?= $errors['calories_par_heure'] ?></div><?php endif; ?>
            
            <label>Difficulté *</label>
            <select name="difficulte" required>
                <option value="facile" <?= old('difficulte', $activite['difficulte']) == 'facile' ? 'selected' : '' ?>>Facile</option>
                <option value="moyen" <?= old('difficulte', $activite['difficulte']) == 'moyen' ? 'selected' : '' ?>>Moyen</option>
                <option value="difficile" <?= old('difficulte', $activite['difficulte']) == 'difficile' ? 'selected' : '' ?>>Difficile</option>
            </select>
            <?php if(isset($errors['difficulte'])): ?><div class="error"><?= $errors['difficulte'] ?></div><?php endif; ?>
            
            <button type="submit">Mettre à jour</button>
            <a href="/admin/activites" class="btn-back">Annuler</a>
        </form>
    </div>
</body>
</html>