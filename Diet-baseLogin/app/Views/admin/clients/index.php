<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des clients</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= view('admin/styles') ?>
</head>
<body>
    <?= view('admin/navbar') ?>
    
    <div class="page-container">
        <div class="content-container">
            <h1>Gestion des clients</h1>
            
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Genre</th>
                        <th>Taille (m)</th>
                        <th>Poids (kg)</th>
                        <th>IMC</th>
                        <th>Gold</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clients)): ?>
                        <?php foreach($clients as $client): ?>
                        <tr id="row-<?= $client['id'] ?>">
                            <td><?= $client['id'] ?></td>
                            <td><?= esc($client['nom']) ?></td>
                            <td><?= esc($client['email']) ?></td>
                            <td><?= ucfirst($client['genre']) ?></td>
                            <td><?= $client['taille'] ?></td>
                            <td><?= $client['poids'] ?></td>
                            <td><?= $client['imc'] ?? 'N/A' ?></td>
                            <td>
                                <?php if($client['is_gold']): ?>
                                    <span style="background: #ffc107; padding: 3px 8px; border-radius: 3px; font-weight: bold;">✓ Gold</span>
                                <?php else: ?>
                                    <span style="color: #999;">Non</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/clients/view/<?= $client['id'] ?>" class="btn-edit">Voir</a>
                                <button class="btn-delete" data-id="<?= $client['id'] ?>" data-nom="<?= esc($client['nom']) ?>">Supprimer</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 20px; color: #999;">
                                Aucun client enregistré
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            var nom = $(this).data('nom');
            
            if(confirm('Supprimer le client "' + nom + '" ? Cette action est irréversible.')) {
                $.ajax({
                    url: '/admin/clients/delete/' + id,
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
