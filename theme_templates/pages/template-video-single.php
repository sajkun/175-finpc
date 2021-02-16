<div class="container-lg">
  <div class="row">
    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
      <?php if ($video_url): ?>

      <iframe src="<?php echo $video_url ?>" frameborder="0" class="video-iframe" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
      <?php endif ?>
      <h1 class="video-title"> <?php echo $title ?> </h1>
      <div class="spacer-h-30"></div>

      <div class="row">
        <div class="col-12 col-md-8">
          <table class="video-data">
            <tr>
              <td>
                <div class="gravatar-holder">
                <img src="<?php echo $avatar_url; ?>" alt="">
                </div>
              </td>
              <td>
                <span class="video-data__author"><?php echo $name; ?></span>
                <span class="video-data__position"><?php echo $role; ?></span>
                <span class="video-data__date"><?php echo $date_formatted; ?></span>
              </td>
            </tr>
          </table>
          <div class="spacer-h-20 spacer-h-md-0"></div>
        </div>
        <div class="col-12 col-md-4 valign-top-md text-right-md">
          <i class="icon-category">
            <img src="<?php echo THEME_URL; ?>/assets/images/info.png " alt="">
          </i>
          <span class="video-category">
            <?php echo $terms[0]; ?>
          </span>
        </div>
      </div>
      <div class="spacer-h-30"> </div>
      <div class="video-content">
        <?php echo $text; ?>
      </div>
    </div>
  </div>
</div>

<div class="spacer-h-30 spacer-h-lg-70"></div>

<div class="container-lg sign">
  <div class="spacer-h-50"></div>
  <div class="row">
    <div class="col-12 col-md-6 offset-lg-1 col-lg-4 valign-center-md">
      <p class="sign__title"> Stay up to
date on our
latest releases </p>
    </div>
    <div class="col-12 col-md-6  offset-lg-1  col-lg-4  valign-center-md">
      <form action="#">
        <input type="email" placeholder="Your Email">
        <div class="spacer-h-30"></div>
        <input type="submit" value="submit">
      </form>
    </div>
  </div>
  <div class="spacer-h-50"></div>
</div><!-- container-lg sign -->

<div class="spacer-h-30 spacer-h-lg-70"></div>

<?php if ($related_items): ?>
  <div class="container">
    <h2 class="video-title">
     Recommended for you
    </h2>
    <div class="spacer-h-30"></div>
      <div class="video-block">
        <div class="row">
          <?php foreach ($related_items as $key => $post):
            $image_id = get_post_thumbnail_id($post->ID , 'full') ;
            $image = wp_get_attachment_image_url($image_id , 'video_thumb');
            $date = new DateTime($post->post_date);
          ?>

          <div class="col-12 col-md-4 col-lg-3">
            <div class="video-block__item">
              <a href="<?php echo get_permalink($post); ?>" class="video-block__item-image">
                <img src="<?php echo $image; ?>" alt="">
              </a>
              <a href="<?php echo get_permalink($post); ?>" class="video-block__item-title"><?php echo $post->post_title; ?></a>
              <span class="video-block__item-date"><?php echo $date->format('d F'); ?></span>
              <div class="spacer-h-30"> </div>
           </div>
         </div>
          <?php endforeach ?>
         <div class="col-12 col-md-4 col-lg-3"></div>
         <div class="col-12 col-md-4 col-lg-3"></div>
       </div>
    </div>
    <div class="spacer-h-30 spacer-h-lg-70"></div>
  </div>
<?php endif ?>