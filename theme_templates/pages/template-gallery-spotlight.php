<?php
/*
Template name: Gallery Page
*/


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>
<div class="container-lg container-fixed">
<div class="page-title">
  <div class="container container-fixed">
    <div class="page-title__bg-text">Gallery</div>
    <h2 class="page-title__text">Gallery</h2>
  </div>
</div>
  <div class="spacer-h-50"></div>

  <div class="gallery" id="gallery-spotlight">
    <div class="row">
      <div class="col-md-9">
        <ul class="gallery__categories">
          <?php if ($all == get_permalink($obj)): ?>
            <li class="gallery__link"><span>All</span></li>
          <?php else: ?>
            <li class="gallery__link"><a href="<?php echo $all; ?>">All</a></li>
          <?php endif ?>

          <?php foreach ($theme_galleries_tax as $key => $term): ?>

            <?php if ($term == $obj): ?>
              <li class="gallery__link"><span><?php echo $term->name; ?></span></li>
            <?php else: ?>
              <li class="gallery__link"><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></li>
            <?php endif ?>
          <?php endforeach ?>
        </ul>
        <div class="spacer-h-20"></div>
      </div><!-- col-md-9 -->
      <div class="col-md-3 text-right-md">
      </div><!-- col-md-3 -->
    </div><!-- row -->
    <transition-group
      class="gallery-content-spotlight"
      name="gallery-content"
      tag="div"
      v-bind:css="false"
      v-on:before-enter="beforeEnter"
      v-on:enter="enter"
      v-on:leave="leave"
      v-on:after-enter="enterAfter"
      v-on:after-leave="leaveAfter"
    >
        <img :src="item.href" :key="'image'+key" v-for="item, key in _gallery_items" v-on:click="show_gallery(item)" alt="">
    </transition-group>

    <div class="spacer-h-30 spacer-h-lg-60"></div>
  </div><!-- gallery -->
</div><!-- container-lg -->
<div class="spacer-h-30 spacer-h-lg-110"></div>