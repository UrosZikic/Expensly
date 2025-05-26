<?php
session_start();
session_unset();
session_destroy();
require_once '../components/head.php';
?>


<div class="registration_container d_flex flex_gap_s">
  <form class="d_flex flex_dir_col flex_gap_xs form_width" action="si_validate.php" method="post">
    <input type="text" name="nickname" placeholder="insert your username" required>
    <input type="password" name="password" placeholder="insert your password" required>
    <input type="submit">
  </form>



  <?php
  require_once '../components/foot.php';
  ?>