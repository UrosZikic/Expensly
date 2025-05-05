<?php
require_once '../components/head.php';


?>
<div class="registration_container d_flex flex_gap_s">
  <form class="d_flex flex_dir_col flex_gap_xs form_width" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>"
    method="post">
    <h2>Register your profile!</h2>
    <input type="text" name="full_name" placeholder="enter your name" required>
    <input type="text" name="nickname" placeholder="enter your nickname" required>
    <input type="email" name="email" placeholder="enter your email">
    <input type="password" name="password" placeholder="enter your password" required>
    <input type="submit">
  </form>
  <img src="../register_img.avif" alt="registration image">
</div>

<?php
require_once '../components/foot.php';
?>