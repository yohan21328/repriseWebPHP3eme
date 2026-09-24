<?php

require_once __DIR__ . '/../connexion/db.php';
require_once __DIR__ . '/../functions/cours.php';

$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
        addCours(
            $pdo,
            $_POST['code'],
            $_POST['nom']
        );
    }

    if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        deleteCours($pdo, $_POST['id']);
    }

    header('Location: cours.php');
    exit;
}

$cours = getCours($pdo);

require_once __DIR__ . '/../includes/header.php';
?>

<h1>Cours</h1>

<h2>Ajouter un cours</h2>

<form method="POST" class="p-3 bg-white rounded shadow-sm">
    <input type="hidden" name="action" value="ajouter">

    <label class="me-3">
        Code :
        <input type="text" name="code" class="form-control" required>
    </label>

    <label class="me-3">
        Nom :
        <input type="text" name="nom" class="form-control" required>
    </label>

    <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
</form>

<h2>Cours existants</h2>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Nom</th>
        <th>Action</th>
    </tr>

    <?php foreach ($cours as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['id']) ?></td>
            <td><?= htmlspecialchars($item['code']) ?></td>
            <td><?= htmlspecialchars($item['nom']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="action" value="supprimer">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>