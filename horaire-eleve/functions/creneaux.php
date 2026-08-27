<?php

function getCreneaux($pdo)
{
    $sql = '
        SELECT
            creneaux.id,
            classes.nom AS classe,
            classes.annee_scolaire,
            cours.code AS code_cours,
            cours.nom AS cours,
            creneaux.jour,
            creneaux.heure_debut,
            creneaux.heure_fin,
            creneaux.salle
        FROM creneaux
        INNER JOIN classes ON creneaux.classe_id = classes.id
        INNER JOIN cours ON creneaux.cours_id = cours.id
        ORDER BY classes.nom, creneaux.jour, creneaux.heure_debut
    ';

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function addCreneau($pdo, $classe_id, $cours_id, $jour, $heure_debut, $heure_fin, $salle)
{
    $sql = '
        INSERT INTO creneaux
        (classe_id, cours_id, jour, heure_debut, heure_fin, salle)
        VALUES
        (:classe_id, :cours_id, :jour, :heure_debut, :heure_fin, :salle)
    ';

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'classe_id' => $classe_id,
        'cours_id' => $cours_id,
        'jour' => $jour,
        'heure_debut' => $heure_debut,
        'heure_fin' => $heure_fin,
        'salle' => $salle
    ]);
}

function updateCreneau($pdo, $id, $classe_id, $cours_id, $jour, $heure_debut, $heure_fin, $salle)
{
    $sql = '
        UPDATE creneaux
        SET classe_id = :classe_id,
            cours_id = :cours_id,
            jour = :jour,
            heure_debut = :heure_debut,
            heure_fin = :heure_fin,
            salle = :salle
        WHERE id = :id
    ';

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'id' => $id,
        'classe_id' => $classe_id,
        'cours_id' => $cours_id,
        'jour' => $jour,
        'heure_debut' => $heure_debut,
        'heure_fin' => $heure_fin,
        'salle' => $salle
    ]);
}

function deleteCreneau($pdo, $id)
{
    $sql = 'DELETE FROM creneaux WHERE id = :id';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'id' => $id
    ]);
}

function getCreneauxByClasse($pdo, $classe)
{
    $sql = '
        SELECT
            classes.nom AS classe,
            classes.annee_scolaire,
            creneaux.jour,
            TIME_FORMAT(creneaux.heure_debut, "%H:%i") AS heure_debut,
            TIME_FORMAT(creneaux.heure_fin, "%H:%i") AS heure_fin,
            cours.nom AS cours,
            cours.code AS code_cours,
            creneaux.salle
        FROM creneaux
        INNER JOIN classes ON creneaux.classe_id = classes.id
        INNER JOIN cours ON creneaux.cours_id = cours.id
        WHERE classes.nom = :classe
        ORDER BY creneaux.jour, creneaux.heure_debut
    ';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'classe' => $classe
    ]);

    return $stmt->fetchAll();
}