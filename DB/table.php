<?php
require_once 'connect.php';

$db_table = "CREATE TABLE IF NOT EXISTS `profiles` (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(60) NOT NULL,
nickname VARCHAR(50) NOT NULL UNIQUE,
email VARCHAR(100) NOT NULL UNIQUE,
pass VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if ($conn->query($db_table)) {
  echo "Table created successfully";
} else {
  $errorInfo = $conn->errorInfo();
  echo "Error creating table: " . $errorInfo[2];
}

$conn = null;