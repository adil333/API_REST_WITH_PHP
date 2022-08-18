<?php

$method = $_SERVER["REQUEST_METHOD"];
$URL = trim($_SERVER["REQUEST_URI"]);
$URL = explode('/', $URL);
$nb = count($URL);
spl_autoload_register(function ($class) {
    if (file_exists("config/" . $class . '.php')) {
        include "config/" . $class . '.php';
    } else {
        include "modals/" . $class . '.php';
    }
});
switch ($nb) {
    case 3:
        if ($URL[2] == 'products') {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    require 'Geteway/create.php';
                    break;
                case 'GET':
                    require 'Geteway/read.php';
                    break;
                default:
                    require 'error_request_header.php';
                    break;
            }
        } else {
            require 'error_url.php';
        }
        break;

    case 4:
        $URL[3] = (int)$URL[3];
        if ($URL[2] == 'products' && is_int($URL[3]) && $URL[3] != 0) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    require 'Geteway/readOne.php';
                    break;
                case 'PUT':
                    require 'Geteway/update.php';
                    break;
                case 'DELETE':
                    require 'Geteway/delete.php';;
                    break;
                default:
                    require 'error_request_header.php';
                    break;
            }
        } else {
            require 'error_url.php';
        }
        break;

    default:
        echo "note founderd sorry";
        break;
}
