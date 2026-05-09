<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 0;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            color: white;
        }
        .sidebar .logo {
            text-align: center;
            padding: 20px;
            font-weight: bold;
            font-size: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }
        .sidebar .nav-item {
            padding: 15px 20px;
            cursor: pointer;
            transition: background 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }
        .sidebar .nav-item a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #333;
            font-weight: 700;
            font-size: 24px;
            margin: 0;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-menu a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        .table {
            margin: 0;
        }
        .table thead th {
            color: #667eea;
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }
        .table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }
        .table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
                padding: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            Diet Manager
        </div>
        <div class="nav-item">
            <a href="/dashboard">Tableau de bord</a>
        </div>
        <div class="nav-item">
            <a href="/dashboard/utilisateurs">Utilisateurs</a>
        </div>
        <div class="nav-item">
            <a href="/dashboard/regimes">Regimes</a>
        </div>
        <div class="nav-item">
            <a href="/dashboard/aliments">Aliments</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1><?= $title ?></h1>
            <div class="user-menu">
                <span><?= session()->get('nom') ?></span>
                <a href="/auth/logout">
                    Déconnexion
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="content-card">
            <div id="loadingSpinner" class="text-center" style="display: none; margin: 20px 0;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
            
            <button class="btn btn-sm btn-primary mb-3" id="refreshBtn">
                Actualiser
            </button>
            
            <table class="table table-hover" id="regimesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Calories min</th>
                        <th>Calories max</th>
                        <th>Calories moyennes</th>
                        <th>Objectif</th>
                    </tr>
                </thead>
                <tbody id="regimesBody">
                    <?php foreach ($regimes as $regime): ?>
                    <tr>
                        <td><?= $regime['id'] ?></td>
                        <td><strong><?= $regime['nom'] ?></strong></td>
                        <td><?= substr($regime['description'], 0, 50) ?>...</td>
                        <td><span class="badge bg-info"><?= number_format($regime['calories_min'], 0) ?></span></td>
                        <td><span class="badge bg-warning"><?= number_format($regime['calories_max'], 0) ?></span></td>
                        <td>
                            <?php 
                            $moy = ($regime['calories_min'] + $regime['calories_max']) / 2;
                            ?>
                            <span class="badge bg-secondary"><?= number_format($moy, 0) ?></span>
                        </td>
                        <td><?= $regime['objectif_id'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($regimes)): ?>
            <div class="alert alert-info mt-3">Aucun regime enregistre</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function loadRegimes() {
            const spinner = document.getElementById('loadingSpinner');
            const table = document.getElementById('regimesTable');
            const tbody = document.getElementById('regimesBody');

            spinner.style.display = 'block';
            table.style.opacity = '0.5';

            try {
                const response = await fetch('/dashboard/regimes');
                const html = await response.text();
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.querySelector('#regimesBody');
                
                if (newTbody) {
                    tbody.innerHTML = newTbody.innerHTML;
                }
            } catch (error) {
                console.error('Erreur:', error);
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Erreur de chargement</td></tr>';
            } finally {
                spinner.style.display = 'none';
                table.style.opacity = '1';
            }
        }

        document.getElementById('refreshBtn').addEventListener('click', loadRegimes);
        setInterval(loadRegimes, 60000);
    </script>
</body>
</html>