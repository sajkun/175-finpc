var Cookie =
{
   set: function(name, value, days)
   {
      var domain, domainParts, date, expires, host;

      if (days)
      {
         date = new Date();
         date.setTime(date.getTime()+(days*24*60*60*1000));
         expires = "; expires="+date.toGMTString();
      }
      else
      {
         expires = "";
      }

      host = location.host;
      if (host.split('.').length === 1)
      {
         // no "." in a domain - it's localhost or something similar
         document.cookie = name+"="+value+expires+"; path=/";
      }
      else
      {
         // Remember the cookie on all subdomains.
          //
         // Start with trying to set cookie to the top domain.
         // (example: if user is on foo.com, try to set
         //  cookie to domain ".com")
         //
         // If the cookie will not be set, it means ".com"
         // is a top level domain and we need to
         // set the cookie to ".foo.com"
         domainParts = host.split('.');
         domainParts.shift();
         domain = '.'+domainParts.join('.');

         document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

         // check if cookie was successfuly set to the given domain
         // (otherwise it was a Top-Level Domain)
         if (Cookie.get(name) == null || Cookie.get(name) != value)
         {
            // append "." to current domain
            domain = '.'+host;
            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
         }
      }
   },

   get: function(name)
   {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i=0; i < ca.length; i++)
      {
         var c = ca[i];
         while (c.charAt(0)==' ')
         {
            c = c.substring(1,c.length);
         }

         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
   },

   erase: function(name)
   {
      Cookie.set(name, '', -1);
   }
};
/**
 *
 * @author    Jerry Bendy
 * @since     4/12/2017
 */

function touchX(event) {
    if(event.type.indexOf('mouse') !== -1){
        return event.clientX;
    }
    return event.touches[0].clientX;
}

function touchY(event) {
    if(event.type.indexOf('mouse') !== -1){
        return event.clientY;
    }
    return event.touches[0].clientY;
}

var isPassiveSupported = (function() {
    var supportsPassive = false;
    try {
        var opts = Object.defineProperty({}, 'passive', {
            get: function() {
                supportsPassive = true;
            }
        });
        window.addEventListener('test', null, opts);
    } catch (e) {}
    return supportsPassive;
})();

// Save last touch time globally (touch start time or touch end time), if a `click` event triggered,
// and the time near by the last touch time, this `click` event will be ignored. This is used for
// resolve touch through issue.
var globalLastTouchTime = 0;

