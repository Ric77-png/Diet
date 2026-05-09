<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        .logout {
            background: #dc3545;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .logout:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour, <?= $user['nom'] ?> !</h1>
        <p>Email : <?= $user['email'] ?></p>
        <p>Bienvenue sur votre tableau de bord.</p>
        <a href="/logout" class="logout">Se déconnecter</a>
    </div>
</body>
</html>