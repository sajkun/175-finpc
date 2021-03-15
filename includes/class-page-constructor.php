<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
//***
/**
  * Page Construct Class
  *
  * Constructs page
  *
  * @package theme/helper
  *
  * @since v1.0
  */
class theme_construct_page{

  /**
  * Adds hooks for wordpress template
  * Used templates: index.php
  *
  * @return void
  */
  public static function init(){
    add_action('do_theme_header', array('theme_content_output', 'print_header'));
    add_action('do_theme_footer', array('theme_content_output', 'print_footer'));


    if(self::is_page_type('career-post')){
      add_filter('header_classes', function($classes){ return ' contrast absolute ';});
      add_action('do_theme_content', array('theme_content_output', 'print_herosreen'));
      add_action('do_theme_content', array('theme_content_output', 'print_career_post'));
    } else if(self::is_page_type('gallery-tax')){

      add_action('do_theme_content', array('theme_content_output', 'print_gallery_page'));

    }else{
      add_action('do_theme_content', array('theme_content_output', 'print_content_page'));
    }

    add_action('do_home_page_content', array('theme_content_output', 'print_home_page'));

    add_action('do_team_page_content', array('theme_content_output', 'print_team_page'));

    add_action('do_podcasts_page_content', array('theme_content_output', 'print_podcasts_page'));

    add_action('do_career_page_content', array('theme_content_output', 'print_career_page'));

    add_action('do_downloads_page_content', array('theme_content_output', 'print_downloads_page'));

    add_action('do_faq_page_content', array('theme_content_output', 'print_faq_page'));

    add_action('do_gallery_page_content', array('theme_content_output', 'print_gallery_page'));

    add_action('do_watch_page_content', array('theme_content_output', 'print_watch_page'));

    add_action('do_watch_single_page_content', array('theme_content_output', 'print_watch_single_page'));

    add_action('do_service_single_page_content', array('theme_content_output', 'print_service_single_page'));

    add_action('do_contacts_page_content', array('theme_content_output', 'print_contacts_page'));

    add_action('do_community_page_content', array('theme_content_output', 'print_community_page'));
    add_action('do_community_single_page_content', array('theme_content_output', 'print_community_article'));
  }


  /**
  * Detects what page is currently loaded
  *
  * @return bool
  */
  public static function is_page_type( $type ){
    $obj = get_queried_object();
    switch ($type){
      case 'blog':
        return is_home();
        break;
      case 'fronted-page':
        return is_front_page();
        break;
      case 'blog-category':
        return is_category();
        break;
      case 'blog-post':
        return (is_single() && ('post' === $obj->post_type));
        break;
      case 'post-tag':
        return is_tag();
        break;
      case 'career-post':
        return (is_single() && ('theme_career' === $obj->post_type));
        break;
      case 'gallery-tax':
        return (isset($obj->taxonomy) && ('theme_galleries_tax' === $obj->taxonomy));
        break;
    }
  }
}