var vueTouchEvents = {
    install: function (Vue, constructorOptions) {

        var globalOptions = Object.assign({}, {
            disableClick: false,
            tapTolerance: 10,  // px
            swipeTolerance: 30,  // px
            touchHoldTolerance: 400,  // ms
            longTapTimeInterval: 400,  // ms
            touchClass: ''
        }, constructorOptions);

        function touchStartEvent(event) {
            var $this = this.$$touchObj,
                isTouchEvent = event.type.indexOf('touch') >= 0,
                isMouseEvent = event.type.indexOf('mouse') >= 0,
                $el = this;

            if (isTouchEvent) {
                globalLastTouchTime = event.timeStamp;
            }

            if (isMouseEvent && globalLastTouchTime && event.timeStamp - globalLastTouchTime < 350) {
                return;
            }

            if ($this.touchStarted) {
                return;
            }

            addTouchClass(this);

            $this.touchStarted = true;

            $this.touchMoved = false;
            $this.swipeOutBounded = false;

            $this.startX = touchX(event);
            $this.startY = touchY(event);

            $this.currentX = 0;
            $this.currentY = 0;

            $this.touchStartTime = event.timeStamp;

            // Trigger touchhold event after `touchHoldTolerance`ms
            $this.touchHoldTimer = setTimeout(function() {
                $this.touchHoldTimer = null;
                triggerEvent(event, $el, 'touchhold');
            }, $this.options.touchHoldTolerance);

            triggerEvent(event, this, 'start');
        }

        function touchMoveEvent(event) {
            var $this = this.$$touchObj;

            $this.currentX = touchX(event);
            $this.currentY = touchY(event);

            if (!$this.touchMoved) {
                var tapTolerance = $this.options.tapTolerance;

                $this.touchMoved = Math.abs($this.startX - $this.currentX) > tapTolerance ||
                    Math.abs($this.startY - $this.currentY) > tapTolerance;

                if($this.touchMoved){
                    cancelTouchHoldTimer($this);
                    triggerEvent(event, this, 'moved');
                }

            } else if (!$this.swipeOutBounded) {
                var swipeOutBounded = $this.options.swipeTolerance;

                $this.swipeOutBounded = Math.abs($this.startX - $this.currentX) > swipeOutBounded &&
                    Math.abs($this.startY - $this.currentY) > swipeOutBounded;
            }

            if($this.touchMoved){
                triggerEvent(event, this, 'moving');
            }
        }

        function touchCancelEvent() {
            var $this = this.$$touchObj;

            cancelTouchHoldTimer($this);
            removeTouchClass(this);

            $this.touchStarted = $this.touchMoved = false;
            $this.startX = $this.startY = 0;
        }

        function touchEndEvent(event) {
            var $this = this.$$touchObj,
                isTouchEvent = event.type.indexOf('touch') >= 0,
                isMouseEvent = event.type.indexOf('mouse') >= 0;

            if (isTouchEvent) {
                globalLastTouchTime = event.timeStamp;
            }

            var touchholdEnd = isTouchEvent && !$this.touchHoldTimer;
            cancelTouchHoldTimer($this);

            $this.touchStarted = false;

            removeTouchClass(this);

            if (isMouseEvent && globalLastTouchTime && event.timeStamp - globalLastTouchTime < 350) {
                return;
            }

            // Fix #33, Trigger `end` event when touch stopped
            triggerEvent(event, this, 'end');

            if (!$this.touchMoved) {
                // detect if this is a longTap event or not
                if ($this.callbacks.longtap && event.timeStamp - $this.touchStartTime > $this.options.longTapTimeInterval) {
                    if (event.cancelable) {
                        event.preventDefault();
                    }
                    triggerEvent(event, this, 'longtap');

                } else if ($this.callbacks.touchhold && touchholdEnd) {
                    if (event.cancelable) {
                        event.preventDefault();
                    }
                    return;
                } else {
                    // emit tap event
                    triggerEvent(event, this, 'tap');
                }

            } else if (!$this.swipeOutBounded) {
                var swipeOutBounded = $this.options.swipeTolerance,
                    direction,
                    distanceY = Math.abs($this.startY - $this.currentY),
                    distanceX = Math.abs($this.startX - $this.currentX);

                if (distanceY > swipeOutBounded || distanceX > swipeOutBounded) {
                    if (distanceY > swipeOutBounded) {
                        direction = $this.startY > $this.currentY ? 'top' : 'bottom';
                    } else {
                        direction = $this.startX > $this.currentX ? 'left' : 'right';
                    }

                    // Only emit the specified event when it has modifiers
                    if ($this.callbacks['swipe.' + direction]) {
                        triggerEvent(event, this, 'swipe.' + direction, direction);
                    } else {
                        // Emit a common event when it has no any modifier
                        triggerEvent(event, this, 'swipe', direction);
                    }
                }
            }
        }

        function mouseEnterEvent() {
            addTouchClass(this);
        }

        function mouseLeaveEvent() {
            removeTouchClass(this);
        }

        function triggerEvent(e, $el, eventType, param) {
            var $this = $el.$$touchObj;

            // get the callback list
            var callbacks = $this.callbacks[eventType] || [];
            if (callbacks.length === 0) {
                return null;
            }

            for (var i = 0; i < callbacks.length; i++) {
                var binding = callbacks[i];

                if (binding.modifiers.stop) {
                    e.stopPropagation();
                }

                if (binding.modifiers.prevent) {
                    e.preventDefault();
                }

                // handle `self` modifier`
                if (binding.modifiers.self && e.target !== e.currentTarget) {
                    continue;
                }

                if (typeof binding.value === 'function') {
                    if (param) {
                        binding.value(param, e);
                    } else {
                        binding.value(e);
                    }
                }
            }
        }

        function addTouchClass($el) {
            var className = $el.$$touchObj.options.touchClass;
            className && $el.classList.add(className);
        }

        function removeTouchClass($el) {
            var className = $el.$$touchObj.options.touchClass;
            className && $el.classList.remove(className);
        }

        function cancelTouchHoldTimer($this) {
            if ($this.touchHoldTimer) {
                clearTimeout($this.touchHoldTimer);
                $this.touchHoldTimer = null;
            }
        }

        function buildTouchObj($el, extraOptions) {
            var touchObj = $el.$$touchObj || {
                // an object contains all callbacks registered,
                // key is event name, value is an array
                callbacks: {},
                // prevent bind twice, set to true when event bound
                hasBindTouchEvents: false,
                // default options, would be override by v-touch-options
                options: globalOptions
            };
            if (extraOptions) {
                touchObj.options = Object.assign({}, touchObj.options, extraOptions);
            }
            $el.$$touchObj = touchObj;
            return $el.$$touchObj;
        }

        Vue.directive('touch', {
            bind: function ($el, binding) {
                // build a touch configuration object
                var $this = buildTouchObj($el);
                // declare passive option for the event listener. Defaults to { passive: true } if supported
                var passiveOpt = isPassiveSupported ? { passive: true } : false;
                // register callback
                var eventType = binding.arg || 'tap';
                switch (eventType) {
                    case 'swipe':
                        var _m = binding.modifiers;
                        if (_m.left || _m.right || _m.top || _m.bottom) {
                            for (var i in binding.modifiers) {
                                if (['left', 'right', 'top', 'bottom'].indexOf(i) >= 0) {
                                    var _e = 'swipe.' + i;
                                    $this.callbacks[_e] = $this.callbacks[_e] || [];
                                    $this.callbacks[_e].push(binding);
                                }
                            }
                        } else {
                            $this.callbacks.swipe = $this.callbacks.swipe || [];
                            $this.callbacks.swipe.push(binding);
                        }
                        break;

                    case 'start':
                    case 'moving':
                        if (binding.modifiers.disablePassive) {
                            // change the passive option for the moving event if disablePassive modifier exists
                            passiveOpt = false;
                        }
                    // fallthrough
                    default:
                        $this.callbacks[eventType] = $this.callbacks[eventType] || [];
                        $this.callbacks[eventType].push(binding);
                }

                // prevent bind twice
                if ($this.hasBindTouchEvents) {
                    return;
                }

                $el.addEventListener('touchstart', touchStartEvent, passiveOpt);
                $el.addEventListener('touchmove', touchMoveEvent, passiveOpt);
                $el.addEventListener('touchcancel', touchCancelEvent);
                $el.addEventListener('touchend', touchEndEvent);

                if (!$this.options.disableClick) {
                    $el.addEventListener('mousedown', touchStartEvent);
                    $el.addEventListener('mousemove', touchMoveEvent);
                    $el.addEventListener('mouseup', touchEndEvent);
                    $el.addEventListener('mouseenter', mouseEnterEvent);
                    $el.addEventListener('mouseleave', mouseLeaveEvent);
                }

                // set bind mark to true
                $this.hasBindTouchEvents = true;
            },

            unbind: function ($el) {
                $el.removeEventListener('touchstart', touchStartEvent);
                $el.removeEventListener('touchmove', touchMoveEvent);
                $el.removeEventListener('touchcancel', touchCancelEvent);
                $el.removeEventListener('touchend', touchEndEvent);

                if ($el.$$touchObj && !$el.$$touchObj.options.disableClick) {
                    $el.removeEventListener('mousedown', touchStartEvent);
                    $el.removeEventListener('mousemove', touchMoveEvent);
                    $el.removeEventListener('mouseup', touchEndEvent);
                    $el.removeEventListener('mouseenter', mouseEnterEvent);
                    $el.removeEventListener('mouseleave', mouseLeaveEvent);
                }

                // remove vars
                delete $el.$$touchObj;
            }
        });

        Vue.directive('touch-class', {
            bind: function ($el, binding) {
                buildTouchObj($el, {
                    touchClass: binding.value
                });
            }
        });

        Vue.directive('touch-options', {
            bind: function($el, binding) {
                buildTouchObj($el, binding.value);
            }
        });
    }
};


