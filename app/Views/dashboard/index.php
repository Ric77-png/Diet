<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
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
            transition: color 0.3s;
        }
        .user-menu a:hover {
            color: #764ba2;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }
        .stat-card.hommes {
            border-left-color: #3498db;
        }
        .stat-card.femmes {
            border-left-color: #e74c3c;
        }
        .stat-card.aliments {
            border-left-color: #f39c12;
        }
        .stat-card.regimes {
            border-left-color: #27ae60;
        }
        .stat-card .label {
            color: #999;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .stat-card .value {
            color: #333;
            font-size: 32px;
            font-weight: 700;
        }
        .stat-card {
            position: relative;
        }
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        .chart-card h3 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .table-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        .table-card h3 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .table {
            margin: 0;
        }
        .table thead th {
            color: #667eea;
            border-top: none;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.3s;
        }
        .table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                min-height: auto;
                padding: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .charts-container {
                grid-template-columns: 1fr;
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

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Utilisateurs Total</div>
                <div class="value"><?= $stats['total_utilisateurs'] ?></div>
            </div>

            <div class="stat-card hommes">
                <div class="label">Utilisateurs Hommes</div>
                <div class="value"><?= $stats['utilisateurs_hommes'] ?></div>
            </div>

            <div class="stat-card femmes">
                <div class="label">Utilisateurs Femmes</div>
                <div class="value"><?= $stats['utilisateurs_femmes'] ?></div>
            </div>

            <div class="stat-card aliments">
                <div class="label">Aliments</div>
                <div class="value"><?= $stats['total_aliments'] ?></div>
            </div>

            <div class="stat-card regimes">
                <div class="label">Régimes</div>
                <div class="value"><?= $stats['total_regimes'] ?></div>
            </div>

            <div class="stat-card">
                <div class="label">IMC Moyen</div>
                <div class="value"><?= number_format($stats['imc_moyen'], 1) ?></div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-container">
            <div class="chart-card">
                <h3>Distribution IMC</h3>
                <canvas id="imcChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Objectifs</h3>
                <canvas id="objectifsChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Calories par Objectif</h3>
                <canvas id="caloriesChart"></canvas>
            </div>
        </div>

        <!-- Tables -->
        <div class="table-card">
            <h3>Top 10 Aliments les Plus Caloriques</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Aliment</th>
                        <th>Calories</th>
                        <th>Protéines</th>
                        <th>Glucides</th>
                        <th>Lipides</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tableaux['top_aliments'] as $aliment): ?>
                    <tr>
                        <td><strong><?= $aliment['nom'] ?></strong></td>
                        <td><span class="badge bg-danger"><?= number_format($aliment['calories'], 0) ?> kcal</span></td>
                        <td><?= number_format($aliment['proteines'] ?? 0, 1) ?>g</td>
                        <td><?= number_format($aliment['glucides'] ?? 0, 1) ?>g</td>
                        <td><?= number_format($aliment['lipides'] ?? 0, 1) ?>g</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        // Fonction pour rafraîchir les statistiques via AJAX
        async function refreshStats() {
            try {
                const response = await fetch('/dashboard/stats');
                const data = await response.json();
                
                // Mise à jour des cartes de statistiques
                updateStatCard(0, data.total_utilisateurs);
                updateStatCard(5, Number(data.imc_moyen.toFixed(1)));
                
                console.log('Stats actualisées:', data);
            } catch (error) {
                console.error('Erreur lors du rafraîchissement:', error);
            }
        }

        function updateStatCard(index, newValue) {
            const cards = document.querySelectorAll('.stat-card .value');
            if (cards[index]) {
                cards[index].textContent = newValue;
            }
        }

        // Rafraîchir les stats toutes les 30 secondes
        setInterval(refreshStats, 30000);

        // Chargement initial des graphes
        document.addEventListener('DOMContentLoaded', function() {
            loadCharts();
            
            // Ajouter des boutons pour rafraîchir manuellement
            const refreshBtn = document.createElement('button');
            refreshBtn.className = 'btn btn-sm btn-outline-primary';
            refreshBtn.textContent = 'Rafraîchir les données';
            refreshBtn.style.marginBottom = '20px';
            refreshBtn.addEventListener('click', refreshStats);
            
            const headerDiv = document.querySelector('.header');
            if (headerDiv) {
                headerDiv.parentNode.insertBefore(refreshBtn, headerDiv.nextSibling);
            }
        });

        function loadCharts() {
            // Préparation des données pour les graphes
            const imcData = <?= json_encode($graphes['imc_distribution']) ?>;
            const objectifsData = <?= json_encode($graphes['objectifs']) ?>;
            const caloriesData = <?= json_encode($graphes['calories']) ?>;

            // Graphe IMC Distribution
            const imcCtx = document.getElementById('imcChart').getContext('2d');
            new Chart(imcCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(imcData),
                    datasets: [{
                        data: Object.values(imcData),
                        backgroundColor: ['#3498db', '#27ae60', '#f39c12', '#e74c3c']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Graphe Objectifs
            const objLabels = objectifsData.map(obj => obj.nom || 'N/A');
            const objCounts = objectifsData.map(obj => obj.count || 0);

            const objectifsCtx = document.getElementById('objectifsChart').getContext('2d');
            new Chart(objectifsCtx, {
                type: 'bar',
                data: {
                    labels: objLabels,
                    datasets: [{
                        label: 'Nombre d\'utilisateurs',
                        data: objCounts,
                        backgroundColor: '#667eea',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Graphe Calories
            const calLabels = caloriesData.map(cal => cal.nom || 'N/A');
            const calValues = caloriesData.map(cal => parseInt(cal.calories_moyennes) || 0);

            const caloriesCtx = document.getElementById('caloriesChart').getContext('2d');
            new Chart(caloriesCtx, {
                type: 'line',
                data: {
                    labels: calLabels,
                    datasets: [{
                        label: 'Calories moyennes',
                        data: calValues,
                        borderColor: '#f39c12',
                        backgroundColor: 'rgba(243, 156, 18, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>