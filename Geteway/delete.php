<?php 

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: DELETE");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);

    if (isset($URL[3]) && !empty($URL[3])){
        $products->id  =  $URL[3];
        $result = $products->delete();
        $count = $result->rowCount();
        if($result == true){
           
            http_response_code(200);
            echo json_encode([
                "message" => "La suppression a été effectué",
                "rows_affected" => $count
            ], JSON_UNESCAPED_UNICODE);

        }else{

            http_response_code(503);
            echo json_encode([
                "message" => "La suppression a echouée",
                "rows_affected" => $count
            ], JSON_UNESCAPED_UNICODE);

        }  

    }
}else{
    http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ], JSON_UNESCAPED_UNICODE);
}