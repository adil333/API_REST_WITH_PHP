<?php

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header('Content-Type: application/json;  charset=utf-8');

// Méthode autorisée
header("Access-Control-Allow-Methods: PUT");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $product = new Products($database);

    $data = json_decode(file_get_contents("php://input"));
    if (!empty($URL[3]) && !empty($data->nom) && !empty($data->description) && isset($data->prix) && !empty($data->categories_id)) {
        $product->id  =  $URL[3];
        $product->name  =  $data->nom;
        $product->description = $data->description;
        $product->price = $data->prix;
        $product->category_id = $data->categories_id;
          //on appel la methode readone pôur verifier que l'article a modifier est prisent dans la base de donnee
          $stmt = $product->readOne();

          if ($stmt->rowCount() == 1){
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
                ], JSON_UNESCAPED_UNICODE);
            }
          }else{
            http_response_code(404);
            echo json_encode([
                "message" => "L'article a modifier n'est pas valide"
                
            ]);
          }
    }else {
        http_response_code(404);
        echo json_encode([
            "message" => "les informations de modiffication ne sont pas bien rempli"
        ], JSON_UNESCAPED_UNICODE);
    }
} else {

    http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ], JSON_UNESCAPED_UNICODE);
}
