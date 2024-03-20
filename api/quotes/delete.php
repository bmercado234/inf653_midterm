<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB and CONNECT
$database = new Database();
$db = $database->connect();

// Instantiate blog quote object
$quo = new Quote($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if data is set
if (!isset($data->id)) {
    echo(json_encode(array('message' => 'Missing Required parameters')));
    exit();
}

// Set ID to delete
$quo->id = $data->id;

// Delete quote
if ($quo->delete()) {
    echo json_encode(
        array('id' => $quo->id)
    );
} else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}
