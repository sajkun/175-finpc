<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * The main output class
 *
 * @package theme/output
 *
 * @since v1.0
 */
class theme_content_output{

  /**
  * prints header
  *
  * @hookedto
  */
  public static function print_header(){

    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
    $custom_logo_url = ($custom_logo_url)? $custom_logo_url : THEME_URL.'/assets/images/logo.png';

    $logo = (!is_front_page())? sprintf('<a href="%s" class="logo"><img src="%s" alt=""></a>', home_url() , $custom_logo_url) : sprintf('<span class="logo"><img src="%s" alt=""></span>', $custom_logo_url) ;

    $contact_page = get_option('theme_page_contact_page');

    $contact_page_btn   = $contact_page? sprintf('<a href="%s" class="button">Contact US</a>', get_permalink((int)$contact_page) ): '';

    $main_menu = wp_nav_menu( array(
      'theme_location'  => 'main_menu',
      'menu'            => '',
      'container'       => 'nav',
      'container_class' => 'main-menu-cont menu-holder',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => false,
      'fallback_cb'     => '',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'.$contact_page_btn ,
      'depth'           => 2,
    ) );

    $args = array(
      'logo'        => $logo,
      'main_menu'   => $main_menu,
      // 'classes' => ' contrast absolute ',
    );

    print_theme_template_part('header', 'globals', $args);
  }


  /**
  * Prints page content
  *
  * @hookedto do_theme_header 10
  *
  * @see  [theme_folder]/includes/class-page-constructor.php line 22
  */
  public static function print_page_content(){}


  /**
  * Prints page footer
  *
  * @hookedto do_theme_footer 10
  *
* @see  [theme_folder]/includes/class-page-constructor.php line 23
  */
  public static function print_footer(){

    $custom_logo_id = get_option( 'theme_logo_contrast' );
    $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );

    $custom_logo_url = ($custom_logo_url)? $custom_logo_url : THEME_URL.'/assets/images/logo-w.png';

    $logo = (!is_front_page())? sprintf('<a href="%s" class="footer-logo"><img src="%s" alt=""></a>', home_url() , $custom_logo_url) : sprintf('<span class="footer-logo"><img src="%s" alt=""></span>', $custom_logo_url) ;

    $copyrights = get_option('theme_footer_copyrights');

    $date = new DateTime();

    $copyrights = str_replace('{year}', $date->format('Y'), $copyrights);

    $terms_page = (int)get_option('theme_page_term_page');

    $footer_menu = wp_nav_menu( array(
      'theme_location'  => 'footer_menu',
      'menu'            => '',
      'container'       => '',
      'container_class' => '',
      'container_id'    => '',
      'menu_class'      => 'footer-menu',
      'menu_id'         => '',
      'echo'            => false,
      'fallback_cb'     => '',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' ,
      'depth'           => 1,
    ) );


    $args = array(
      'footer_menu'       => $footer_menu,
      'logo'       => $logo,
      'copyrights' => $copyrights,
      'term_url'   => $terms_page ? get_permalink($terms_page ) : false,
      'socials'    => array(
        'twitter' => get_option('url_twitter'),
        'facebook' => get_option('url_facebook'),
        'instagram' => get_option('url_instagram'),
        'youtube' => get_option('url_youtube'),
      ),

      'before_footer_scedule' => get_option('before_footer_scedule'),
      'footer_scedule' => get_option('footer_scedule'),
    );

