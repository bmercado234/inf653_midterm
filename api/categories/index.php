<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight OPTIONS request
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Include necessary files
include_once '../../config/Database.php';

// Determine the type of request
switch ($method) {
    case 'GET':
        // Handle GET request
        try {
            if (isset($_GET['id'])) {
                require_once 'read_single.php';
            } else {
                require_once 'read.php';
            }
        } catch (ErrorException $e) {
            echo("Required file not found!");
        }
        break;
    case 'POST':
        // Handle POST request
        try {
            require_once 'create.php';
        } catch (ErrorException $e) {
            echo("Required file not found!");
        }
        break;
    case 'PUT':
        // Handle PUT request
        try {
            require_once 'update.php';
        } catch (ErrorException $e) {
            echo("Required file not found!");
        }
        break;
    case 'DELETE':
        // Handle DELETE request
        try {
            require_once 'delete.php';
        } catch (ErrorException $e) {
            echo("Required file not found!");
        }
        break;
    default:
        echo "No function requested";
}
