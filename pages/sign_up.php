<?php
require_once '../components/head.php';
session_start();

if (isset($_SESSION['m_s_d']))
  print_r($_SESSION['m_s_d']);
?>
<div>

</div>
<div class="registration_container d_flex flex_gap_s">
  <form class="d_flex flex_dir_col flex_gap_xs form_width" action="su_validate.php" method="post">
    <h2>Register your profile!</h2>
    <input type="text" name="full_name" placeholder="enter your name" required>
    <input type="text" name="nickname" placeholder="enter your nickname" required>
    <input type="email" name="email" placeholder="enter your email" required>
    <input type="password" name="password" placeholder="enter your password" required>
    <input type="password" name="re_pass" placeholder="repeat your password" required>
    <input type="submit">
  </form>
  <form class="hidden" action="" method="post">
    <input type="email" name="email" placeholder="enter your email">
    <input type="password" name="password" placeholder="enter your password" required>
    <input type="submit">
  </form>
</div>

<?php
require_once '../components/foot.php';
?>