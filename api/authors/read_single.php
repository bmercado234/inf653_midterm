<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate Database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

// Get ID from request, or exit if not provided
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Attempt to fetch author data by ID
if ($author->read_single()) {
    // If author found, encode and return the data
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