/*
 * Exports
 */
if (typeof module === 'object') {
    module.exports = vueTouchEvents;

} else if (typeof define === 'function' && define.amd) {
    define([], function () {
        return vueTouchEvents;
    });
} else if (window.Vue) {
    window.vueTouchEvents = vueTouchEvents;
    Vue.use(vueTouchEvents);
}
var animation_mixin = {
  methods:{
   beforeEnter: function (el) {
      el.style.opacity = 0
    },

    enter: function (el, done) {
      const width = getComputedStyle(el).width;

      el.style.width = width;
      el.style.position = 'absolute';
      el.style.visibility = 'hidden';
      el.style.height = 'auto';

      const height = getComputedStyle(el).height;

      el.style.width = null;
      el.style.position = null;
      el.style.visibility = null;
      el.style.height = 0;

      getComputedStyle(el).height;

      var delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
          el,
          { opacity: 1, height: height },
          { complete: done }
        )
      }, delay)
    },

    leave: function (el, done) {
      var delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
          el,
          { opacity: 0, height: 0 },
          { complete: done }
        )
      }, delay)
    },

    enterAfter: function(el){
      el.style.height = 'auto';

      if(typeof(this.update_scroll)!=='undefined'){
        this.update_scroll();
      }
    },

    leaveAfter: function(el){
      if(typeof(this.update_scroll)!=='undefined'){
        this.update_scroll();
      }
    }
  }
}
Vue.component('gallery-item', {
	data: function () {
		return {
			info: this._info,
		}
	},

	props: ['_info'],

	watch: {
		_info: function (val) {
			this.info = val
		},
	},

	beforeMount: function () {
		this.info = this._info
	},

	mounted: function () {
		console.log(this.info)
	},

	methods: {
		show_gallery: function () {
			jQuery.fancybox.open(strip(this.info.items), {
				// beforeShow: function (el) {},
				helpers: {
					thumbs: {
						width: 75,
						height: 50,
					},
				},
			})
		},
	},

	template: `
    <div class="gallery-item" v-on:click="show_gallery">
      <div class="gallery-item__image">
        <img :src="info.thumb" alt="">
      </div>
      <div class="gallery-item__tags">
      <span>{{info.tags}} </span></div>
    </div>
  `,
})
Vue.component('download-item',{
  data: function(){
    return {
      info: this._info,
      preview: '',
    };
  },

  props: ['_info'],

  watch: {
    _info:function(val){
      this.info = val;
    }
  },

  computed:{
    overlay:function(){
      var links = Object.values(this.info.links);
      return links[0];
    }
  },

  beforeMount: function(){
    this.info = this._info;
  },

  methods: {
    show_preview:function(url){
      console.log(url);

      fetch(url)
        .then(res => res.blob())
        .then(res =>{
          let reader = new FileReader()
          reader.readAsDataURL(res);

          switch(res.type){
            case 'application/pdf' :
            jQuery('.site-container').append(' <div class="popup-preview"><div class="popup-preview__inner"><i class="close">×</i><canvas id="pdf_renderer"></canvas></div></div>');

              pdfjsLib.getDocument(url).then((pdf) => {
                myState.pdf = pdf;
                render();
              })
              break;
            default:
                reader.onloadend = function() {
                  jQuery('.site-container').append('<div class="popup-preview"><div class="popup-preview__inner"><i class="close">×</i><img src="'+reader.result+'"></div></div>');
                }
               break;
          }
      })
    }
  },

  template: `
    <div class="col-xl-3 col-lg-4 col-sm-6">
      <div class="download-item">
        <div class="download-item__image">
          <img :src="info.thumb" alt="">
          <a :href="overlay" v-on:click.prevent="show_preview(overlay)" class="download-item__overlay">
            <i class="download-item__icon"></i>
          </a>
        </div>
        <div class="download-item__data">
          <p class="download-item__title">{{info.title}}</p>
          <span class="download-item__label">Download</span>
            <a :href="link" class="download-item__link" download
               v-for="link, label in info.links"
               :key="'link'+label"
            >{{label}}</a>
        </div>
      </div><!-- download-item -->
    </div>
  `,

})

