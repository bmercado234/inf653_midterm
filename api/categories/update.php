<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate Database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

// Get raw POST data
$data = json_decode(file_get_contents("php://input"));

// Check if data is set
if (!isset($data->id) || !isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set ID and category to update
$category->id = $data->id;
$category->category = $data->category;

// Update category
if ($category->update()) {
    echo json_encode(
        array(
            'id' => $category->id,
            'category' => $category->category
        )
    );
} else {
    echo json_encode(
        array(
            'message' => 'category_id Not Found'
        )
    );
}
