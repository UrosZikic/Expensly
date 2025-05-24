<?php


require "components/head.php";

?>
<main class="main_max border_rad_s pad_horizontal_xs">
  <section class="registration_container text_center">
    <h1>
      <?php
      if (isset($_SESSION['m_si_d'])) {
        $fetch_nickname = $_SESSION['m_si_d'];
        $nickname = $fetch_nickname['nickname'];
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
          <p>Remaining budget: <?php ?></p>
          <hr>
          <p>Expense Record</p>
          <ul>


          </ul>
        </div>
      </div>
      <div class="d_flex flex_dir_col flex_gap_xs pad_horizontal_xs">
        <form action=""
          class="registration_container d_flex flex_gap_s registration_margin_custom_small flex_dir_col flex_gap_xs form_width">
          <input type="number" placeholder="set this month's budget" class="align_self_baseline">
          <input type="submit" class="align_self_baseline">
        </form>
        <form action=""
          class="registration_container d_flex flex_gap_s registration_margin_custom_small flex_dir_col flex_gap_xs form_width">
          <input type="number" placeholder="set expense" class="align_self_baseline">
          <input type="text" placeholder="set expense name" class="align_self_baseline">
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