var myState = {
    pdf: null,
    currentPage: 1,
    zoom: 1
}

function render() {
    myState.pdf.getPage(myState.currentPage).then((page) => {

        var canvas = document.getElementById("pdf_renderer");
        var ctx = canvas.getContext('2d');

        var viewport = page.getViewport(myState.zoom);

        canvas.width = viewport.width;
        canvas.height = viewport.height;

        page.render({
            canvasContext: ctx,
            viewport: viewport
        });
    });
}

jQuery(document).on('click','.popup-preview .close',function(){
  jQuery(this).closest('.popup-preview').remove();
})
Vue.component('community-item',{
  data: function(){
    return {
      info: this._info,
    };
  },

  props: ['_info'],

  watch: {
    _info:function(val){
      this.info = val;
    }
  },

  computed:{
     tags:function(){
      var data =[];
      var _data  = [
        this.info.categories.join(', '),
        this.info.date,
        this.info.author,
      ];

      for(var inf of _data){
        if(inf){
          data.push(inf);
        }
      }

      return data.join(' ');
    },
  },

  beforeMount: function(){
    this.info = this._info;
  },

  methods: {},

  template: `
    <div class="community-item">
      <div class="community-item__image"><a  :href="info.url" ><img :src="info.image" alt=""></a></div>
      <div class="community-item__content">
        <a :href="info.url" class="community-item__title">{{info.title}}</a>
        <span class="community-item__tags">{{tags}}</span>
        <p class="community-item__text">{{info.text}}</p>
        <a :href="info.url" class="community-item__readmore">Learn more</a>
      </div>
    </div>
  `,

})
var _gallery_;
var _download_;
var _video_;
var _community_;
if (document.getElementById('gallery')) {
	_gallery_ = new Vue({
		el: '#gallery',

		data: {
			items: gallery_items,
			limit: 6,
			step: 6,
			sort_by: false,
		},

		mixins: [animation_mixin],

		computed: {
			_items: function () {
				var items = this.items
				var vm = this

				items.sort(function (a, b) {
					var date_a = new Date(a.date.replace(/\s/, 'T'))
					var date_b = new Date(a.date.replace(/\s/, 'T'))
					if (date_a == date_b) {
						return 0
					}

					switch (vm.sort_by) {
						case 'the newest':
							return date_b < date_a ? 1 : -1
							break
						case 'the oldest':
							return date_b > date_a ? 1 : -1
							break
						default:
							return 0
							break
					}
				})

				return items.slice(0, this.limit)
			},

			show_button: function () {
				return this.items.length > this.limit
			},
		},

		mounted: function () {
			this.sort_by = this.$refs.sort_select.value.toLowerCase()
		},

		methods: {
			do_sort: function () {
				this.sort_by = this.$refs.sort_select.value.toLowerCase()
			},

			show_more: function () {
				this.limit += this.step
			},
		},
	})
}
// var downloads = [
//   {
//     thumb: 'assets/images/c/d01.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d02.jpg',
//     title: 'Business card title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d03.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d04.jpg',
//     title: 'Business card title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d05.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d01.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d02.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },

