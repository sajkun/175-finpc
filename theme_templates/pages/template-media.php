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

<div class="container-md container-fixed">
  <div class="row">
    <?php foreach ($media as $m): ?>
      <div class="col-md-4 col-sm-6">
        <div class="podcast-item">
          <a href="<?php echo $m['learn_more_ulr']?>" class="podcast-item__image">
            <img src="<?php echo $m['image']?>" alt="<?php echo $m['title']?>"></a>
          <p class="podcast-item__title"> <?php echo $m['title']?> </p>
          <span class="podcast-item__comment"><?php echo $m['number_of_episodes']; ?>  <?php echo _n('episode', 'episodes', (int)$m['number_of_episodes'])?></span>

          <div class="row">
            <div class="col-6">
              <?php if ($m['learn_more_ulr']): ?>
              <a href="<?php echo $m['learn_more_ulr']?>" class="podcast-item__more">Learn more</a>
              <?php endif ?>
            </div>

            <div class="col-6 text-right">
              <?php if ($m['google_play_url']): ?>
              <a href="<?php echo $m['google_play_url']; ?>" target="_blank" class="podcast-item__media"><svg class="svg-icon-google-play"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-google-play"></use> </svg></a>
              <?php endif ?>

              <?php if ($m['spotify_url']): ?>
              <a href="<?php echo $m['spotify_url']; ?>" target="_blank" class="podcast-item__media"><svg class="svg-icon-spotify"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-spotify"></use> </svg></a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div><!-- row -->
</div>