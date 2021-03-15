<div class="container-lg fixed">
  <div class="row visuallyhidden" id="community-container">
    <div class="col-lg-8 col-xl-9 order-lg-0 order-1">

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
      <community-item
        v-for="item, key in _items"
        :key = "'item'+key"
        :_info = "item"
      ></community-item>
      </transition-group>

      <div class="text-center" v-if="show_button">
        <a href="javascript:void(0)" class="load-more-btn"  v-on:click.prevent="show_more">Load More</a>
      </div>

      <transition
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
      <div class="text-center" v-if="_items_filtered.length == 0">
        Nothing found
      </div>
      </transition>

      <div class="spacer-h-50 spacer-h-lg-100"></div>
    </div>
    <div class="col-lg-4 col-xl-3">
      <div class="community-sidebar">
          <form action="javascript:void(0)">
            <div class="community-search">
                <button type="submit"><svg class="icon svg-icon-search-2"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-search-2"></use> </svg></button>
                <input type="search" placeholder="Search" v-model="search">
            </div><!-- community-search -->
          </form>

        <h2 class="community-title">CATEGORIES</h2>

        <nav class="community-tags">
          <ul class="community-tags__list">
            <li v-bind:class="{'active':(selected_category == '')}"><a href="#" v-on:click.prevent="selected_category=''" >#All</a></li>
            <li v-for="c, key in categories" :class="{active: (c==selected_category)}"><a href="#" v-on:click.prevent="selected_category=c" >{{c}}</a></li>
                </ul>
        </nav>
      </div><!-- community-sidebar -->
    </div>
  </div>
</div>