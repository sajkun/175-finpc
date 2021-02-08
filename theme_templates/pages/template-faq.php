<div class="page-title">
  <div class="container container-fixed">
    <div class="page-title__bg-text">FAQs</div>
    <h2 class="page-title__text">FAQs</h2>
  </div>
</div>

<section class="faq-container">
  <div class="container">
    <div class="spacer-h-30"></div>
    <div class="row">
      <div class="col-lg-8 valign-center-lg">
        <?php foreach ($faq as $key => $f): ?>
        <div class="faq-item">
          <div class="faq-item__trigger"></div>
          <p class="faq-item__title"><?php echo $f->post_title; ?></p>
          <p class="faq-item__body"><?php echo strip_tags($f->post_content); ?></p>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <div class="spacer-h-30 spacer-h-lg-70"></div>
  </div>
</section>