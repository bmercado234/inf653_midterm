<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate Database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

// Get ID from URL parameter or die if not set
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read single category
if ($category->read_single()) {
    // If found, encode and return the category data
    echo json_encode(array(
        'id' => $category->id,
        'category' => $category->category
    ));
} else {
    // If category ID not found, return error message
    echo json_encode(array(
        'message' => 'category_id Not Found'
    ));
}
