<?php
require_once "../DB/connect.php";
session_start();

$nickname = $_POST['nickname'];
$password = $_POST['password'];


$validate_prev_try = ['nickname' => $nickname, 'password' => $password, 'error' => ''];

// Validate email
$stmt_p = $conn->prepare("SELECT nickname, pass FROM profiles WHERE nickname = :nickname");
$stmt_p->bindParam(':nickname', $nickname);
$stmt_p->execute();
$profile = $stmt_p->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
  $validate_prev_try['nickname'] = "";
  $validate_prev_try['error'] = "invalid_nickname";
  $_SESSION['m_si_d'] = $validate_prev_try;

  Header("Location: sign_in.php?nickname=invalid");
  exit;
}

if (password_verify($password, $profile['pass'])) {
  $validate_prev_try['password'] = "";
  $_SESSION['m_si_d'] = $validate_prev_try;
  setcookie('signed', 1, time() + 43200, "/");
  Header("location: ../index.php?result=success");
} else {
  Header("location: sign_in.php?password=invalid");
  exit();
}