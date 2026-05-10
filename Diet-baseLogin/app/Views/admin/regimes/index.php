<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des régimes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= view('admin/styles') ?>
</head>
<body>
    <?= view('admin/navbar') ?>
    
    <div class="page-container">
        <div class="content-container">
        <h1>Gestion des régimes alimentaires</h1>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <a href="/admin/regimes/create" class="btn btn-add">+ Ajouter un régime</a>
        <a href="/logout" class="btn btn-back">Déconnexion</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>% Viande</th>
                    <th>% Poisson</th>
                    <th>% Volaille</th>
                    <th>Effet/semaine</th>
                    <th>Prix/jour</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($regimes as $regime): ?>
                <tr id="row-<?= $regime['id'] ?>">
                    <td><?= $regime['id'] ?></td>
                    <td><?= esc($regime['nom']) ?></td>
                    <td><?= $regime['pourcentage_viande'] ?>%</td>
                    <td><?= $regime['pourcentage_poisson'] ?>%</td>
                    <td><?= $regime['pourcentage_volaille'] ?>%</td>
                    <td><?= $regime['effet_poids_par_semaine'] > 0 ? '+' : '' ?><?= $regime['effet_poids_par_semaine'] ?> kg</td>
                    <td><?= $regime['prix_par_jour'] ?> €</td>
                    <td>
                        <a href="/admin/regimes/edit/<?= $regime['id'] ?>" class="btn-edit">Modifier</a>
                        <button class="btn-delete" data-id="<?= $regime['id'] ?>" data-nom="<?= esc($regime['nom']) ?>">Supprimer</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

    <script>
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            var nom = $(this).data('nom');
            
            if(confirm('Supprimer le régime "' + nom + '" ?')) {
                $.ajax({
                    url: '/admin/regimes/delete/' + id,
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
</body>
</html>