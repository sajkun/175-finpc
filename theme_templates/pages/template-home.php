<?php
  defined( 'ABSPATH' ) || exit;
?>

<div class="heroscreen" <?php printf('style="background-image: url(%s);"', $welcome['bg']); ?>>
  <div class="container-lg fixed valign-center">

    <?php if ($welcome['title']): ?>
    <div class="row">
      <div class="">
        <h1 class="heroscreen__title"><?php echo $welcome['title']; ?></h1>
      </div>
    </div>
    <div class="spacer-h-30"></div>
    <?php endif ?>


    <?php if ($welcome['text']): ?>
    <div class="row">
      <div class="col-md-9 col-lg-5">
        <p class="heroscreen__text"><?php echo $welcome['text']; ?></p>
        <div class="spacer-h-30"></div>
      </div>
      <div class="col-md-2 text-right-lg text-left-lg text-center">
        <?php if ($welcome['video_url']): ?>
        <i class="play-video" onclick="play_video('<?php echo $welcome['video_url']; ?>', event)">
          <i class="wrapper"></i>
          <i class="inner"></i>
          <span class="arrow"></span>
        </i>
        <div class="spacer-h-50 spacer-h-md-0"></div>
        <?php endif ?>
      </div>
    </div>
    <?php endif ?>

    <ul class="menu-socials yellow">
      <?php foreach ($socials as $icon => $url):
         if(!$url) continue;
       ?>
        <li class="<?php echo $icon; ?>"><a href="<?php echo $url; ?>">
          <svg class="icon svg-icon-<?php echo $icon; ?>"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-<?php echo $icon; ?>"></use> </svg>
        </a></li>
      <?php endforeach ?>
    </ul>


    <div class="spacer-h-50"></div>
  </div><!-- container-lg fixed -->


  <?php if ($welcome['address'] || $welcome['email'] || $welcome['phones']): ?>
    <div class="menu-bottom">
      <div class="container-lg container-fixed">
        <div class="row">
          <div class="col-sm-7 col-md-11 col-lg-10 col-xl-8">
             <ul class="address-data bg-white">

              <?php if ($welcome['address']): ?>
               <li>
                 <i class="icon">
                   <svg class="svg-icon-geo"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-geo"></use> </svg>
                 </i>
                 <a target="_blank" href="<?php echo $welcome['address_url'] ?>" class="address-data__item">
                   <?php echo $welcome['address'] ?>
                 </a>
               </li>
              <?php endif ?>
              <?php if ($welcome['email']): ?>
               <li>
                 <i class="icon">
                   <svg class="svg-icon-mail"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-mail"></use> </svg>
                 </i>
                 <a href="mailto:<?php echo $welcome['email'] ?>" class="address-data__item"><?php echo $welcome['email'] ?></a>
               </li>
              <?php endif ?>
              <?php if ($welcome['phones']): ?>
                <?php
                  $phones = explode(PHP_EOL, $welcome['phones']);
                 ?>
               <li>
                 <i class="icon">
                    <svg class="svg-icon-phone"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-phone"></use> </svg>
                 </i>
                 <?php foreach ($phones as $p): ?>
                 <a href="tel:<?php echo preg_replace('/\W/', '', $p); ?>" class="address-data__item"><?php echo $p; ?></a>
                 <?php endforeach ?>
               </li>
              <?php endif ?>
             </ul>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div><!-- heroscreen -->

<div class="spacer-h-lg-100 spacer-h-30"></div>
<div class="spacer-h-xl-100"></div>

<section class="mission">
  <div class="container container-fixed">
    <div class="row">
      <div class="col-md-6 image-holder">
        <img src="<?php echo $mission['img'];?>" alt="">
        <div class="spacer-h-30 spacer-h-md-0"></div>
      </div>
      <div class="col-md-6 valign-center-md">
        <div class="border-title">
          <div class="border-title__content">
            <div class="border-title__bg-text"><?php echo $mission['title_border'];?></div>
            <h2 class="border-title__text"><?php echo $mission['title'];?></h2>
          </div>
        </div>
        <div class="spacer-h-30 spacer-h-md-0"></div>

        <div class="our-mission"> <?php echo $mission['text'];?>
        </div>
      </div>
    </div>
  </div><!-- container -->
</section>

<div class="spacer-h-lg-100 spacer-h-30"></div>
<div class="spacer-h-xl-100"></div>

<?php if ($wedo['items']): ?>

<section class="we-do">
  <div class="container">
    <div class="spacer-h-lg-50 spacer-h-lg-100"></div>
    <div class="row">
      <div class="col-md-2 valign-center ">
        <div class="border-title rotate">
          <div class="border-title__content">
            <div class="border-title__bg-text"><?php echo $wedo['title_border'];?></div>
            <h2 class="border-title__text text-center text-left-md"><?php echo $wedo['title'];?></h2>
          </div>
          <div class="spacer-h-30 spacer-h-md-0"></div>
        </div><!-- border-title -->
      </div><!-- col-lg-4 -->

      <div class="col-md-10 col-lg-7 offset-lg-1 text-center text-left-md">
        <div class="row">
          <?php foreach ($wedo['items'] as $item): ?>
            <div class="col-md-6">
              <?php if ($item['icon'] ): ?>
              <i class="we-do__icon"><img src="<?php echo $item['icon'] ?>" alt=""></i>
              <?php endif ?>
              <h3 class="we-do__title"><?php echo $item['title'] ?></h3>
              <p class="we-do__text"><?php echo $item['text'] ?> </p>
              <div class="spacer-h-30 spacer-h-lg-50"></div>
            </div>
          <?php endforeach ?>
        </div>
        <?php if ($wedo['url'] ): ?>
        <a href="<?php echo $wedo['url'];?>" class="we-do__all">View all services</a>
        <?php endif ?>
      </div><!-- col-lg-4 -->
    </div>
  </div>
  <div class="spacer-h-lg-50 spacer-h-lg-100"></div>
