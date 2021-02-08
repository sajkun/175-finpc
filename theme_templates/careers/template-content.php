<div class="container-md">
  <h2 class="block-title">Tax Associate - Remote</h2>
  <div class="spacer-h-30 spacer-h-lg-50"></div>
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-6 col-lg-5 descr-label">Department</div>
        <div class="col-6 col-lg-5 descr-value"><?php echo $department; ?></div>
      </div>
      <div class="spacer-h-30"></div>
      <div class="row">
        <div class="col-6 col-lg-5 descr-label">Experiences Yrs</div>
        <div class="col-6 col-lg-5 descr-value"><?php echo $experiences_yrs; ?></div>
      </div>
      <div class="spacer-h-30"></div>
      <div class="row">
        <div class="col-6 col-lg-5 descr-label">Location</div>
        <div class="col-6 col-lg-5 descr-value"><?php echo $location; ?></div>
      </div>
      <div class="spacer-h-30"></div>
    </div><!-- col-md-6 -->

    <div class="col-md-6">
      <div class="row">
        <div class="col-6 col-lg-5 descr-label">Education</div>
        <div class="col-6 col-lg-5 descr-value"><?php echo $education; ?></div>
      </div>
      <div class="spacer-h-30"></div>
      <div class="row">
        <div class="col-6 col-lg-5 descr-label">Career Level</div>
        <div class="col-6 col-lg-5 descr-value"><?php echo $career_level; ?></div>
      </div>
      <div class="spacer-h-30"></div>
      <div class="row">
        <div class="col-6 col-lg-5 descr-label">Date Closed</div>
        <div class="col-6 col-lg-5 descr-value"><?php echo $date_closed; ?></div>
      </div>
      <div class="spacer-h-30"></div>
    </div><!-- col-md-6 -->
  </div><!-- row -->
</div>
<div class="spacer-h-30 spacer-h-lg-70"></div>

<div class="container-md">
  <div class="row  gutters-lg-50">
    <?php if ($responsibility): ?>
    <div class="col-lg-6">
      <h3 class="sub-title">
        Responsibility
      </h3>
      <div class="spacer-h-20 spacer-h-lg-50"></div>
      <ul class="regular-list">
        <?php foreach ($responsibility as $key => $item): ?>
        <li><?php echo $item; ?></li>
        <?php endforeach ?>
       </ul>
    </div><!-- col-lg-6 -->
    <?php endif ?>
    <?php if ($qualifications || $requirements): ?>
    <div class="col-lg-6">
      <?php if ( $qualifications ): ?>
      <h3 class="sub-title">
        Skills &amp; Experiences
      </h3>
      <div class="spacer-h-20 spacer-h-lg-50"></div>
        <h4 class="list-title">Qualifications:</h4>
        <ul class="regular-list">
          <?php foreach ($qualifications as $key => $item): ?>
          <li><?php echo $item; ?></li>
          <?php endforeach ?>
        </ul>
        <div class="spacer-h-30"></div>
        <?php endif ?>
        <?php if ( $requirements ): ?>
        <h4 class="list-title">Requirements:</h4>
        <ul class="regular-list">
          <?php foreach ($requirements as $key => $item): ?>
          <li><?php echo $item; ?></li>
          <?php endforeach ?>
        </ul>
        <?php endif ?>
     </div><!-- col-lg-6 -->
    <?php endif ?>
  </div>
</div>

<div class="spacer-h-30 spacer-h-lg-60"></div>

<?php if ($cta_form): ?>
<section class="form-holder">
 <div class="container-md">
  <div class="row">
    <div class="col-lg-5">
       <div class="spacer-h-lg-100"></div>
       <h4 class="section-title">Apply Job</h4>
       <div class="spacer-h-30 spacer-h-lg-60"></div>
       <div class="form-container">
          <?php echo do_shortcode(sprintf('[contact-form-7 id="%s" title="%s"]', $cta_form->ID, $cta_form->post_title)); ?>
       </div>
       <div class="spacer-h-lg-70"></div>
    </div>
  </div><!-- row -->
 </div><!-- container-md -->
  <div class="spacer-h-50 spacer-h-lg-80"></div>
</section>
<?php endif ?>