    print_theme_template_part('footer', 'globals', $args);
  }


  public static function print_home_page(){

    if(!function_exists('get_field')){
      echo 'ACF plugin required!';
      return;
    }

    $obj_id = get_queried_object_id();

    $bg_image_id    = get_field('welcome_background_image', $obj_id);
    $mission_id     = get_field('our_mission_image', $obj_id);


    $args = array(
      'post_type' => 'theme_media',
      'posts_per_page' => -1
    );

    if(get_field('media_items', $obj_id)){
      $args['post__in'] = get_field('media_items', $obj_id);
    }


    $video = get_posts($args)?: array();

    $video = array_map(function($el){
      $date = new DateTime($el->post_date);
      $id = get_post_thumbnail_id( $el->ID );

      return array(
        'title' => $el->post_title,
        'image' => wp_get_attachment_image_url($id , 'video_thumb'),
        'url'   => trim(str_replace('watch?v=', '',get_field('video_url', $el->ID ))),
        'date'  => $date->format('d F'),
      );
    }, $video);

    $testimonials = get_posts(array(
      'post_type' => 'theme_testimonials',
      'posts_per_page' => -1
    ));

    $testimonials = array_map(function($el){
      $id   = get_post_thumbnail_id( $el->ID );

      return array(
        'text'  => get_field('text', $el->ID ),
        'name'  => get_field('name', $el->ID ),
        'position'  => get_field('position', $el->ID ),
        'video_url' => trim(str_replace('watch?v=', '',get_field('video_url', $el->ID ))),
        'image' => wp_get_attachment_image_url($id , 'full'),
      );
    }, $testimonials);

    $args = array(
      'welcome' => array(
        'bg' => $bg_image_id  ?  wp_get_attachment_image_url($bg_image_id , 'full') : '',
        'title' => get_field('welcome_title', $obj_id),
        'text' => get_field('welcome_text', $obj_id),
        'video_url' => trim(str_replace('watch?v=', '',get_field('video_url', $obj_id))),

        'address' =>   str_replace(PHP_EOL, '<br>', get_field('welcome_address', $obj_id)),
        'address_url' => get_field('welcome_address_url', $obj_id),
        'email' => get_field('welcome_email', $obj_id),
        'phones' => get_field('welcome_phones', $obj_id),
      ),

      'mission' => array(
        'img' => $mission_id  ?  wp_get_attachment_image_url($mission_id , 'full') : '',
        'title'        => get_field('our_mission_title', $obj_id),
        'title_border' => get_field('our_mission_title_border', $obj_id),
        'text'         =>  apply_filters('the_content',get_field('our_mission_text', $obj_id)),
      ),

      'wedo' => array(
        'title'        => get_field('wedo_title', $obj_id),
        'title_border' => get_field('wedo_title_border', $obj_id),
        'items'        => get_field('wedo_items', $obj_id),
        'url'          => get_permalink(get_field('wedo_service_page', $obj_id)),
      ),

      'videos' => array(
        'title'        => get_field('media_title', $obj_id),
        'title_border' => get_field('media_title_border', $obj_id),
        'items'        => $video,
      ),

      'steps' => array(
        'title'        => get_field('steps_title', $obj_id),
        'title_border' => get_field('steps_title_border', $obj_id),
        'items'        => get_field('steps_items', $obj_id),
      ),

      'testimonials' => $testimonials,

      'form' => get_field('contact_form', $obj_id),

      'socials'    => array(
        'twitter'   => get_option('url_twitter'),
        'facebook'  => get_option('url_facebook'),
        'instagram' => get_option('url_instagram'),
        'youtube'   => get_option('url_youtube'),
      ),
    );

    print_theme_template_part('home', 'pages', $args);
  }


  public static function print_team_page(){

    if(!function_exists('get_field')){
      echo 'ACF plugin required!';
      return;
    };
    $obj = get_queried_object();
    $obj_id = get_queried_object_id();

    $bg = (int)get_field('bg', $obj_id);

    $team = get_posts(array(
      'post_type' => 'theme_team',
      'posts_per_page' => -1,
    ));

    $team = array_map(function($el){
      $id = (int)get_field('photo', $el->ID );

      return array(
        'name'     => get_field('name', $el->ID ),
        'about'    => get_field('about', $el->ID ),
        'photo'    => wp_get_attachment_image_url($id , 'team_photo'),
        'position' => get_field('position', $el->ID ),
      );
    }, $team);

    $args = array(
      'bg'   =>  wp_get_attachment_image_url($bg , 'full')?: '',
      'title' => get_field('title', $obj_id)?: $obj->post_title,
      'text' => get_field('text', $obj_id),
      'team' => $team,
    );

    print_theme_template_part('team', 'pages', $args);
  }


  public static function print_podcasts_page(){

    if(!function_exists('get_field')){
      echo 'ACF plugin required!';
      return;
    };

    $obj    = get_queried_object();
    $obj_id = $obj->ID;

    $bg = (int)get_field('bg', $obj_id);

    $media = get_posts(array(
      'post_type' => 'theme_podcasts',
      'posts_per_page' => -1,
    ));

    $media = array_map(function($el){
      $id = (int)get_post_thumbnail_id( $el->ID );

      return array(
        'title'              => $el->post_title,
        'number_of_episodes' => get_field('number_of_episodes', $el->ID ),
        'learn_more_ulr'     => get_field('learn_more_ulr', $el->ID ),
        'google_play_url'    => get_field('google_play_url', $el->ID ),
        'image'              => wp_get_attachment_image_url($id , 'podcasts_img'),
        'spotify_url'        => get_field('spotify_url', $el->ID ),
      );
    }, $media);

    $args = array(
      'bg'    => wp_get_attachment_image_url($bg , 'full')?: '',
      'title' => get_field('title', $obj_id)?: $obj->post_title,
      'text'  => get_field('text', $obj_id),
      'media' => $media,
    );

    print_theme_template_part('media', 'pages', $args);
  }


  public static function print_career_page(){
    if(!function_exists('get_field')){
      echo 'ACF plugin required!';
      return;
    };

    $obj    = get_queried_object();
    $obj_id = $obj->ID;
    $bg     = (int)get_field('bg', $obj_id);
    $cta_image     = get_field('cta_image', $obj_id);

    $cta_requirments = explode(PHP_EOL, get_field('cta_requirments', $obj_id));

    $positions = get_posts(array(
      'post_type'      => 'theme_career',
      'posts_per_page' => -1,
    ));


    $positions = array_map(function($el){
      $id   = get_post_thumbnail_id( $el->ID );

      return array(
        'title'  => $el->post_title,
        'department' => get_field('department', $el->ID ),
        'location'   => get_field('location', $el->ID ),
        'url'        => get_permalink($el),
      );
    }, $positions);

    $args = array(
      'bg'    => wp_get_attachment_image_url($bg , 'full')?: '',
      'title' => get_field('title', $obj_id)?: $obj->post_title,
      'text'  => get_field('text', $obj_id),
      'cta_title'  => get_field('cta_title', $obj_id),
      'cta_title_border' => get_field('cta_title_border', $obj_id),
      'cta_text'         => get_field('cta_text', $obj_id),
      'cta_requirments'  => $cta_requirments,
      'cta_image'        => $cta_image,
      'positions'        => $positions,
    );


    print_theme_template_part('career', 'pages', $args);
  }


  public static function print_herosreen(){
    if(!function_exists('get_field')){
      echo 'ACF plugin required!';
      return;
    };

    $obj    = get_queried_object();
    $obj_id = $obj->ID;

    $bg     = (int)get_field('bg', $obj_id);

    $args = array(
      'bg'    => wp_get_attachment_image_url($bg , 'full')?: '',
      'title' => get_field('title', $obj_id)?: $obj->post_title,
      'text'  => get_field('text', $obj_id),
    );

    print_theme_template_part('heroscreen', 'globals', $args);
  }

  public static function print_career_post(){
    if(!function_exists('get_field')){
      echo 'ACF plugin required!';
      return;
    };

    $obj    = get_queried_object();
    $obj_id = $obj->ID;

    $responsibility = get_field('responsibility', $obj_id)? explode(PHP_EOL,  get_field('responsibility', $obj_id)) : false;
    $qualifications = get_field('qualifications', $obj_id)? explode(PHP_EOL,  get_field('qualifications', $obj_id)) : false;
    $requirements   = get_field('requirements', $obj_id)? explode(PHP_EOL,  get_field('requirements', $obj_id)) : false;

    $args = array(
      'location'        => get_field('location', $obj_id)? : '-----',
      'education'       => get_field('education', $obj_id)? : '-----',
      'department'      => get_field('department', $obj_id)? : '-----',
      'date_closed'     => get_field('date_closed', $obj_id)? : '-----',
      'career_level'    => get_field('career_level', $obj_id)? : '-----',
      'experiences_yrs' => get_field('experiences_yrs', $obj_id)? : '-----',
      'responsibility'  => $responsibility,
      'qualifications'  => $qualifications,
      'requirements'    => $requirements,
      'cta_form'       => get_field('cta_form', $obj_id),
    );

    print_theme_template_part('content', 'careers', $args);
  }


  public static function print_downloads_page(){
    global $theme_init;
    $args = array();


    $downloads = get_posts(array(
      'post_type'      => 'theme_downloads',
      'posts_per_page' => -1,
    ));

    $downloads = array_map(function($el){
      $id   = get_post_thumbnail_id( $el->ID );

      $urls = get_field('downloads_link', $el->ID);

      $urls_res = array_map(function($el){
        $data = explode('.', $el['url']);
        return $data[ count($data) - 1 ];
      }, $urls );

      $urls = array_map(function($el){
        return $el['url'];
      }, $urls );

      return array(
        'title'  => $el->post_title,
        'thumb'  => wp_get_attachment_image_url($id , 'downloads_img'),
        'links'    => array_combine($urls_res, $urls),
      );
    }, $downloads);

    wp_localize_script($theme_init->main_script_slug,'downloads', $downloads);

    print_theme_template_part('downloads', 'pages', $args);
  }


  public static function print_faq_page(){
    $faq = get_posts(array(
      'post_type'      => 'theme_faq',
      'posts_per_page' => -1,
    ));

    $args = array(
      'faq' => $faq,
    );

    print_theme_template_part('faq', 'pages', $args);
  }


  public static function print_gallery_page(){
    global $theme_init;
    $obj = get_queried_object();

    $theme_galleries_tax = get_terms( [
        'taxonomy' => 'theme_galleries_tax',
        'hide_empty' => false,
      ] );

    $gallery = get_option('theme_page_gallery_page');


    $args =array(
      'post_type'      => 'theme_galleries',
      'posts_per_page' => -1,
    );


    if(isset($obj->taxonomy) && $obj->taxonomy== 'theme_galleries_tax'){
       $args['tax_query'] = array(
        array(
          'taxonomy' => 'theme_galleries_tax',
          'field' => 'id',
          'terms' => $obj->term_id,
        ) );
    }

    $galleries = get_posts($args);

    $galleries = array_map(function($el){
      $id   = get_post_thumbnail_id( $el->ID );

     $tags   = get_field('hastags', $el->ID);
     $images = get_field('images', $el->ID)?: array();

     $images = array_map(function($el){
       return array('href' => $el);
     }, $images);


      return array(
        'thumb'  => wp_get_attachment_image_url($id , 'gallery_img'),
        'tags' => get_field('hastags', $el->ID),
        'items' =>  $images,
        'date'  => $el->post_date,
      );
    }, $galleries);


    wp_localize_script($theme_init->main_script_slug,'gallery_items', $galleries);

    $args = array(
      'obj' => $obj,
      'all' => get_permalink($gallery),
      'theme_galleries_tax' => $theme_galleries_tax,
    );

    print_theme_template_part('gallery', 'pages', $args);
  }

  /**
  * Prints contentof a page
  *
  * @hookedto do_theme_content 10
  *
  * @see  [theme_folder]/includes/class-page-constructor.php line 24
  */
  public static function print_content_page(){
    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        the_content();
      endwhile;
    endif;
  }
}