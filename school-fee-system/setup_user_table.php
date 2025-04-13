<?php
$host = 'localhost';
$db = 'school_fee_system';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
