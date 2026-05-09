<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <?= view('admin/styles') ?>
</head>
<body>
    <?= view('admin/navbar') ?>

    <div class="container">
        <div class="welcome">
            <h1>Bonjour, <?= session()->get('nom') ?> !</h1>
            <p>Bienvenue dans votre espace d'administration.</p>
        </div>

        <div class="cards">
            <div class="card">
                <h3>� Clients</h3>
                <p>Gérer les utilisateurs clients</p>
                <a href="/admin/clients">Accéder</a>
            </div>
            <div class="card">
                <h3>�📋 Régimes</h3>
                <p>Gérer les régimes alimentaires</p>
                <a href="/admin/regimes">Accéder</a>
            </div>
            <div class="card">
                <h3>🏃 Activités</h3>
                <p>Gérer les activités sportives</p>
                <a href="/admin/activites">Accéder</a>
            </div>
            <div class="card">
                <h3>⚙️ Paramètres</h3>
                <p>Configuration de l'application</p>
                <a href="/admin/parametres">Accéder</a>
            </div>
        </div>
    </div>
</body>
</html>