<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des régimes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        h1 { margin-bottom: 20px; color: #333; }
        .btn { display: inline-block; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-right: 10px; }
        .btn-add { background: #28a745; color: white; }
        .btn-edit { background: #007bff; color: white; }
        .btn-delete { background: #dc3545; color: white; border: none; cursor: pointer; }
        .btn-back { background: #6c757d; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
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