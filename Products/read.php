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


if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    include_once '../config/Database.php';
    include_once '../modals/Products.php';
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);
    $stmt = $products->readAll();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

}else {
    http_response_code(405);
    echo json_encode(["message"=> "La méthode n'est pas autorisée"]);
}