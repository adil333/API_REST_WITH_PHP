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
    include_once '../config/Database.php';
    include_once '../modals/Products.php';
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);
    $donnees = json_decode(file_get_contents("php://input"));
    if (!empty($donnees->id)) {
        $products->id = $donnees->id;
        $stmt = $products->readOne();
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode([
                "message" => "le produit avec  id: ".$donnees->id . " n'exite pas"
            ]);
        }
    }else{
        http_response_code(404);
            echo json_encode([
                "message" => "l'id du produit a renvoyer n'est pas difini"
            ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ]);
}
