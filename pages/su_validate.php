<?php
require_once "../DB/connect.php";
session_start();

$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS);
$nickname = $_POST['nickname'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$pass_hash = password_hash($password, PASSWORD_DEFAULT);
$re_pass = $_POST['re_pass'];


$memorize_signup_details = ['full_name' => $full_name, 'nick_name' => $nickname, "email" => $email, "password" => $password, 'error' => ""];
$_SESSION['m_s_d'] = $memorize_signup_details;

if (!$email) {
  $memorize_signup_details['error'] = 'email_invalid';
  $memorize_signup_details['email'] = '';
  $_SESSION['m_s_d'] = $memorize_signup_details;
  Header("Location: sign_up.php");
  exit;
}

// Validate email
$stmt_e = $conn->prepare("SELECT email FROM profiles WHERE email = :email");
$stmt_e->bindParam(':email', $email);
$stmt_e->execute();
$emails = $stmt_e->fetch(PDO::FETCH_ASSOC);
if ($emails) {
  $memorize_signup_details['error'] = 'email_duplicate';
  $memorize_signup_details['email'] = "";
  $_SESSION['m_s_d'] = $memorize_signup_details;

  Header("Location: sign_up.php?email=duplicate");
  exit;
}
// Validate nickname
$stmt_nn = $conn->prepare("SELECT nickname FROM profiles WHERE nickname = :nickname");
$stmt_nn->bindParam(':nickname', $nickname);
$stmt_nn->execute();
$nicknames = $stmt_nn->fetch(PDO::FETCH_ASSOC);
if ($nicknames) {
  $memorize_signup_details['error'] = 'nickname_duplicate';
  $memorize_signup_details['nick_name'] = '';

  $_SESSION['m_s_d'] = $memorize_signup_details;

  Header("Location: sign_up.php?nickname=duplicate");
  exit;
}

// password validation
if (strlen($password) <= 10) {
  $memorize_signup_details['error'] = 'password_!_short';
  $memorize_signup_details['password'] = '';
  $_SESSION['m_s_d'] = $memorize_signup_details;
  Header("Location: sign_up.php?password=too_short");
  exit();
}


if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>?\/\\\\|[\]~`]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
  $memorize_signup_details['error'] = 'password_!_special_char';
  $memorize_signup_details['password'] = '';
  $_SESSION['m_s_d'] = $memorize_signup_details;
  Header("Location: sign_up.php?password=special_char_missing");
  exit();
}




if ($password !== $re_pass) {
  $memorize_signup_details['error'] = 'password_!_match';
  $memorize_signup_details['password'] = '';
  $_SESSION['m_s_d'] = $memorize_signup_details;
  Header("Location: sign_up.php?error=password");
  exit;
}

// try {
$stmt = $conn->prepare("INSERT INTO profiles (full_name, nickname, email, pass)
                            VALUES (:full_name, :nickname, :email, :pass)");

$stmt->bindParam(':full_name', $full_name);
$stmt->bindParam(':nickname', $nickname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':pass', $pass_hash);

try {
  $stmt->execute();
  echo "<p>Success</p>";
  header('Location: sign_in.php?success=login');
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