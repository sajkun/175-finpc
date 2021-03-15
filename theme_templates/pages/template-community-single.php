<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="heroscreen" <?php printf('style="background-image: url(%s);"', $bg); ?>>
  <div class="container-lg fixed valign-center">

    <span class="community-data"><?php echo $subtitle; ?></span>

    <?php if ($title): ?>
    <div class="spacer-h-30"></div>
    <h1 class="heroscreen__title"<?php echo 'style="white-space:pre-line"';?>><?php echo $title; ?></h1>
    <?php endif ?>
    <div class="spacer-h-30 "></div>
    <div class="share-block">
      <span class="share-title">
        Share Now
      </span>


      <script>
        function open_window(href, title){
         var w = 640, h = 480,
            left = Number((screen.width/2)-(w/2)), tops = Number((screen.height/2)-(h/2));

        popupWindow = window.open(href, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=1, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);
        popupWindow.focus(); return false;
        }
      </script>


      <ul class="menu-socials">
         <?php
          $limit = 140;
          $after = (mb_strlen(strip_tags(strip_shortcodes($content)))>$limit)?'...': '' ;
          $text = mb_substr(strip_tags(strip_shortcodes($content)), 0, $limit-3).$after;
          $url =  get_permalink($obj);
          ?>

        <li><a href="http://twitter.com/share?text=<?php echo esc_attr($text) ?>&url=<?php echo esc_url( $url ) ?>"

          title="<?php _e('Share in Twitter'); ?>"
          onclick="open_window(this.href, this.title);
           return false" target="_parent"
          >
          <svg class="icon svg-icon-twitter"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-twitter"></use> </svg>
        </a></li>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink($obj)); ?>"
            onclick="open_window(this.href, this.title); return false"
            title="<?php _e('Share in Facebook'); ?>"
            target="_parent"
            >    <svg class="icon svg-icon-facebook"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-facebook"></use> </svg>
         </a></li>
      </ul>
    </div>
  </div><!-- container-lg fixed -->
</div><!-- heroscreen -->
<div class="spacer-h-lg-60 spacer-h-30"></div>

<div class="container-lg fixed ">

  <div class="community-text">
    <?php echo $content; ?>
  </div>

  <div class="spacer-h-30 spacer-h-lg-60"></div>
  <div class="hr hr-xl"></div>
  <div class="spacer-h-30 spacer-h-lg-60"></div>

      <?php if ($videos): ?>
  <div class="row">
    <div class="col-12 col-md-6">
      <h3 class="section-title">Trending </h3>
    </div>
    <div class="col-12 col-md-6 text-right-md">

      <?php if ($videos_url): ?>

      <a href="<?php echo $videos_url ?>" class="load-more-btn">See all</a>
      <?php endif ?>
    </div>
  </div>
  <div class="spacer-h-40"> </div>
    <div class="row">

      <?php foreach ($videos as $key => $v): ?>

      <div class="col-md-6 col-lg-4">
        <div class="community-preview__item">
          <div class="community-preview__item-image">
            <a href="<?php echo $v['url'] ?>">

            <img src="<?php echo $v['image'] ?>"" alt="<?php echo $v['title'] ?>">
            </a>
          </div>
          <a href="<?php echo $v['url'] ?>" class="community-preview__item-title"><?php echo $v['title'] ?></a>
          <span class="community-preview__item-date"> <?php echo $v['date'] ?> </span>
        </div>
      </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
  <div class="spacer-h-30 spacer-h-lg-60"></div>