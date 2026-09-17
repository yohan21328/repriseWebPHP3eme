<?php

require_once __DIR__ . '/../connexion/db.php';
require_once __DIR__ . '/../functions/classes.php';
require_once __DIR__ . '/../functions/cours.php';
require_once __DIR__ . '/../functions/creneaux.php';

header('Content-Type: application/json; charset=utf-8');

$pdo = getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$resource = $_GET['resource'] ?? '';

function response($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($resource === 'classes') {
    if ($method === 'GET') {
        response(getClasses($pdo));
    }

    response(['message' => 'Méthode non autorisée'], 405);
}

if ($resource === 'cours') {
    if ($method === 'GET') {
        if (isset($_GET['classe'])) {
            $horaires = getCreneauxByClasse($pdo, $_GET['classe']);

            if (count($horaires) === 0) {
                response(['message' => 'Classe introuvable'], 404);
            }

            response([
                'classe' => $horaires[0]['classe'],
                'annee_scolaire' => $horaires[0]['annee_scolaire'],
                'horaires' => $horaires
            ]);
        }

        response(getCours($pdo));
    }

    response(['message' => 'Méthode non autorisée'], 405);
}

if ($resource === 'creneaux') {
    if ($method === 'GET') {
        response(getCreneaux($pdo));
    }

    if ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset(
            $data['id'],
            $data['classe_id'],
            $data['cours_id'],
            $data['jour'],
            $data['heure_debut'],
            $data['heure_fin'],
            $data['salle']
        )) {
            response(['message' => 'Données manquantes'], 400);
        }

        updateCreneau(
            $pdo,
            $data['id'],
            $data['classe_id'],
            $data['cours_id'],
            $data['jour'],
            $data['heure_debut'],
            $data['heure_fin'],
            $data['salle']
        );

        response(['message' => 'Créneau modifié']);
    }

    if ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id'])) {
            response(['message' => 'ID manquant'], 400);
        }

        deleteCreneau($pdo, $data['id']);

        response(['message' => 'Créneau supprimé']);
    }

    response(['message' => 'Méthode non autorisée'], 405);
}

response(['message' => 'Ressource introuvable'], 404);