<?php
$servername = "localhost";
$username = "ziks";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=expensly_db", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
