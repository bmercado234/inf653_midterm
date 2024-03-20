<?php

// Class representing quotes
class Quote {
    // Database connection and table name
    private $conn;
    private $table = 'quotes';

    // Properties of a quote
    public $id;
    public $category_id;
    public $author_id;
    public $author;
    public $category;
    public $quote;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to retrieve quotes
    public function read() {
        // Construct query based on provided parameters
        $query = "SELECT
                    q.id,
                    q.quote,
                    a.author as author,
                    c.category as category
                    FROM {$this->table} q
                    INNER JOIN authors a ON q.author_id = a.id
                    INNER JOIN categories c ON q.category_id = c.id";

        if (isset($this->author_id) && isset($this->category_id)) {
            $query .= " WHERE a.id = :author_id AND c.id = :category_id";
        } else if (isset($this->author_id)) {
            $query .= " WHERE a.id = :author_id";
        } else if (isset($this->category_id)) {
            $query .= " WHERE c.id = :category_id";
        }

        // Append ordering
        $query .= " ORDER BY q.id ASC";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters if they exist
        if ($this->author_id) {
            $stmt->bindParam(':author_id', $this->author_id);
        }
        if ($this->category_id) {
            $stmt->bindParam(':category_id', $this->category_id);
        }

        // Execute statement
        $stmt->execute();

        // Return statement
        return $stmt;
    }

    // Method to retrieve a single quote by ID
    public function read_single() {
        // Query to select a single quote by ID
        $query = "SELECT
                     q.id,
                     q.quote,
                     a.author as author,
                     c.category as category
                     FROM {$this->table} q
                     INNER JOIN authors a ON q.author_id = a.id
                     INNER JOIN categories c ON q.category_id = c.id
                     WHERE q.id = :id
                     LIMIT 1 OFFSET 0";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the ID parameter
        $stmt->bindParam(':id', $this->id);

        // Execute statement
        $stmt->execute();

        // Fetch data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties if data exists
        if ($row) {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->category = $row['category'];
            $this->author = $row['author'];
            return true;
        } else {
            return false; // No data
        }
    }

    // Method to create a quote
    public function create() {
        // Query to insert a new quote
        $query = "INSERT INTO {$this->table} (quote, category_id, author_id)
                  VALUES (:quote, :author_id, :category_id)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute statement
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Method to update a quote
    public function update() {
        // Query to update a quote
        $query = 'UPDATE ' . $this->table . '
                  SET
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                  WHERE
                    id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Method to delete a quote
    public function delete() {
        // Query to delete a quote
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and bind data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // Execute statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
