<?php
require_once '../components/head.php';
session_start();
$validate = true;
if (isset($_SESSION['m_s_d'])) {
  $validate_prev_try = $_SESSION["m_s_d"];
  if ($validate_prev_try['error'] != "")
    // $validate will trigger outfill on input fields only in case of an actual error
    print_r($_SESSION['m_s_d']);
}
?>

<div class="register_notification_container center_object">
  <h1>WARNING</h1>
  <?php
  switch ($validate_prev_try['error']) {
    case 'email_invalid':
      echo 'Invalid Email Address';
      break;
    case 'email_duplicate':
      echo 'Email Address Already In Use';
      break;
    case 'nickname_duplicate':
      echo 'Username Already In Use';
      break;
    case 'password_!_match':
      echo "Passwords Don't Match";
      break;
    default:
      echo "Successful Registration!";
      break;
  }

  ?>
</div>


<div class="registration_container d_flex flex_gap_s">
  <form class="d_flex flex_dir_col flex_gap_xs form_width" action="su_validate.php" method="post">
    <h2>Register your profile!</h2>
    <input type="text" name="full_name" placeholder="enter your name" value="<?php if ($validate)
      echo $validate_prev_try['full_name'] ?>" required>
      <input type="text" name="nickname" placeholder="enter your nickname" value="<?php if ($validate && !isset($_GET['nickname']))
      echo $validate_prev_try['nick_name'] ?>" required>
      <input type="email" name="email" placeholder="enter your email" value="<?php if ($validate && !isset($_GET['email']))
      echo $validate_prev_try['email'];
    else
      echo "" ?>" required>
      <input type="password" name="password" placeholder="enter your password" value="<?php if ($validate && !isset($_GET['password']))
      echo $validate_prev_try['password'] ?>" required>
      <input type="password" name="re_pass" placeholder="repeat your password" value="<?php if ($validate && !isset($_GET['password']))
      echo $validate_prev_try['password'] ?>" required>
      <input type="submit">
    </form>
  </div>

  <?php
    require_once '../components/foot.php';
    ?>