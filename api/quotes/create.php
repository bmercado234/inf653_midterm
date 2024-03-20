<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

// Instantiate DB and CONNECT
$database = new Database();
$db = $database->connect();

// Instantiate blog quote object
$quo = new Quote($db);

// Create author and category object
$aut = new Author($db);
$cat = new Category($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if data is all set
if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set Data
$quo->quote = $data->quote;
$quo->author_id = $data->author_id;
$quo->category_id = $data->category_id;

$aut->id = $data->author_id;
$cat->id = $data->category_id;

// Check category
$cat->read_single();
if (!$cat->category) {
    echo json_encode(array('message' => 'category_id Not Found'));
    exit();
}
// Check author
$aut->read_single();
if (!$aut->author) {
    echo json_encode(array('message' => 'author_id Not Found'));
    exit();
}

// Create quote
if ($quo->create()) {
    echo json_encode(
        array(
            'id' => $quo->id,
            'quote' => $quo->quote,
            'author_id' => $quo->author_id,
            'category_id' => $quo->category_id
    ));
} else {
    echo json_encode(array('message' => 'No Quotes Found'));
}
