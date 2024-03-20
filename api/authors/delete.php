<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include database configuration and Author model
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate Database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if ID is set in the data
if (!isset($data->id)) {
    // If not, send error message and exit
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
} else {
    // Set the ID property and delete author
    $author->id = $data->id;
    $author->delete();
    // Respond with the deleted author's ID
    echo json_encode(array('id' => $author->id));
}
