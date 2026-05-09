<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des paramètres</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f4f4f4; }
        
        /* NAVBAR */
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
        .navbar a:hover { background: #495057; }
        .logout-btn { background: #dc3545; }
        
        .container { max-width: 900px; margin: 30px auto; background: white; padding: 20px; border-radius: 10px; }
        h1 { margin-bottom: 20px; color: #333; }
        
        .btn { display: inline-block; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-right: 10px; }
        .btn-back { background: #6c757d; color: white; }
        .btn-save { background: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer; }
        .btn-save:hover { background: #218838; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        
        .form-inline { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .form-inline input { 
            padding: 8px 12px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            width: 200px;
            font-size: 14px;
        }
        .valeur-actuelle {
            font-weight: bold;
            color: #007bff;
            background: #e3f2fd;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }
        .description { color: #6c757d; font-size: 13px; margin-top: 5px; }
        
        @media (max-width: 768px) {
            .form-inline { flex-direction: column; align-items: flex-start; }
            th, td { display: block; width: 100%; }
            th { display: none; }
            td { border-bottom: 1px solid #eee; padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>⚙️ Paramètres de l'application</h2>
        <div>
            <a href="/admin">🏠 Dashboard</a>
            <a href="/admin/regimes">📋 Régimes</a>
            <a href="/admin/activites">🏃 Activités</a>
            <a href="/logout" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <h1>Configuration globale</h1>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        </table>
            <thead>
                <tr>
                    <th style="width: 25%">Paramètre</th>
                    <th style="width: 35%">Valeur actuelle</th>
                    <th style="width: 40%">Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($parametres as $param): ?>
                <tr>
                    <td>
                        <strong><?= esc($param['cle']) ?></strong>
                        <?php if($param['description']): ?>
                            <div class="description"><?= esc($param['description']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="valeur-actuelle"><?= esc($param['valeur']) ?></span>
                    </td>
                    <td>
                        <form method="post" action="/admin/parametres/update/<?= urlencode($param['cle']) ?>" class="form-inline">
                            <input type="text" name="valeur" value="<?= esc($param['valeur']) ?>" required>
                            <button type="submit" class="btn-save">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>