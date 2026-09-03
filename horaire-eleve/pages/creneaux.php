<?php

require_once __DIR__ . '/../connexion/db.php';
require_once __DIR__ . '/../functions/classes.php';
require_once __DIR__ . '/../functions/cours.php';
require_once __DIR__ . '/../functions/creneaux.php';

$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
        addCreneau(
            $pdo,
            $_POST['classe_id'],
            $_POST['cours_id'],
            $_POST['jour'],
            $_POST['heure_debut'],
            $_POST['heure_fin'],
            $_POST['salle']
        );
    }

    if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        deleteCreneau($pdo, $_POST['id']);
    }

    header('Location: creneaux.php');
    exit;
}

$classes = getClasses($pdo);
$cours = getCours($pdo);
$creneaux = getCreneaux($pdo);

require_once __DIR__ . '/../includes/header.php';
?>

<h1>Créneaux</h1>

<h2>Ajouter un créneau</h2>

<form method="POST">
    <input type="hidden" name="action" value="ajouter">

    <label>
        Classe :
        <select name="classe_id" required>
            <?php foreach ($classes as $classe): ?>
                <option value="<?= $classe['id'] ?>">
                    <?= htmlspecialchars($classe['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Cours :
        <select name="cours_id" required>
            <?php foreach ($cours as $item): ?>
                <option value="<?= $item['id'] ?>">
                    <?= htmlspecialchars($item['code']) ?>
                    - <?= htmlspecialchars($item['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Jour :
        <select name="jour" required>
            <option value="lundi">Lundi</option>
            <option value="mardi">Mardi</option>
            <option value="mercredi">Mercredi</option>
            <option value="jeudi">Jeudi</option>
            <option value="vendredi">Vendredi</option>
        </select>
    </label>

    <label>
        Début :
        <input type="time" name="heure_debut" required>
    </label>

    <label>
        Fin :
        <input type="time" name="heure_fin" required>
    </label>

    <label>
        Salle :
        <input type="text" name="salle" required>
    </label>

    <button type="submit">Ajouter</button>
</form>

<h2>Créneaux</h2>

<table border="1">
    <tr>
        <th>Classe</th>
        <th>Cours</th>
        <th>Jour</th>
        <th>Heure</th>
        <th>Salle</th>
        <th>Action</th>
    </tr>

    <?php foreach ($creneaux as $creneau): ?>
        <tr>
            <td><?= htmlspecialchars($creneau['classe']) ?></td>
            <td>
                <?= htmlspecialchars($creneau['code_cours']) ?>
                - <?= htmlspecialchars($creneau['cours']) ?>
            </td>
            <td><?= htmlspecialchars($creneau['jour']) ?></td>
            <td>
                <?= htmlspecialchars(substr($creneau['heure_debut'], 0, 5)) ?>
                -
                <?= htmlspecialchars(substr($creneau['heure_fin'], 0, 5)) ?>
            </td>
            <td><?= htmlspecialchars($creneau['salle']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="action" value="supprimer">
                    <input type="hidden" name="id" value="<?= $creneau['id'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>