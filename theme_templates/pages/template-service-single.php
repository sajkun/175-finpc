<div class="heroscreen" <?php echo 'style="background-image: url('.$bg.');"'; ?>>
  <div class="container-lg fixed valign-center">
      <h1 class="heroscreen__title"><?php echo $title; ?></h1>
      <div class="spacer-h-30 spacer-h-lg-50"></div>
      <p class="heroscreen__text pre-line"><?php echo $text; ?></p>
  </div><!-- container-lg fixed -->
</div><!-- heroscreen -->
<div class="spacer-h-30 spacer-h-lg-60"></div>

<?php if ($show_block_1): ?>
<section class="faq-container">
  <div class="container">
    <div class="spacer-h-30"></div>

    <div class="row">
      <div class="col-12" <?php echo 'style="z-index: 20"'; ?>>
        <div class="page-title">
           <a id="<?php echo str_replace(' ', '-' , trim($block_1_title)) ?>" class="visuallyhidden"></a>
          <div class="page-title__bg-text"><?php echo $block_1_title_bg ?></div>
          <h2 class="page-title__text"><?php echo $block_1_title ?></h2>
        </div>
      </div>
      <div class="col-lg-8 valign-center-lg">

        <div class="spacer-h-30"></div>

        <?php foreach ($block_1_items as $key => $item): ?>
        <div class="carousel-item">
          <div class="carousel-item__trigger"></div>
          <p class="carousel-item__title"> <?php echo $item['title']; ?></p>
          <p class="carousel-item__body"><?php echo $item['text']; ?></p>
        </div>
        <?php endforeach ?>
        <div class="spacer-h-30"></div>
      </div>


      </div>
       <div class="spacer-h-30 spacer-h-lg-70"></div>
    </div>
</section>
<div class="spacer-h-30 spacer-h-100"></div>
<?php endif ?>

<?php if ($show_block_2): ?>
<section class="mission">
  <div class="container container-fixed">
    <div class="row">
      <div class="col-md-6 image-holder">
        <img src="<?php echo $block_2_image ?>" alt="">
        <div class="spacer-h-30 spacer-h-md-0"></div>
      </div>
      <div class="col-md-6 valign-center-md">
        <div class="border-title">
          <div class="border-title__content">
            <a id="<?php echo str_replace(' ', '-' , trim($block_2_title)) ?>" class="visuallyhidden"></a>
            <div class="border-title__bg-text"><?php echo $block_2_title_bg ?></div>
            <h2 class="border-title__text"><?php echo $block_2_title ?></h2>
          </div>
        </div>
        <div class="spacer-h-30 spacer-h-md-0"></div>

        <div class="our-mission">
        <?php foreach ($block_2_items as $key => $item): ?>
        <div class="carousel-item">
          <div class="carousel-item__trigger"></div>
          <p class="carousel-item__title"> <?php echo $item['title']; ?></p>
          <p class="carousel-item__body"><?php echo $item['text']; ?></p>
        </div>
        <?php endforeach ?>
        </div>
      </div>
    </div>
  </div><!-- container -->
</section>
<div class="spacer-h-30 spacer-h-100"></div>
<?php endif ?>

<?php if ($show_block_3): ?>
<section>
  <div class="container container-fixed">
    <div class="row">
      <div class="col-12">
        <div class="border-title">
          <div class="border-title__content">
          <a id="<?php echo str_replace(' ', '-' , trim($block_title_3)) ?>" class="visuallyhidden"></a>
            <div class="border-title__bg-text"><?php echo $block_title_bg_3 ?></div>
            <h2 class="border-title__text"><?php echo $block_title_3 ?></h2>
          </div>
        </div>
        <div class="spacer-h-30"></div>
      </div>

      <div class="col-12 col-md-6 col-lg-5 offset-lg-1">
        <?php foreach ($block_items_3[0] as $key => $item): ?>
        <div class="carousel-item">
          <div class="carousel-item__trigger"></div>
          <p class="carousel-item__title"> <?php echo $item['title']; ?></p>
          <p class="carousel-item__body"><?php echo $item['text']; ?></p>
        </div>
        <?php endforeach ?>
      </div>

      <?php if (isset($block_items_3[1])): ?>
      <div class="col-12 col-md-6 col-lg-5">
        <?php foreach ($block_items_3[1] as $key => $item): ?>
        <div class="carousel-item">
          <div class="carousel-item__trigger"></div>
          <p class="carousel-item__title"> <?php echo $item['title']; ?></p>
          <p class="carousel-item__body"><?php echo $item['text']; ?></p>
        </div>
        <?php endforeach ?>
      </div>
      <?php endif ?>
    </div>
  </div>
</section>
<div class="spacer-h-30 spacer-h-100"></div>
<?php endif ?>

<?php if ($show_block_4): ?>
<section class="mission">
  <div class="container container-fixed">
    <div class="row">
      <div class="col-12 offset-md-1 col-md-10">
        <p class="shift-text">
        <a id="Insuarance" class="visuallyhidden"></a>
       <?php echo $block_text_4; ?>
        </p>
      </div>
      <div class="col-md-6 image-holder">
        <img src="<?php echo $block_4_image ?>" alt="">
        <div class="spacer-h-30 spacer-h-md-0"></div>
      </div>
      <div class="col-md-6 valign-top-md">
        <div class="our-mission">
          <div class="spacer-h-lg-100"></div>
          <span class="carousel-item__title">Clients include:</span>
          <div class="spacer-h-20"></div>
          <?php foreach ($block_items_4 as $key => $item): ?>
          <div class="carousel-item">
            <div class="carousel-item__trigger"></div>
            <p class="carousel-item__title"> <?php echo $item['title']; ?></p>
            <p class="carousel-item__body"><?php echo $item['text']; ?></p>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div><!-- container -->
</section>

<div class="spacer-h-30 spacer-h-100"></div>
<?php endif ?>

<a id="Realestate" class="visuallyhidden"></a>
<section class="contact-section">
<div class="container container-fixed">
  <div class="spacer-h-50"></div>
  <div class="spacer-h-lg-150"></div>
  <div class="row">
    <div class="col-12 col-md-10 offset-md-1">
      <p class="pre-line"><?php echo $we_provide ?></p>
      <div class="spacer-h-30"></div>
      <a href="<?php echo $contact; ?>" class="contact-url">Contact</a>
    </div>
  </div>
</div>
  <div class="spacer-h-lg-150"></div>
  <div class="spacer-h-50"></div>
</section>