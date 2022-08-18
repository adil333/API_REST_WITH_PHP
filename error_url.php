<?php 
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
 http_response_code(405);
 echo json_encode([
     "message" => "Erreur URL ::le dernier argument doit etre un entier "
 ], JSON_UNESCAPED_UNICODE);