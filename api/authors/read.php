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

// Blog author query
$result = $author->read();

// Get row count
$num = $result->rowCount();

// Check if any authors
if ($num > 0) {
    // Initialize author array
    $author_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Create author item
        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        // Push author item to "data"
        array_push($author_arr, $author_item);
    }

    // Encode to JSON and output
    echo json_encode($author_arr);
} else {
    // No authors found
    echo json_encode(
        array('message' => 'No authors found')
    );
}
