<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des activités sportives</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= view('admin/styles') ?>
</head>
<body>
    <?= view('admin/navbar') ?>
    
    <div class="page-container">
        <div class="content-container">
        <h1>Gestion des activités sportives</h1>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <a href="/admin/activites/create" class="btn btn-add">+ Ajouter une activité</a>
        <a href="/admin/regimes" class="btn btn-back">← Gérer les régimes</a>
        <a href="/logout" class="btn btn-back">Déconnexion</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Durée (min)</th>
                    <th>Calories/heure</th>
                    <th>Difficulté</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($activites as $activite): ?>
                <tr id="row-<?= $activite['id'] ?>">
                    <td><?= $activite['id'] ?></td>
                    <td><?= esc($activite['nom']) ?></td>
                    <td><?= $activite['duree_minutes'] ?> min</td>
                    <td><?= $activite['calories_par_heure'] ?> cal</td>
                    <td>
                        <span class="difficulte <?= $activite['difficulte'] ?>">
                            <?= ucfirst($activite['difficulte']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="/admin/activites/edit/<?= $activite['id'] ?>" class="btn-edit">Modifier</a>
                        <button class="btn-delete" data-id="<?= $activite['id'] ?>" data-nom="<?= esc($activite['nom']) ?>">Supprimer</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            var nom = $(this).data('nom');
            
            if(confirm('Supprimer l\'activité "' + nom + '" ?')) {
                $.ajax({
                    url: '/admin/activites/delete/' + id,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            $('#row-' + id).fadeOut();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Erreur lors de la suppression');
                    }
                });
            }
        });
    </script>
        </div>
    </div>
</body>
</html>