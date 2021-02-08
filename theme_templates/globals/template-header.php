<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>
<header class="site-header <?php echo apply_filters('header_classes', $classes) ?>">
  <div class="container-lg container-fixed">
    <div class="site-header__row">
      <?php echo $logo ?>

      <?php echo $main_menu; ?>

      <div class="mobile-menu-switcher arrow"><span class="arrow"></span></div>
    </div>
  </div><!-- container -->
</header>