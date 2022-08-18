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

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);
    if (isset($URL[3]) && !empty($URL[3])) {
        $products->id = $URL[3];
        $stmt = $products->readOne();
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode([
                "message" => "le produit avec  id: ".$products->id. " n'exite pas"
            ], JSON_UNESCAPED_UNICODE);
        }
    }else{
        http_response_code(404);
            echo json_encode([
                "message" => "l'id du produit a renvoyer n'est pas difini ou n'est pas correct"
            ], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ], JSON_UNESCAPED_UNICODE);
}