//   {
//     thumb: 'assets/images/c/d04.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d01.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d02.jpg',
//     title: 'Business card title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d03.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d04.jpg',
//     title: 'Business card title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d05.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d01.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },
//   {
//     thumb: 'assets/images/c/d02.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },

//   {
//     thumb: 'assets/images/c/d04.jpg',
//     title: 'Brochure title',
//     links: {
//       jpg: 'assets/images/c/d01.jpg',
//       png: 'assets/images/c/d01.jpg',
//     }
//   },

// ];

if('undefined' == typeof(downloads)){
  var downloads = [];
}

if(document.getElementById('download-section')){

  _download_ = new Vue({
    el: '#download-section',

    mixins: [animation_mixin],


    data: {
      items: downloads,
      limit: 12,
      add: 12,
    },

    computed:{
      _items:function(){
        return this.items.slice(0, this.limit);
      },

      show_button: function(){
        return this.items.length > this.limit;
      },
    },

    methods:{
      show_more: function(){
        this.limit += this.add
      }
    }
  });
}
if(document.getElementById('video-items')){


  // var video_items = [
  //   {
  //     title: 'Free the Freelancers',
  //     date:  '2020-10-30 00:00:00',
  //     date_formatted: '30 October',
  //     image: 'assets/images/c/v01.jpg',
  //     category: ['history'],
  //     text: 'lorem  ipsum name test',
  //     url: 'http://',
  //   },
  //   {
  //     title: 'Free the Freelancers',
  //     date:  '2020-11-30 00:00:00',
  //     date_formatted: '30 November',
  //     image: 'assets/images/c/v02.jpg',
  //     category: ['history'],
  //     text: 'lorem  ipsum name test',
  //     url: 'http://',
  //   },
  //   {
  //     title: 'How to Steal an Election: Mail-In Ballots',
  //     date:  '2020-11-30 00:00:00',
  //     date_formatted: '30 November',
  //     image: 'assets/images/c/v03.jpg',
  //     category: ['fun'],
  //     text: 'lorem  ipsum name test badum',
  //     url: 'http://',
  //   },
  //   {
  //     title: 'Defining Liberty',
  //     date:  '2020-11-25 00:00:00',
  //     date_formatted: '25 November',
  //     image: 'assets/images/c/w06.jpg',
  //     category: ['fun'],
  //     text: 'lorem  ipsum name badum',
  //     url: 'http://',
  //   },
  // ];

  // var video_categories = ['fun', 'history'];

  _video_ = new Vue({
    el: '#video-items',

    mixins: [animation_mixin],

    data: {
      video_items: video_items,
      categories: video_categories,
      current_category: video_categories[0],
      search_word: '',
      temp_search: '',
      sort_by: 'newest',
    },

    computed: {
      by_category: function(){

        if(!video_categories || video_categories.length ==0){
          return [];
        }
        var vm = this;
        var items = video_items.filter(e=>{
          return e.category.indexOf(vm.current_category) >=0;
        });

        return items;
      },

      search_items: function(){
        var vm = this;
        var items = video_items.filter(e=>{

          if(!vm.search_word || vm.search_word.length < 3){
            return false;
          }
          return e.title.toLowerCase().indexOf(vm.search_word.toLowerCase()) >=0 ||
           e.text.toLowerCase().indexOf(vm.search_word.toLowerCase()) >=0
          ;
        });

        return items;
      },

      all_sorted_items: function(){
        var vm = this;
        var items = video_items;

        switch(this.sort_by){
          case 'newest' :
            items = video_items.sort(function(a,b){
              var date_a = new Date(a.date);
              var date_b = new Date(b.date);

              if(date_a == date_b){
                return 0;
              }

              return date_b > date_a? 1: -1;
            })
            break;
          case 'latest' :
            items = video_items.sort(function(a,b){
              var date_a = new Date(a.date);
              var date_b = new Date(b.date);

              if(date_a == date_b){
                return 0;
              }

              return date_b < date_a? 1: -1;
            })
            break;
        }

        return items;
      },
    },


    methods: {
      searh_items:function(){
        this.search_word = this.temp_search
      }
    },
  })
}
if(document.getElementById('community-container')){

  // var community_items = [
  //   {
  //     url: 'some turl',
  //     title: 'some title',
  //     text: 'The Data Governance Watershed “You’ve been breached!” These are words none of us want to hear, but the situation is almost inevitable. When the breach does occur, will your data governance structure help to protect you? Many organisations are at a data governance.The Data Governance Watershed “You’ve been breached!” These are words none of us want to hear, but the situation is almost inevitable. When the breach does occur, will your data governance structure help to protect you? Many organisations are at a data governance.',
  //     image: '/assets/images/c/c11.jpg',
  //     date: 'August 3rd, 2020 11:40AM',
  //     categories: ['#Spotligh', '#Refund'],
  //     author: 'by Christopher McNaughton',
  //   },
  //   {
  //     url: 'some turl',
  //     title: 'some title',
  //     text: 'some text',
  //     image: '/assets/images/c/c11.jpg',
  //     date: 'August 3rd, 2020 11:40AM',
  //     categories: ['#Spotligh', '#Refund'],
  //     author: 'by Christopher McNaughton',
  //   },
  //   {
  //     url: 'some turl',
  //     title: 'some title',
  //     text: 'some text',
  //     image: '/assets/images/c/c11.jpg',
  //     date: 'August 3rd, 2020 11:40AM',
  //     categories: ['#Spotligh', '#Refund'],
  //     author: 'by Christopher McNaughton',
  //   },
  //   {
  //     url: 'some turl',
  //     title: 'some title',
  //     text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis ab, iste sed eos aliquid deleniti repellat ipsam sapiente eum repudiandae ea excepturi, reprehenderit veritatis ut illo id, quam accusamus quaerat?',
  //     image: '/assets/images/c/c11.jpg',
  //     date: 'August 3rd, 2020 11:40AM',
  //     categories: ['#Spotligh', '#Business'],
  //     author: 'by Christopher McNaughton',
  //   },
  //   {
  //     url: 'some turl',
  //     title: 'some title',
  //     text: 'The Data Governance Watershed “You’ve been breached!” These are words none of us want to hear, but the situation is almost inevitable. When the breach does occur, will your data governance structure help to protect you? Many organisations are at a data governance.',
  //     image: '/assets/images/c/c11.jpg',
  //     date: 'August 3rd, 2020 11:40AM',
  //     categories: ['#Spotligh', '#Refund'],
  //     author: 'by Christopher McNaughton',
  //   },
  // ];

  _community_ = new Vue({
    el: '#community-container',

    mixins: [animation_mixin],


    data: {
      items: community_items,
      limit: 4,
      add: 4,
      search: '',
      selected_category: '',
      categories: terms
    },

    computed:{

      _items_filtered : function(){
        var items_all = this.items;
        var vm = this;

        items_all = items_all.filter(el=>{
          var valid = true;

          if(vm.search){
            valid = el.title.indexOf(vm.search) < 0 &&   el.text.indexOf(vm.search)< 0? false : valid;
          }

          if(vm.selected_category){
             valid = el.categories.indexOf(vm.selected_category) < 0? false : valid;
          }


          return valid;
        });

        items_all = items_all.map(e=>{

          e.text = e.text.slice(0,320) + (e.text.length> 320? '...' : '');
          return e;
        });


        return items_all;
      },

      _items:function(){
        return this._items_filtered.slice(0, this.limit);
      },

      show_button: function(){
        return this._items_filtered.length > this.limit;
      },
    },

    mounted: function(){
      this.$el.classList.remove('visuallyhidden');
    },

    methods:{
      show_more: function(){
        this.limit += this.add
      }
    }
  });
}

