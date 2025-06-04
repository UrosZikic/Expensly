<?php
require_once "../DB/connect.php";
session_start();



if (isset($_POST['expense']) && is_int(intval($_POST['expense']))) {
  $expense = $_POST['expense'];

  if (!is_int(intval($expense))) {
    Header("Location: ../index.php?error=expense_not_a_number");
    exit();
  } else if (intval($expense) <= 0) {
    Header('Location: ../index.php?error=invalid_expense_value');
    exit();
  }
  if (!isset($_POST['expense_name']) || strlen($_POST['expense_name']) <= 0) {
    Header('Location: ../index.php?error=expense_name_not_set');
    exit();
  } else
    $expense_name = $_POST['expense_name'];

}


if (intval($_GET['current_budget']) < $_POST['expense']) {
  Header('Location: ../index.php?error=expense_exceeds_budget');
  exit();
}

// fetch user
$user = $_SESSION['m_si_d'];
$nickname = $user['nickname'];

$stmt_r_user = $conn->prepare('SELECT user_id FROM profiles WHERE nickname= :nickname');
$stmt_r_user->bindParam(':nickname', $nickname);
$stmt_r_user->execute();
$db_user = $stmt_r_user->fetch(PDO::FETCH_ASSOC);
$user_id = $db_user['user_id'];

$month = Date('M');

// set budget
$stmt = $conn->prepare("INSERT INTO expenses (expense_name, expense_price, month, user_id)
                            VALUES (:expense_name, :expense_price, :month, :user_id)");

$stmt->bindParam(':expense_name', $expense_name);
$stmt->bindParam(':expense_price', $expense);
$stmt->bindParam(':month', $month);
$stmt->bindParam(':user_id', $user_id);

try {
  $stmt->execute();
  echo "<p>Success</p>";
  header('Location: ../index.php?success=expense_set');
} catch (PDOException $e) {
  header('Location: ../index.php?error=expense_not_set');
  exit;
}

