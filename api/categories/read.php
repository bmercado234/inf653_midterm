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

// Query to retrieve categories
$result = $category->read();

// Get row count
$num = $result->rowCount();

// Check if any categories found
if ($num > 0) {
    // Initialize category array
    $category_arr = array();

    // Loop through results and extract data
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Create array for each category
        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        // Push category data to category array
        array_push($category_arr, $category_item);
    }

    // Convert category array to JSON and output
    echo json_encode($category_arr);
} else {
    // No categories found, return error message
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
}
