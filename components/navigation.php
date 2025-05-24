<nav class="d_flex j_flex_between a_flex_center">
  <a href="#">
    <img class="logo_img" src="../logo.avif" alt="company logo">
  </a>


  <ul class="d_flex j_flex_apart flex_gap_s">
    <?php
    $sign_in_out = isset($_SESSION['m_s_d']) ? 'sign_out' : 'sign_in';
    $nav_link_list = [
      'home',
      'sign_up',
      $sign_in_out
    ];
    foreach ($nav_link_list as $n_l_l) {
      ?>
      <li>
        <a class="turn_to_upperCase"
          href="<?php echo $n_l_l !== "home" ? ("/pages/" . $n_l_l . ".php") : "/" ?>"><?php echo $n_l_l ?></a>
      </li>
    <?php } ?>
  </ul>
</nav>