<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate blog quote object
$quo = new Quote($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if data is set
if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set ID to update
$quo->id = $data->id;
$quo->quote = $data->quote;
$quo->author_id = $data->author_id;
$quo->category_id = $data->category_id;

// Instantiate author and category objects
$aut = new Author($db);
$cat = new Category($db);
$aut->id = $quo->author_id;
$cat->id = $quo->category_id;

// Conduct checks on category and author ids
$cat->read_single();
if (!$cat->category) {
    echo json_encode(array(
        'message' => 'category_id Not Found'
    ));
    exit();
}

$aut->read_single();
if (!$aut->author) {
    echo json_encode(array(
        'message' => 'author_id Not Found'
    ));
    exit();
}

// Update quotes
if ($quo->update()) {
    echo json_encode(
        array(
            'id' => $quo->id,
            'quote' => $quo->quote,
            'author_id' => $quo->author_id,
            'category_id' => $quo->category_id
    ));
} else {
    echo json_encode(
        array(
            'message' => 'No Quotes Found'
    ));
}
