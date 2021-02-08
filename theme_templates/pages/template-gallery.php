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

  <div class="gallery" id="gallery">
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
        <div class="gallery__sort">
          <span class="gallery__sort-label">Sort by:</span>
          <select name="" id="" ref="sort_select" v-on:change="do_sort">
            <option value="The Newest">The Newest</option>
            <option value="The Oldest">The Oldest</option>
          </select>
        </div><!-- gallery__sort -->
        <div class="spacer-h-20"></div>
      </div><!-- col-md-3 -->
    </div><!-- row -->

    <div class="spacer-h-30 spacer-h-lg-60"></div>

    <transition-group
      class="gallery-content"
      name="gallery-content"
      tag="div"
      v-bind:css="false"
      v-on:before-enter="beforeEnter"
      v-on:enter="enter"
      v-on:leave="leave"
      v-on:after-enter="enterAfter"
      v-on:after-leave="leaveAfter"
    >
      <gallery-item
        v-for="info, key in _items"
        :key = '"gallery_item_"+key'
        :_info = 'info'
      ></gallery-item>

      <div :key="'blank'" class="gallery-item blank">
      </div>
    </transition-group>

    <div class="spacer-h-30" v-if="show_button"></div>
    <div class="gallery-content" v-if="show_button">
      <div class="gallery-item"><a href="#" class="button gallery-load-more" v-on:click.prevent="show_more">load more</a></div><div class="gallery-item"></div><div class="gallery-item"></div>
    </div>
  </div><!-- gallery -->
</div><!-- container-lg -->
<div class="spacer-h-30 spacer-h-lg-110"></div>