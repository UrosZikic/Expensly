<?php
require_once "../DB/connect.php";
session_start();

$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS);
$nickname = $_POST['nickname'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$pass_hash = password_hash($password, PASSWORD_DEFAULT);
$re_pass = $_POST['re_pass'];


$memorize_signup_details = ['name' => $full_name, 'nick_name' => $nickname, "email" => $email, "password" => $password];
$_SESSION['m_s_d'] = $memorize_signup_details;

if (!$email) {
  Header("Location: sign_up.php");
  exit;
}

if ($password !== $re_pass) {

  Header("Location: sign_up.php?error=10010");
  exit;
}

// try {
$stmt = $conn->prepare("INSERT INTO profiles (full_name, nickname, email, pass)
                            VALUES (:full_name, :nickname, :email, :pass)");

$stmt->bindParam(':full_name', $full_name);
$stmt->bindParam(':nickname', $nickname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':pass', $password);

try {
  $stmt->execute();
  echo "<p>Success</p>";
} catch (PDOException $e) {
  if ($e->getCode() == 23000) {
    // Duplicate entry error
    header('Location: sign_up.php?error=duplicate_email');
    exit;
  } else {
    // Other database error
    echo "Database error: " . $e->getMessage();
  }
}

?>