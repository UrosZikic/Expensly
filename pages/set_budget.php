<?php
require_once "../DB/connect.php";
session_start();



if (isset($_POST['budget']) && $_POST['budget'] != "") {
  $budget = $_POST['budget'];
  echo $budget == "";
  if (!is_int($budget)) { {    // Header("Location: ../index.php?error=not_a_number");
      echo "not number";
      exit();

    }
  } else if ($budget <= 0) {
    echo "budget invalid";
    exit();
  }
} else
  // Header("Location: ../index.php?error=budget_not_set");
  echo 'not set';

// set month
$month = Date('M');

// fetch user
$user = $_SESSION['m_si_d'];
$nickname = $user['nickname'];

$stmt_r_user = $conn->prepare('SELECT user_id FROM profiles WHERE nickname= :nickname');
$stmt_r_user->bindParam(':nickname', $nickname);
$stmt_r_user->execute();
$db_user = $stmt_r_user->fetch(PDO::FETCH_ASSOC);
$user_id = $db_user['user_id'];

// set budget
$stmt = $conn->prepare("INSERT INTO monthly_budget (user_id, month, budget)
                            VALUES (:user_id, :month, :budget)");

$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':month', $month);
$stmt->bindParam(':budget', $budget);

try {
  $stmt->execute();
  echo "<p>Success</p>";
  header('Location: ../index.php?success=budget_set');
} catch (PDOException $e) {

  // header('Location: ../index.php?error=budget_not_set');
  echo 'not set 2';
  exit;
}




