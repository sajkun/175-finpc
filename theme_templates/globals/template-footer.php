<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>

    <footer class="site-footer">
      <div class="spacer-h-30 spacer-h-xl-60"></div>
      <div class="container-lg container-fixed">
        <div class="row">
          <div class="col-lg-3">
            <?php echo $logo ?>

            <div class="spacer-h-40 spacer-h-lg-40"></div>

            <form action="#" class="sign-form">
              <span class="sign-form__cta  text-center text-left-lg">
                Recieve our newsletters for
                the lastest company updates
              </span>
              <input type="text" class="sign-form__field" placeholder="Your Email Address">

              <input type="submit" class="sign-form__submit" value="contact-us">
            </form>
          </div><!-- col-lg-3 -->

          <div class="col-lg-6">

            <?php if ($footer_menu ): ?>
            <div class="spacer-h-30"></div>
            <?php echo $footer_menu ?>
            <?php endif ?>
          </div><!-- col-lg-6 -->


          <div class="col-lg-3 text-center text-left-lg">
            <div class="spacer-h-30"></div>
            <?php if ($before_footer_scedule  || $footer_scedule  ): ?>
              <h4 class="footer-label">Working hours</h4>
              <p class="footer-text before-schedule" <?php echo 'style="white-space: pre-wrap"' ?>> <?php echo $before_footer_scedule ?> </p>
              <div class="schedule"> <?php echo $footer_scedule ?> </div>
              <div class="spacer-h-30 spacer-h-lg-40"></div>
            <?php endif ?>

            <div class="socials text-center text-left-lg">
              <ul class="menu-socials">
                <?php foreach ($socials as $icon => $url):
                   if(!$url) continue;
                 ?>
                  <li class="<?php echo $icon; ?>"><a href="<?php echo $url; ?>">
                    <svg class="icon svg-icon-<?php echo $icon; ?>"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-<?php echo $icon; ?>"></use> </svg>
                  </a></li>
                <?php endforeach ?>
              </ul>
            </div>
          </div><!-- col-lg-3 -->
        </div><!-- row -->
      </div><!-- container -->
      <div class="spacer-h-30 spacer-h-lg-70"></div>
      <div class="hr"></div>
      <div class="spacer-h-30"></div>
      <div class="container-lg container-fixed">
        <div class="row">
          <p class="copyrights text-center text-left-md col-md-6"><?php echo $copyrights; ?></p>
          <?php if ($term_url): ?>
          <div class="col-md-6 text-center  text-right-md">
             <a href="<?php echo $term_url ?>" class="terms">Terms and Conditions</a>
          </div>
          <?php endif ?>
        </div>
      </div>
      <div class="spacer-h-50"></div>
    </footer>