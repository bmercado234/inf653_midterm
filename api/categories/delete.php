<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and CONNECT
$database = new Database();
$db = $database->connect();

// Instantiate blog category object
$cat = new Category($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if data is set
if (!isset($data->id)) {
    echo(json_encode(array('message' => 'Missing Required Parameters')));
    exit();
} else {
    // Set id and delete
    $cat->id = $data->id;
    $cat->delete();
    echo(json_encode(array('id' => $cat->id)));
}