function strip(val){
  return JSON.parse(JSON.stringify(val));
}

function ctime(label, color){
  if (theme_debug) {
    if(!color){
      color = 'blue';
    }
   console.group('%c '+label+' FINISHED', 'color:'+color);
   console.timeEnd(label);
   console.groupEnd();
  }
}

function slog(label, color, bg_color) {
  if (theme_debug) {
    if(!color){
      color = 'blue';
    }
    if(!bg_color){
      bg_color = '#fff';
    }
   console.group('%c '+ label , 'color:'+color+'; background: '+bg_color);
  }
}

function elog() {
  if (theme_debug) {
   console.groupEnd();
  }
}

function clog(value, color) {

    if(!color){
      color = 'black';
    }

  if (theme_debug) {

    if(typeof(value) === 'string'){
     console.log('%c ' + value , 'color:'+color);
    }else{
     console.log(value);
    }
  }
}

function block(){
  jQuery('.block-screen').addClass('shown')
}

function unblock(){
  jQuery('.block-screen').removeClass('shown')
}


function is_boolean(val){
  switch(typeof(val)){
    case 'boolean':
      return val;
      break;
    case 'string':
      if(val.toLowerCase() === 'false'){
        return false;
      }
      if(val.toLowerCase() === 'true'){
        return true;
      }
      return !!parseInt(val);
      break;
    case 'number':
      return !!parseInt(val);
      break;
    case 'undefined':
      return false;
      break;
  }
}

