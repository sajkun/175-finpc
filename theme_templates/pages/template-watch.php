<div class="heroscreen" <?php echo 'style="background-image: url('.$background_image.');"'; ?>>
<div class="container-lg fixed valign-center">
  <?php if ($title): ?>
    <h1 class="heroscreen__title"><?php echo $title; ?></h1>
    <div class="spacer-h-30 spacer-h-lg-50"></div>
  <?php endif ?>

  <?php if ($text): ?>
    <p class="heroscreen__quote"> <?php echo $text; ?> <span class="spacer-h-10"></span>
     <span class="heroscreen__sign"> <?php echo $author ?> <br> <?php echo $author_position ?> </span>
   </p>
   <div class="clearfix"></div>
   <div class="spacer-h-30"></div>
  <?php endif ?>

  <?php if ( $video_url): ?>
   <a href="javascript:void(0)" class="heroscreen__video" onclick="play_video('<?php echo $video_url; ?>', event)">
    <i class="icon">
      <span class="wrapper">
      </span>
      <span class="inner"></span>
      <span class="arrow"></span>
    </i>
  <?php echo $video_button_text; ?></a>
  <?php endif ?>
</div><!-- container-lg fixed -->

</div><!-- heroscreen -->

<div class="spacer-h-50"></div>

<div class="container-lg" id="video-items">
<div class="video-search">
  <form action="#" method="POST"  v-on:submit.prevent="searh_items">
  <svg class="icon svg-icon-search"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-search"></use> </svg>
  <input type="text" placeholder="Search" v-model="temp_search">
  <input type="submit" value="search">
  </form>
</div>

<div class="spacer-h-30 spacer-h-lg-70"></div>
<div class="video-block">
  <transition-group
    class="row"
    name="video-categories"
    tag="div"
    v-bind:css="false"
    v-on:before-enter="beforeEnter"
    v-on:enter="enter"
    v-on:leave="leave"
    v-on:after-enter="enterAfter"
    v-on:after-leave="leaveAfter"
  >
    <div class="col-12 col-md-4 col-lg-3"  v-for="item, key in search_items" :key="'search_items_'+key">
      <div class="video-block__item">
        <a :href="item.url"  class="video-block__item-image">
          <img :src="item.image" alt="">
        </a>
        <a :href="item.url" class="video-block__item-title">{{item.title}}</a>
        <span class="video-block__item-date">{{item.date_formatted}}</span>
        <div class="spacer-h-30"></div>
      </div><!-- video-block__item -->
    </div><!-- col-12 col-md-4 col-lg-3 -->

    <div class="col-12 col-md-4 col-lg-3" key="last-search_items-1"></div>
    <div class="col-12 col-md-4 col-lg-3"  key="last-search_items-2"></div>
  </transition-group>
</div><!-- video-block -->
<div class="hr"></div>
<div class="spacer-h-30 spacer-h-lg-70"></div>


<?php if ($categories && count($categories) > 0): ?>
<div class="row">
  <div class="col-12 col-md-8">
    <h2 class="video-title">
      <i class="icon-trend">
        <img src="<?php echo THEME_URL ?>/assets/images/speaker.png" alt="">
      </i>
      Trending by Topic
    </h2>
  </div>
  <div class="col-12 col-md-4 text-right-md valign-center-md">
    <div class="spacer-h-30 spacer-h-md-0"></div>
    <select name="" id="" class="styled-list" v-model="current_category">
      <?php foreach ($categories as $key => $cat): ?>
          <option value="<?php echo strtolower($cat) ?>"><?php echo $cat ?></option>
      <?php endforeach ?>
    </select>
  </div>
</div>

<div class="spacer-h-30"></div>

<div class="video-block">
  <transition-group
    class="row"
    name="video-categories"
    tag="div"
    v-bind:css="false"
    v-on:before-enter="beforeEnter"
    v-on:enter="enter"
    v-on:leave="leave"
    v-on:after-enter="enterAfter"
    v-on:after-leave="leaveAfter"
  >
    <div class="col-12 col-md-4 col-lg-3"  v-for="item, key in by_category" :key="'by_category_'+key">
      <div class="video-block__item">
        <a :href="item.url"  class="video-block__item-image">
          <img :src="item.image" alt="">
        </a>
        <a :href="item.url" class="video-block__item-title">{{item.title}}</a>
        <span class="video-block__item-date">{{item.date_formatted}}</span>
        <div class="spacer-h-30"></div>
      </div><!-- video-block__item -->
    </div><!-- col-12 col-md-4 col-lg-3 -->

    <div class="col-12 col-md-4 col-lg-3" key="last-1"></div>
    <div class="col-12 col-md-4 col-lg-3"  key="last-2"></div>
  </transition-group>
</div><!-- video-block -->

<div class="hr"></div>
<div class="spacer-h-30 spacer-h-lg-70"></div>
<?php endif ?>

<div class="row">
  <div class="col-12 col-md-8">
    <h2 class="video-title">
      <i class="icon-trend">
        <img src="<?php echo THEME_URL ?>/assets/images/clock.png" alt="">
      </i>
      All 5-Minute Videos
    </h2>
  </div>
  <div class="col-12 col-md-4 text-right-md valign-center-md">
    <div class="spacer-h-30 spacer-h-md-0"></div>
    <select name="" id="" class="styled-list" v-model="sort_by">
      <option value="latest">Latest</option>
      <option value="newest">Newest</option>
    </select>
  </div>

</div>
<div class="spacer-h-30"></div>

<div class="video-block">
  <transition-group
    class="row"
    name="video-categories"
    tag="div"
    v-bind:css="false"
    v-on:before-enter="beforeEnter"
    v-on:enter="enter"
    v-on:leave="leave"
    v-on:after-enter="enterAfter"
    v-on:after-leave="leaveAfter"
  >
    <div class="col-12 col-md-4 col-lg-3"  v-for="item, key in all_sorted_items" :key="'by_category_'+key">
      <div class="video-block__item">
        <a :href="item.url"  class="video-block__item-image">
          <img :src="item.image" alt="">
        </a>
        <a :href="item.url" class="video-block__item-title">{{item.title}}</a>
        <span class="video-block__item-date">{{item.date_formatted}}</span>
        <div class="spacer-h-30"></div>
      </div><!-- video-block__item -->
    </div><!-- col-12 col-md-4 col-lg-3 -->

    <div class="col-12 col-md-4 col-lg-3" key="last-by_category-1"></div>
    <div class="col-12 col-md-4 col-lg-3"  key="last-by_category-2"></div>
  </transition-group>
</div><!-- video-block -->

<div class="hr"></div>
<div class="spacer-h-30 spacer-h-lg-70"></div>
</div><!-- container-lg -->

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
<div class="spacer-h-30 spacer-h-lg-70">
</div>