<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate Database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if data is set
if (!isset($data->category)) {
    // If not, send error message
    echo json_encode(array('message' => 'Missing Required Parameters'));
} else {
    // Set category property and create category
    $category->category = $data->category;
    $category->create();
    // Respond with the created category's ID and name
    echo json_encode(array('id' => $db->lastInsertId(), 'category' => $category->category));
}