function play_video(url, event){

  event.preventDefault();
  if(!url) return;

  if(url.indexOf('youtu') >= 0){

    var _url = 'https://www.youtube.com/embed/';
    var parts = url.split('\/');

    var iframe = '<div class="popup-destroy"><div class="popup-destroy-inner"><i class="icon-close-destroy">×</i><iframe id="popup-iframe" src="'+_url+parts[parts.length -1]+'?autoplay=1&loop=0&rel=0&wmode=transparent" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>';
  }

  if(url.indexOf('vimeo') >= 0){
    var _url = 'https://player.vimeo.com/video/';
    var parts = url.split('\/');
    var iframe = '<div class="popup-destroy"><div class="popup-destroy-inner"><i class="icon-close-destroy">×</i><iframe id="popup-iframe" src="'+_url + parts[parts.length -1]+'?autoplay=1&loop=0&rel=0&wmode=transparent" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></div>';
  }

  jQuery('.site-container').append(iframe);

  jQuery('.site-container').find('.popup-destroy').addClass('shown')
  // jQuery('.site-container').find('#popup-iframe').on('load', function(){
  // });
}

jQuery(document).on('click', '.popup-destroy',function(e){
  if(!jQuery(e.target).closest('.popup-destroy-inner').length){
    jQuery('.site-container').find('.popup-destroy').removeClass('shown')

    setTimeout(function(){
      jQuery('.site-container').find('.popup-destroy').remove();
    },300);
  }
})

