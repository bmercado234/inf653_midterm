<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate Database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if required data is set
if (!isset($data->id) || !isset($data->author)) {
    // If not, send error message and exit
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set ID and author to update
$author->id = $data->id;
$author->author = $data->author;

// Update author
if ($author->update()) {
    // If successful, encode and return the updated author data
    echo json_encode(array(
        'id' => $author->id,
        'author' => $author->author
    ));
} else {
    // If author ID not found, return error message
    echo json_encode(array(
        'message' => 'author_id Not Found'
    ));
}
