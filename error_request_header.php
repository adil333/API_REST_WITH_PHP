<?php 
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
http_response_code(405);
    echo json_encode([
        "message" => "La méthode n'est pas autorisée"
    ], JSON_UNESCAPED_UNICODE);