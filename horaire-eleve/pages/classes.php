<?php

require_once __DIR__ . '/../connexion/db.php';
require_once __DIR__ . '/../functions/classes.php';

$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
        addClasse(
            $pdo,
            $_POST['nom'],
            $_POST['annee_scolaire']
        );
    }

    if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        deleteClasse($pdo, $_POST['id']);
    }

    header('Location: classes.php');
    exit;
}

$classes = getClasses($pdo);

require_once __DIR__ . '/../includes/header.php';
?>

<h1>Classes</h1>

<h2>Ajouter une classe</h2>

<form method="POST">
    <input type="hidden" name="action" value="ajouter">

    <label>
        Nom :
        <input type="text" name="nom" required>
    </label>

    <label>
        Année scolaire :
        <input type="text" name="annee_scolaire" placeholder="2026-2027" required>
    </label>

    <button type="submit">Ajouter</button>
</form>

<h2>Classes existantes</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Année scolaire</th>
        <th>Action</th>
    </tr>

    <?php foreach ($classes as $classe): ?>
        <tr>
            <td><?= htmlspecialchars($classe['id']) ?></td>
            <td><?= htmlspecialchars($classe['nom']) ?></td>
            <td><?= htmlspecialchars($classe['annee_scolaire']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="action" value="supprimer">
                    <input type="hidden" name="id" value="<?= $classe['id'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>