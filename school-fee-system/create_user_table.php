<?php
include 'config/database.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($pdo->exec($sql)) {
    echo "User table created successfully.";
} else {
    echo "Error creating user table: " . $pdo->errorInfo()[2];
}
?>
