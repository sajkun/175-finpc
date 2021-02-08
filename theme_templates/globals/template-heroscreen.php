<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="heroscreen" <?php printf('style="background-image: url(%s);"', $bg); ?>>
  <div class="container-lg fixed valign-center">
      <h1 class="heroscreen__title"><?php echo $title; ?></h1>
      <div class="spacer-h-30 spacer-h-lg-50"></div>
      <p class="heroscreen__text" <?php echo 'style="white-space:pre-wrap;"';?>><?php echo $text; ?></p>
  </div><!-- container-lg fixed -->
</div><!-- heroscreen -->
<div class="spacer-h-lg-60 spacer-h-30"></div>