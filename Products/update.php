<?php

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: PUT");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    include_once '../config/Database.php';
    include_once '../modals/Products.php';
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $product = new Products($database);

    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id) && !empty($data->nom) && !empty($data->description) && isset($data->prix) && !empty($data->categories_id)) {
        $product->id  =  $data->id;
        $product->name  =  $data->nom;
        $product->description = $data->description;
        $product->price = $data->prix? "0": "0.0";
        $product->category_id = $data->categories_id;
        $result = $product->update();
       
        if ($result == true) {

            http_response_code(200);
            echo json_encode([
                "message" => "La Modification a été effectué"
                
            ]);
        } else {
            http_response_code(503);
            echo json_encode([
                "message" => "La Modification a été echouée"
            ]);
        }
    }else {
        http_response_code(404);
        echo json_encode([
            "message" => "les informations de modiffication ne sont pas bien rempli"
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ]);
}
