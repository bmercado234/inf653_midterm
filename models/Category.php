<?php

// Class representing categories
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    // Constructor to set up the database connection
    public function __construct($database) {
        $this->conn = $database;
    }

    // Method to fetch all categories
    public function read() {
        // Query to select all categories
        $query = "SELECT
                    id,
                    category
                    FROM {$this->table}
                    ORDER BY id ASC";

        // Prepare and execute the statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Return the statement
        return $stmt;
    }

    // Method to fetch a single category by ID
    public function read_single() {
        // Query to select a single category by ID
        $query = "SELECT
                    id,
                    category
                    FROM {$this->table}
                    WHERE id = :id
                    LIMIT 1 OFFSET 0";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind the ID parameter
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // Execute the statement
        $stmt->execute();

        // Retrieve and set the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->category = $row['category'];
            return true;
        } else {
            return false;
        }
    }

    // Method to create a new category
    public function create() {
        // Query to insert a new category
        $query = "INSERT INTO {$this->table} (category) VALUES (:category)";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind the category parameter
        $this->category = htmlspecialchars(strip_tags($this->category));
        $stmt->bindParam(':category', $this->category);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Method to update an existing category
    public function update() {
        // Query to update a category
        $query = 'UPDATE ' . $this->table . '
            SET
                category = :category
            WHERE
                id = :id';

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind the parameters
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Method to delete a category
    public function delete() {
        // Query to delete a category
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind the ID parameter
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
