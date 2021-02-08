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

<div class="container-lg container-fixed">
  <div class="row">

    <?php foreach ($team as $member): ?>

    <div class="col-sm-6 col-md-4">
      <div class="team-member">
        <div class="team-member__image"><img src="<?php echo $member['photo']; ?>" alt="">

          <div class="team-member__overlay"> <?php echo $member['about']; ?> </div>
        </div>

        <p class="team-member__name"><?php echo $member['name']; ?></p>
        <p class="team-member__post"><?php echo $member['position']; ?></p>
      </div><!-- team-member -->
    </div><!-- col-sm-6 col-md-4 -->
    <?php endforeach ?>
  </div><!-- row -->
</div><!-- conatiner-lg container-fixed -->