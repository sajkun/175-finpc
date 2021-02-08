<?php
/*
Template name: Downloads Page
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
/**
 * The main template file
 *
 * @package theme/templates
 *
 * @since v1.0
 */


get_header();
$data = get_queried_object();

?>
<div class="site-container" id="site-body">
  <?php
    do_action('do_theme_before_header');
    do_action('do_theme_header');
    do_action('do_theme_after_header');
?>
    <main class="site-content">
 <?php
    do_action('do_downloads_page_content');
  ?>
  </main>
 <?php
    do_action('do_theme_before_footer');
    do_action('do_theme_footer');
    do_action('do_theme_after_footer');
  ?>
</div>

<?php
 ?>

<?php get_footer(); ?>
