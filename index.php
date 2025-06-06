<?php

require_once "DB/connect.php";
require "components/head.php";

if (isset($_SESSION['m_si_d'])) {
  $fetch_nickname = $_SESSION['m_si_d'];
  $nickname = $fetch_nickname['nickname'];

  $current_month = Date("M");

  // fetch budget
  $stmt = $conn->prepare("
    SELECT monthly_budget.budget
    FROM monthly_budget
    JOIN profiles ON monthly_budget.user_id = profiles.user_id
    WHERE profiles.nickname = :nickname AND monthly_budget.month = '$current_month'
");
  $stmt->execute(['nickname' => $nickname]);
  $budget = $stmt->fetch(PDO::FETCH_ASSOC);


  // fetch expenses
  $stmt_expense = $conn->prepare("
    SELECT expenses.expense_price, expenses.expense_name, expenses.created_at
    FROM expenses
    JOIN profiles ON expenses.user_id = profiles.user_id WHERE profiles.nickname = :nickname AND expenses.month = '$current_month'
");
  $stmt_expense->execute(['nickname' => $nickname]);
  $expense = $stmt_expense->fetchAll(PDO::FETCH_ASSOC);
  $expense_sum = 0;
  foreach ($expense as $row) {
    $expense_sum += $row['expense_price'];
  }

}


?>
<main class="main_max border_rad_s pad_horizontal_xs">
  <section class="registration_container text_center">
    <h1>
      <?php
      if (isset($nickname)) {
        echo "Welcome " . $nickname . ", start documenting your expenses";
      } else {
        echo "Welcome, log in or register a new account";
      }
      ?>
    </h1>
  </section>

  <?php
  if (isset($_SESSION['m_si_d'])) {
    ?>
    <section class="d_grid grid_2_1">
      <div class="registration_container registration_margin_custom_small d_flex flex_dir_col">
        <div class="align_self_baseline">
          <?php
          $validate_budget = isset($budget) && is_array($budget) ? true : false;
          if ($validate_budget) { ?>
            <p>Remaining budget: <?php if ($validate_budget) {
              $remaining_budget = $budget['budget'] - $expense_sum;
              $spent = !$remaining_budget ? 'budget spent! -' : "";
              echo $remaining_budget . ' RSD for the month of ' . Date('M') . $spent;
            }
            ?></p> <?php } else {
            ?>
            <p>Set this month's budget</p>
            <?php
          }
          ; ?>
          <hr>
          <br>
          <p>Expense Record</p>
          <!-- <ul> -->
          <table>
            <tr>
              <th>Expense title</th>
              <th>Expense amount</th>
              <th>Date</th>
            </tr>
            <?php
            foreach ($expense as $row) {
              ?>
              <tr>
                <td class="width_38"><?php echo $row['expense_name']; ?></td>
                <td><?php echo $row['expense_price']; ?></td>
                <td><?php echo strtok($row['created_at'], ' '); ?></td>

              </tr>
              <?php
            }
            ?>
          </table>

          <!-- </ul> -->
        </div>
      </div>
      <div class="d_flex flex_dir_col flex_gap_xs pad_horizontal_xs">
        <?php if (!$budget) { ?>
          <form action="pages/set_budget.php" method="post"
            class="registration_container d_flex flex_gap_s registration_margin_custom_small flex_dir_col flex_gap_xs form_width">
            <input type="number" name="budget" placeholder="set this month's budget" class="align_self_baseline">
            <input type="submit" class="align_self_baseline">
          </form>
        <?php } ?>
        <form action="pages/set_expense.php?current_budget=<?php echo $remaining_budget ?>" method="post"
          class="registration_container d_flex flex_gap_s registration_margin_custom_small flex_dir_col flex_gap_xs form_width">
          <input type="number" name="expense" placeholder="set expense" class="align_self_baseline" required>
          <?php
          if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if (strpos($error, 'budget'))
              echo $error;
          }
          ?>
          <input type="text" name="expense_name" placeholder="set expense name" class="align_self_baseline" required>
          <?php
          if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if (strpos($error, 'expense'))
              echo $error;
          }

          ?>
          <input type="submit" class="align_self_baseline">
        </form>
      </div>
    </section>
    <p><?php echo Date('Y-m-d'); ?></p>

  <?php }
  ?>

</main>
<?php
require "components/foot.php";
?>