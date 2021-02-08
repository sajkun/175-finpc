<?php
/**
 * Adds options to the customizer for theme.
 *
 * @package theme
 */
defined( 'ABSPATH' ) || exit;

class velesh_theme_customizer{
    /**
   * Constructor.
   */
  public function __construct() {
    add_action( 'customize_register', array( $this, 'add_sections' ) );

    add_action( 'customize_controls_enqueue_scripts', array( $this, 'add_scripts' ), 999 );
  }



  /**
   * Add settings to the customizer.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_sections( $wp_customize ) {
    $this->add_custom_section( $wp_customize );
  }


  /**
   * Store site header section.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_site_header( $wp_customize ){
    $wp_customize->add_setting(
        'theme_header_logo_mob',
        array(
            'default'    =>  '',
            'transport'  =>  'postMessage',
            'type'       => 'option',
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize,
        'theme_header_logo_mob',
        array(
          'label' => __('Logo for Mobiles', 'theme-translations'),
          'section' => 'title_tagline',
          'settings' => 'theme_header_logo_mob',
          'priority' => 8 )
      )
    );

    $wp_customize->add_setting(
        'theme_header_logo_contrast',
        array(
            'default'    =>  '',
            'transport'  =>  'postMessage',
            'type'       => 'option',
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize,
        'theme_header_logo_contrast',
        array(
          'label' => __('Contrast Logo', 'theme-translations'),
          'section' => 'title_tagline',
          'settings' => 'theme_header_logo_contrast',
          'priority' => 8 )
      )
    );

    $wp_customize->add_setting(
        'theme_header_logo_contrast_mob',
        array(
            'default'    =>  '',
            'transport'  =>  'postMessage',
            'type'       => 'option',
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
        $wp_customize,
        'theme_header_logo_contrast_mob',
        array(
          'label' => __('Contrast Logo for Mobiles', 'theme-translations'),
          'section' => 'title_tagline',
          'settings' => 'theme_header_logo_contrast_mob',
          'priority' => 8 )
      )
    );
  }


  /**
   * Scripts to improve our form.
   */
  public function add_scripts() {
      wp_enqueue_script('velesh_theme_customizer', THEME_URL .'/script/customizer.js', array( 'jquery','customize-preview' ), '', true );
  }

  /**
   * Store site footer section.
   *
   * @param WP_Customize_Manager $wp_customize Theme Customizer object.
   */
  public function add_custom_section( $wp_customize ){

    /*footer settings*/

      $wp_customize->add_section(
          'theme_footer_section',
          array(
              'title'       => 'Theme Footer',
              'priority'    => 300,
              'description' => ' This section is designed to change displaying of footer settings'
          )
      );


        $wp_customize->add_setting(
            'theme_logo_contrast',
            array(
                'default'    =>  '',
                'transport'  =>  'postMessage',
                'type'       => 'option',
            )
        );

        $wp_customize->add_control(
          new WP_Customize_Image_Control(
            $wp_customize,
            'theme_logo_contrast',
            array(
              'label' => __('Contrast Logo', 'theme-translations'),
              'section' => 'theme_footer_section',
              'settings' => 'theme_logo_contrast',
              'priority' => 8 )
          )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_logo_contrast', array(
            'selector' => '.site-footer .footer-logo',
        ) );



        /****************************/
        $wp_customize->add_setting(
            'url_twitter',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
          'url_twitter',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Twitter URL', 'theme-translations'),
              'type'      => 'text
              ',
              'settings'  => 'url_twitter',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'url_twitter', array(
            'selector' => '.menu-socials .twitter',
        ) );

        $wp_customize->add_setting(
            'url_facebook',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );


        /****************************/

        $wp_customize->add_setting(
            'url_facebook',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
          'url_facebook',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Facebook URL', 'theme-translations'),
              'type'      => 'text
              ',
              'settings'  => 'url_facebook',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'url_facebook', array(
            'selector' => '.menu-socials .facebook',
        ) );

        /****************************/

        $wp_customize->add_setting(
            'url_instagram',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );


        $wp_customize->add_control(
          'url_instagram',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Instagram URL', 'theme-translations'),
              'type'      => 'text
              ',
              'settings'  => 'url_instagram',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'url_instagram', array(
            'selector' => '.menu-socials .instagram',
        ) );

        /****************************/

        $wp_customize->add_setting(
            'url_youtube',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );


        $wp_customize->add_control(
          'url_youtube',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Youtube URL', 'theme-translations'),
              'type'      => 'text
              ',
              'settings'  => 'url_youtube',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'url_youtube', array(
            'selector' => '.menu-socials .youtube',
        ) );

        /***********************/
        /***********************/
        /***********************/

        $wp_customize->add_setting(
            'before_footer_scedule',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
          'before_footer_scedule',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Schedule', 'theme-translations'),
              'type'      => 'textarea',
              'settings'  => 'before_footer_scedule',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'before_footer_scedule', array(
                      'selector' => '.site-footer .before-schedule',
        ) );


        $wp_customize->add_setting(
            'footer_scedule',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );

        $wp_customize->add_control(
          'footer_scedule',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Schedule', 'theme-translations'),
              'type'      => 'textarea',
              'settings'  => 'footer_scedule',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'footer_scedule', array(
            'selector' => '.site-footer .schedule',
        ) );



      /*copyrights setting*/

        $wp_customize->add_setting(
            'theme_footer_copyrights',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );


        $wp_customize->add_control(
          'theme_footer_copyrights',
          array(
              'section'   => 'theme_footer_section',
              'label'     => __('Copyrights', 'theme-translations'),
              'type'      => 'textarea',
              'settings'  => 'theme_footer_copyrights',
          )
        );

        $wp_customize->selective_refresh->add_partial( 'theme_footer_copyrights', array(
            'selector' => '.copyrights',
        ) );

        /***********************/
        /***********************/
        /***********************/

        $wp_customize->add_setting(
            'theme_page_term_page',
            array(
                'default'    => '',
                'transport'  => 'postMessage',
                'type'       => 'option'
            )
        );

        $pages = get_posts(array(
          'post_type' => 'page',
          'posts_per_page' => -1,
        ));

        $choices = array_column($pages, 'post_title', 'ID');

        $wp_customize->add_control( 'theme_page_term_page', array(
          'type' => 'select',
          'section' => 'theme_footer_section', // Add a default or your own section
          'label' => __( 'Terms and Conditions page' ),
          'choices' => $choices,
        ) );

        $wp_customize->selective_refresh->add_partial( 'theme_page_term_page', array(
            'selector' => '.site-footer .terms',
        ) );

     /**/
  }


}

new velesh_theme_customizer();
