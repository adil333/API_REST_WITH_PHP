<?php

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: GET");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);
    $stmt = $products->readAll();
    // On envoie le code réponse 200 OK
    http_response_code(200);
    if ($stmt->rowCount() > 0) {
        // On encode en json et on envoie
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }else{
        echo json_encode(["message" => "Aucun Produit Pour le moment"], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "on est dans le get La méthode n'est pas autorisée"], JSON_UNESCAPED_UNICODE);
}
