<nav class="d_flex j_flex_between a_flex_center">
  <a href="#">
    <img class="logo_img" src="../logo.avif" alt="company logo">
  </a>


  <ul class="d_flex j_flex_apart flex_gap_s">
    <?php
    $nav_link_list = [
      'home',
      'sign_up',
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