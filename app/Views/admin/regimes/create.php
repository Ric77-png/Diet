<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un régime</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f4f4f4; }
        .navbar { background: #343a40; padding: 15px 30px; color: white; display: flex; justify-content: space-between; }
        .navbar a { color: white; text-decoration: none; margin-left: 15px; }
        .container { max-width: 600px; margin: 30px auto; background: white; padding: 20px; border-radius: 10px; }
        label { display: block; margin: 15px 0 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .btn-back { background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block; padding: 10px 20px; border-radius: 5px; color: white; }
        .error { color: red; font-size: 12px; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Ajouter un régime</h2>
        <div>
            <a href="/admin/regimes">← Retour</a>
            <a href="/logout" style="background:#dc3545; padding:8px 15px; border-radius:5px;">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <form method="post" action="/admin/regimes/store">
            <label>Nom du régime *</label>
            <input type="text" name="nom" value="<?= old('nom') ?>" required>
            
            <label>Description</label>
            <textarea name="description" rows="3"><?= old('description') ?></textarea>
            
            <label>Pourcentage viande (%) *</label>
            <input type="number" name="pourcentage_viande" value="<?= old('pourcentage_viande') ?>" min="0" max="100" required>
            
            <label>Pourcentage poisson (%) *</label>
            <input type="number" name="pourcentage_poisson" value="<?= old('pourcentage_poisson') ?>" min="0" max="100" required>
            
            <label>Pourcentage volaille (%) *</label>
            <input type="number" name="pourcentage_volaille" value="<?= old('pourcentage_volaille') ?>" min="0" max="100" required>
            
            <label>Effet sur le poids par semaine (kg) *</label>
            <input type="number" step="0.1" name="effet_poids_par_semaine" value="<?= old('effet_poids_par_semaine') ?>" required>
            <small>Négatif = perte de poids | Positif = gain de poids</small>
            
            <label>Prix par jour (€) *</label>
            <input type="number" step="0.01" name="prix_par_jour" value="<?= old('prix_par_jour') ?>" required>
            
            <button type="submit">Enregistrer</button>
            <a href="/admin/regimes" class="btn-back">Annuler</a>
        </form>
    </div>
</body>
</html>