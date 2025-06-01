<?php
require_once "../DB/connect.php";
session_start();



if (isset($_POST['expense']) && is_int(intval($_POST['expense']))) {
  $expense = intval($_POST['expense']);

  if (!is_int($expense)) {
    // Header("Location: ../index.php?error=not_a_number");
    exit();
  } else if ($expense <= 0) {
    echo 'value less than 1';
    exit();
  }
  if (!isset($_POST['expense_name']) || strlen($_POST['expense_name']) <= 0) {
    echo "expense name not set";
  } else {
    $expense_name = $_POST['expense_name'];
  }
} else
  // Header("Location: ../index.php?error=budget_not_set");
  echo $_POST['expense'], gettype($_POST['expense']);
echo 'expense not set';

if (intval($_GET['current_budget']) < $_POST['expense']) {
  Header('Location: ../index.php?err=expense_exceeds_budget');
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

  // header('Location: ../index.php?error=budget_not_set');
  echo 'not set 2';
  exit;
}

