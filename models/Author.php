<?php

// Class representing authors
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    // Constructor to set up the database connection
    public function __construct($database) {
        $this->conn = $database;
    }

    // Method to fetch all authors
    public function read() {
        // Query to select all authors
        $query = "SELECT
                    id,
                    author
                    FROM {$this->table}
                    ORDER BY id ASC";

        // Prepare and execute the statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Return the statement
        return $stmt;
    }

    // Method to fetch a single author by ID
    public function read_single() {
        // Query to select a single author by ID
        $query = "SELECT
                    id,
                    author
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
            $this->author = $row['author'];
            return true;
        } else {
            return false;
        }
    }

    // Method to create a new author
    public function create() {
        // Query to insert a new author
        $query = "INSERT INTO {$this->table} (author) VALUES (:author)";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind the author parameter
        $this->author = htmlspecialchars(strip_tags($this->author));
        $stmt->bindParam(':author', $this->author);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Method to update an existing author
    public function update() {
        // Query to update an author
        $query = 'UPDATE ' . $this->table . '
            SET
                author = :author
            WHERE
                id = :id';

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind the parameters
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Method to delete an author
    public function delete() {
        // Query to delete an author
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
