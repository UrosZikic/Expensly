<?php
require_once "../DB/connect.php";

$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS);
$nickname = $_POST['nickname'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if (!$email) {
  echo "Invalid email.";
  exit;
}

// try {
$stmt = $conn->prepare("INSERT INTO profiles (full_name, nickname, email, pass)
                            VALUES (:full_name, :nickname, :email, :pass)");

$stmt->bindParam(':full_name', $full_name);
$stmt->bindParam(':nickname', $nickname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':pass', $password);

if ($stmt->execute()) {
  echo "success";
} else {
  echo "failure";
}
// } catch (PDOException $e) {
//   echo "error " . $e->getMessage();
// }
?>