</section>
<div class="spacer-h-lg-100 spacer-h-30"></div>
<div class="spacer-h-xl-100"></div>
<?php endif ?>

<?php if ($videos['items']): ?>
<section class="media">
  <div class="container-lg container-fixed">
    <div class="border-title to-right">
      <div class="border-title__content">
        <div class="border-title__bg-text"><?php echo $videos['title_border']; ?></div>
        <h2 class="border-title__text"><?php echo $videos['title']; ?></h2>
      </div>
    </div>

    <div class="spacer-h-30 spacer-h-lg-0"></div>

    <div class="articles-body">
      <div class="atricles-body-ctrl">
        <div class="prev">
          <svg class="svg-icon-arrow"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrow"></use> </svg>
        </div>
        <div class="next">
          <svg class="svg-icon-arrow"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrow"></use> </svg>
        </div>
      </div>
      <div class="articles-carousel owl-carousel">
        <?php foreach ($videos['items'] as $key => $item): ?>
        <div class="article-carousel__item">
          <div class="article-carousel__item-image">
            <img src="<?php echo $item['image'] ?>" alt="<?php echo $item['title'] ?>">
            <i class="icon-video" onclick="play_video('<?php echo $item['url'] ?>', event)"></i>
          </div>
          <a href="<?php echo $item['url'] ?>" onclick="play_video('<?php echo $item['url'] ?>', event)" class="article-carousel__item-title"><?php echo $item['title'] ?></a>
          <span class="article-carousel__item-date"> <?php echo $item['date'] ?> </span>
        </div><!-- article-carousel__item -->
        <?php endforeach ?>

      </div><!-- articles-carousel owl-carousel -->
    </div><!-- articles-body -->
  </div><!-- container -->
</section>
<div class="spacer-h-lg-110 spacer-h-30"></div>
<?php endif ?>

<?php if ($steps['items']): ?>
  <section class="section-finance">
    <div class="bg-title"><?php echo $steps['title'] ?></div>
    <div class="container">
      <div class="section-finance__steps">
        <h2 class="section-title"><?php echo $steps['title_border'] ?></h2>
        <div class="spacer-h-30 spacer-g-lg-60"></div>
        <div class="row">

          <?php foreach ($steps['items'] as $key => $item): ?>
          <div class="col-md-6">
            <i class="section-finance__icon">
              <img src="<?php echo $item['icon'] ?>" alt="">
            </i>
            <h3 class="section-finance__title">
              <span class="number"><?php echo $key + 1 ?>.</span>
              <?php echo $item['title'] ?>
            </h3>
            <p class="section-finance__text"> <?php echo $item['text'] ?> </p>
            <div class="spacer-h-30 spacer-h-lg-50"></div>
          </div><!-- col-md-6 -->
          <?php endforeach ?>

        </div><!-- row -->
      </div><!-- section-finance__steps -->
    </div><!-- container -->
  </section>

  <div class="spacer-h-lg-100 spacer-h-30"></div>
  <div class="spacer-h-lg-70"></div>
<?php endif ?>

<?php if ($testimonials): ?>
<section class="testimonials">
  <div class="carousel-testi owl-carousel">
    <?php foreach ($testimonials as $t): ?>
    <section>
      <div class="container-lg container-fixed">
        <div class="row">
          <div class="col-md-6 valign-center-md">
            <div class="carousel-testi__image text-right-md  ">
              <img src="<?php echo $t['image']; ?>" alt="">
              <i class="icon-video" onclick="play_video('<?php echo $t['video_url'] ?>', event)"></i>
            </div>
          </div>
          <div class="col-md-6 valign-center-md">
          <div class="carousel-testi__content">
              <p class="carousel-testi__text">
                <?php echo $t['text'] ?>
              </p>
              <span class="carousel-testi__author">
                <?php echo $t['name'] ?> <br>
                <?php echo $t['position'] ?>
              </span>
              <div class="spacer-h-30 spacer-h-lg-60"></div>

              <div class="carousel-testi__arrows">
                <div class="prev">
                   <svg class="svg-icon-arrow"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrow"></use> </svg>
                </div>
                <div class="next">
                   <svg class="svg-icon-arrow"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-arrow"></use> </svg>
                </div>
              </div>
            </div>
          </div>
        </div><!-- container -->
      </div><!-- row -->
    </section>
    <?php endforeach ?>
  </div><!-- carousel-testi -->
</section>
<?php endif ?>

<div class="spacer-h-30 spacer-h-lg-100"></div>
<div class="spacer-h-lg-100"></div>

<section class="form-holder">
 <div class="container-md">
 <div class="spacer-h-lg-100"></div>
 <h4 class="section-title">Request <br> a call back</h4>
  <div class="row">
    <div class="col-lg-5">
       <div class="spacer-h-30 spacer-h-lg-60"></div>
       <div class="form-container">
        <?php echo do_shortcode(sprintf('[contact-form-7 id="%s" title="%s"]', $form->ID, $form->post_title)); ?>
       </div>
       <div class="spacer-h-lg-70"></div>
    </div>
  </div><!-- row -->
 </div><!-- container-md -->
  <div class="spacer-h-50 spacer-h-lg-80"></div>
</section>