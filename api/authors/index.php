<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight OPTIONS request
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Handle different request methods
if ($method === 'GET') {
    try {
        // Determine which endpoint to use based on the presence of 'id' parameter
        if (isset($_GET['id'])) {
            require_once 'read_single.php';
        } else {
            require_once 'read.php';
        }
    } catch (ErrorException $e) {
        echo "Required file not found!";
    }
} elseif ($method === 'POST') {
    try {
        require_once 'create.php';
    } catch (ErrorException $e) {
        echo "Required file not found!";
    }
} elseif ($method === 'PUT') {
    try {
        require_once 'update.php';
    } catch (ErrorException $e) {
        echo "Required file not found!";
    }
} elseif ($method === 'DELETE') {
    try {
        require_once 'delete.php';
    } catch (ErrorException $e) {
        echo "Required file not found!";
    }
} else {
    echo "No function requested";
}
