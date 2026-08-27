<?php

function getCours($pdo)
{
    $sql = 'SELECT * FROM cours ORDER BY code';
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function addCours($pdo, $code, $nom)
{
    $sql = 'INSERT INTO cours (code, nom) VALUES (:code, :nom)';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'code' => $code,
        'nom' => $nom
    ]);
}

function deleteCours($pdo, $id)
{
    $sql = 'DELETE FROM cours WHERE id = :id';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'id' => $id
    ]);
}