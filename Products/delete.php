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
    include_once '../config/Database.php';
    include_once '../modals/Products.php';
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);

    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id)){
        $products->id  =  $data->id;
        $result = $products->delete();
        $count = $result->rowCount();
        if($result == true){
           
            http_response_code(200);
            echo json_encode([
                "message" => "La suppression a été effectué",
                "rows_affected" => $count
            ]);

        }else{

            http_response_code(503);
            echo json_encode([
                "message" => "La suppression a echouée",
                "rows_affected" => $count
            ]);

        }  

    }
}else{
    http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ]);
}