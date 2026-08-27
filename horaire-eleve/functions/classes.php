<?php

function getClasses($pdo)
{
    $sql = 'SELECT * FROM classes ORDER BY nom';
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function addClasse($pdo, $nom, $annee_scolaire)
{
    $sql = 'INSERT INTO classes (nom, annee_scolaire) VALUES (:nom, :annee_scolaire)';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'nom' => $nom,
        'annee_scolaire' => $annee_scolaire
    ]);
}

function deleteClasse($pdo, $id)
{
    $sql = 'DELETE FROM classes WHERE id = :id';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'id' => $id
    ]);
}