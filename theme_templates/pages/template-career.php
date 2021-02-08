<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>
<div class="heroscreen" <?php printf('style="background-image: url(%s);"', $bg); ?>>
  <div class="container-lg fixed valign-center">
      <h1 class="heroscreen__title"><?php echo $title; ?></h1>
      <div class="spacer-h-30 spacer-h-lg-50"></div>
      <p class="heroscreen__text" <?php echo 'style="white-space:pre-wrap;"';?>><?php echo $text; ?></p>
  </div><!-- container-lg fixed -->
</div><!-- heroscreen -->
<div class="spacer-h-lg-60 spacer-h-30"></div>


<?php if ($cta_title): ?>

<div class="page-title">
  <div class="page-title__bg-text"><?php echo $cta_title_border; ?></div>
  <div class="container">
    <h2 class="page-title__text"><?php echo $cta_title; ?></h2>
  </div>
</div>
<?php endif ?>

<div class="spacer-h-30 spacer-h-lg-50"></div>

<div class="container">
  <p class="requirements-description"> <?php echo $cta_text; ?> </p>

  <div class="row">
    <div class="col-md-6 image-holder">
      <img src="<?php echo $cta_image; ?>" alt="">
      <div class="spacer-h-md-0 spacer-h-30"></div>
    </div>
    <div class="col-md-5 offset-md-1 valign-center-md">
      <ul class="requirements-list">
        <?php foreach ($cta_requirments as  $value): ?>
        <li><span><?php echo $value; ?></span></li>
        <?php endforeach ?>
      </ul>
      <div class="spacer-h-xl-100"></div>
    </div>
  </div>

  <div class="spacer-h-30 spacer-h-lg-80"></div>
  <h3 class="section-title">Available Positions</h3>
  <div class="spacer-h-30 spacer-h-lg-50"></div>

  <?php foreach ($positions as $p): ?>
  <div class="position-item">
    <div class="row">
      <div class="col-md-7">
        <p class="position-item__title"><?php echo $p['title']; ?></p>
        <div class="clearfix">
          <span class="position-item__label"><?php echo $p['department']; ?></span>
          <span class="position-item__value"><?php echo $p['location']; ?></span>
        </div>
      </div>
      <div class="col-md-5 valign-center-md text-right-md">
        <a href="<?php echo $p['url']; ?>" class="position-item__more">View more</a>
      </div>
    </div>
  </div>
  <?php endforeach ?>
  <div class="spacer-h-50 spacer-h-lg-80"></div>
</div>