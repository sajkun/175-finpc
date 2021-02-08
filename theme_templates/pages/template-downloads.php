<div class="page-title">
  <div class="container container-fixed">
    <div class="page-title__bg-text">Download</div>
    <h2 class="page-title__text">Download Stationary </h2>
  </div>
</div>

<div class="spacer-h-30 spacer-h-lg-50"></div>

<div class="container-lg container-fixed2" id="download-section">
  <transition-group
    class="gallery-content row"
    name="gallery-content"
    tag="div"
    v-bind:css="false"
    v-on:before-enter="beforeEnter"
    v-on:enter="enter"
    v-on:leave="leave"
    v-on:after-enter="enterAfter"
    v-on:after-leave="leaveAfter"
  >
  <download-item
    v-for="item, key in _items"
    :key = "'item'+key"
    :_info = "item"
  ></download-item>
  </transition-group>

<div class="row">
  <div class="col-12"></div>
  <div class="col-xl-3 col-lg-4 col-sm-6" v-if="show_button">
    <a href="#" v-on:click.prevent="show_more" class="button fullwidth">load more</a>
  </div>
  </div><!-- row -->
  <div class="spacer-h-40 spacer-h-lg-60"></div>
</div><!-- container-md -->