jQuery(document).on('click', '.icon-close-destroy', function(){
    jQuery('.site-container').find('.popup-destroy').removeClass('shown')

    setTimeout(function(){
      jQuery('.site-container').find('.popup-destroy').remove();
    },300);
})


function init_carousel_articles(){
  if(jQuery('.articles-carousel').length){
    var owl = jQuery('.articles-carousel');

    owl.owlCarousel({
      responsive:{
        0: {
          items: 1,
        },
        768:{
          items: 2,
        },

        1100:{
          items: 3,
          margin: 40,
        },
      },
      center: true,
      loop:true,
    })

    jQuery('.atricles-body-ctrl .next').click(function(){
      owl.trigger('next.owl.carousel')
    })

    jQuery('.atricles-body-ctrl .prev').click(function(){
      owl.trigger('prev.owl.carousel')
    })
  }

  if(jQuery('.carousel-testi').length){
    var owl2 = jQuery('.carousel-testi');

    owl2.owlCarousel({
      items: 1,
      center: true,
      loop:true,
      animateIn: 'fadeIn',
      animateOut: 'fadeOut',
    })

    jQuery('.carousel-testi__arrows .next').click(function(){
      owl2.trigger('next.owl.carousel')
    })

    jQuery('.carousel-testi__arrows .prev').click(function(){
      owl2.trigger('prev.owl.carousel')
    })
  }


}
jQuery(document).on('click', '.mobile-menu-switcher', function(){
  jQuery(this).toggleClass('active');
  jQuery('.menu-holder').toggleClass('shown');
})

jQuery(document).on('click', '.site-container', function(e){
  if(!jQuery(e.target).closest('.menu-holder').length && !jQuery(e.target).closest('.mobile-menu-switcher').length){
    jQuery('.mobile-menu-switcher').removeClass('active');
    jQuery('.menu-holder').removeClass('shown');
  }
})

jQuery(document.body).on('click', '.faq-item__title, .faq-item__trigger', function(){
  jQuery(this).closest('.faq-item').toggleClass('active').siblings('.faq-item').removeClass('active').find('.faq-item__body').slideUp();

  jQuery(this).siblings('.faq-item__body').slideToggle('fast', function() {

  });
})

jQuery(document.body).on('click', '.carousel-item__title, .carousel-item__trigger', function(){
  jQuery(this).closest('.carousel-item').toggleClass('active').siblings('.carousel-item').removeClass('active').find('.carousel-item__body').slideUp();

  jQuery(this).siblings('.carousel-item__body').slideToggle('fast', function() {

  });
})

jQuery('[type=file]').on('change', function(e){
  jQuery(this).siblings('span').text(jQuery(this)[0].files[0].name)
})
jQuery(document).ready(function(){
  init_carousel_articles();
})