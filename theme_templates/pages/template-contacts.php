

      <div class="container">
        <div class="border-title">
          <div class="border-title__content">
            <div class="border-title__bg-text">Contact Us</div>
            <h2 class="border-title__text">Contact Us</h2>
          </div>
        </div>


        <div class="spacer-h-50"></div>

        <div class="row contact-data">
          <div class="col-12 col-md-6 col-lg-3">
            <span class="">
              Please contact us for an appointment
              outside of normal working hours.
            </span>

            <div class="spacer-h-30"></div>
            <?php if ($socials): ?>

            <ul class="menu-socials yellow">
              <?php foreach ($socials as $icon => $url):
                 if(!$url) continue;
               ?>
                <li class="<?php echo $icon; ?>"><a href="<?php echo $url; ?>">
                  <svg class="icon svg-icon-<?php echo $icon; ?>"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-<?php echo $icon; ?>"></use> </svg>
                </a></li>
              <?php endforeach ?>
            </ul>
            <?php endif ?>
            <div class="spacer-h-30"></div>
          </div><!-- col-12 col-md-6 col-lg-3 -->

          <?php if ($schedule): ?>
          <div class="col-12 col-md-6 col-lg-3">
            <?php echo $schedule ?>
             <div class="spacer-h-30"></div>
          </div><!-- col-12 col-md-6 col-lg-3 -->
          <?php endif ?>

          <?php if ($address): ?>
          <div class="col-12 col-md-6 col-lg-3">
            <table>
              <tr>
                <td>

                  <i class="icon">
                   <svg class="svg-icon-geo"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-geo"></use> </svg>
                 </i>

                </td>
                <td>
                 <span class="address"><?php echo $address ?></span>

                 <?php if ($address_url): ?>
                 <div class="spacer-h-20"></div>
                 <a target="_blank" class="open-link" href="<?php echo $address_url ?>" >Find us on a map</a>
                </td>
                 <?php endif ?>
              </tr>
            </table>
          </div><!-- col-12 col-md-6 col-lg-3 -->
          <?php endif ?>
          <div class="col-12 col-md-6 col-lg-3">
            <table>

              <?php if ( $email): ?>

              <tr>
                <td>
                  <i class="icon">
                   <svg class="svg-icon-mail"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-mail"></use> </svg>
                 </i>

                </td>
                <td>
                  <a href="mailto:<?php echo $email ?>" class="email"><?php echo $email ?></a>

                </td>
              </tr>
              <?php endif ?>
              <?php if ( $phones): ?>
              <tr>
                <td>
                 <i class="icon">
                    <svg class="svg-icon-phone"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-phone"></use> </svg>
                 </i>
                </td>
                <td>
                  <?php
                   $phones = explode(PHP_EOL, $phones);
                   foreach ($phones as $key => $p): ?>
                  <a href="tel:<?php echo preg_replace('/\W/', '', $p); ?>" class="phone"><?php echo $p; ?></a>
                  <?php endforeach ?>
                </td>
              </tr>
              <?php endif ?>
            </table>
          </div><!-- col-12 col-md-6 col-lg-3 -->
        </div><!-- row contact-data -->

      </div><!-- container -->

      <?php if ($shortcode): ?>
      <div class="section-map">
        <div class="spacer-h-60 spacer-h-lg-150"></div>
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-6 offset-md-6 ">
                <div class="section-title">Request a call back</div>
                <div class="spacer-h-30"></div>
                <div class="form-container">
                  <?php echo do_shortcode($shortcode) ?>
                </div>
            </div>
          </div><!-- row -->
        </div><!-- container -->
        <div class="spacer-h-60 spacer-h-lg-150"></div>
      </div>
      <?php endif ?>