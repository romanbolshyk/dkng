<?php

namespace Dkng\Wp;

/**
 * Class Plugin
 *
 * @package Dkng\Wp
 */
class Start {

    const TAG = 'dkng-plugin';

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * Plugin constructor.
     *
     * @param string $mainFile
     */
    public function __construct($mainFile) {
        $this->fileManager = new FileManager($mainFile);
        $this->jquery_script_method();
        $this->registerHooks();
    }

    /**
     * Function register hooks
     *
     */
    private function registerHooks() {

        $functions         = new Functions();
        $custom_actions    = new CustomActions();
        $ogoloshennya      = new Ogoloshennya();
        $novyny            = new Novyny();
        $specialities      = new Specialities();
        $galereya          = new Galereya();


        add_theme_support( 'post-thumbnails' );

        add_action( 'init',            [ $functions,         'init_actions' ] );
        add_action( 'init',            [ $galereya,          'init_actions' ] );
        add_action( 'init',            [ $ogoloshennya,      'init_actions' ] );
        add_action( 'init',            [ $custom_actions,    'init_actions' ] );
        add_action( 'init',            [ $specialities,      'init_actions' ] );

        add_action( 'init',            [ $novyny,            'init_actions' ] );

        add_action( 'init',            [ $this,              'change_permalinks' ] );
        add_action( 'init',            [ $this,              'custom_settings' ] );

    }

    /**
     * Run plugin part
     */
    public function run() {
        $this->jquery_script_method();
    }

    /**
     * Mails settings block
     *
     */
    public function custom_settings() {
        if ( function_exists( 'acf_add_options_page' ) ) {
            acf_add_options_page( array(
                'page_title' => 'Додаткові Налаштування сайту',
                'menu_title' => 'Додаткові Налаштування сайту',
                'menu_slug'  => 'theme_settings',
                'capability' => 'edit_posts',
                'redirect'   => false
            ));
        }
    }


    /**
     * Functions register and enqueue styles and scripts
     *
     */
    public function jquery_script_method() {

        add_action( 'admin_enqueue_scripts', function (){
            $date_now = date('m.d.H.s');

            wp_register_script( 'wp-admin-script',  plugins_url( '../assets/wp-admin-script.js', __FILE__ ), array('jquery'), $date_now, true );
            wp_enqueue_script( 'wp-admin-script' );
        });

        add_action( 'wp_enqueue_scripts', function (){
            $date_now = date('H.s');

            wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, null, false );
            wp_enqueue_script( 'jquery' );

            wp_register_script( 'admin-script',   plugins_url( '../assets/admin-script.js', __FILE__ ), array('jquery'), $date_now, true );

            if ( function_exists('is_user_logged_in' ) ) {

                if (is_user_logged_in()) {
                    wp_enqueue_script( 'admin-script' );
                }
            }

            if (  !empty( $_GET['s'] ) ) {
                wp_enqueue_style( 'template-css', plugins_url( '../assets/template.css', __FILE__ ), 'all', date('m.d.H') );
            }


            wp_register_script( 'script',      plugins_url( '../assets/script.js', __FILE__ ), array('jquery'), $date_now, true );
            wp_register_script( 'script-new',  plugins_url( '../assets/script-new.js', __FILE__ ), array('jquery'), $date_now, true );
            wp_enqueue_script( 'script' );
            wp_enqueue_script( 'script-new' );

            wp_enqueue_style( 'announces',  plugins_url( '../assets/announces.css', __FILE__ ), 'all', $date_now );

            wp_enqueue_style( 'fonts',  get_template_directory_uri() . '/dist/fonts/fonts.css' );
            wp_enqueue_style( 'dkng',       plugins_url( '../assets/dkng.css', __FILE__ ), 'all', $date_now );
            wp_enqueue_style( 'style',      plugins_url( '../assets/style.css', __FILE__ ), 'all', $date_now );
            wp_enqueue_style( 'style-new',  plugins_url( '../assets/style-new.css', __FILE__ ), 'all', $date_now );

            wp_localize_script( 'script', 'get',
                array (
                    'ajaxurl' => admin_url( 'admin-ajax.php' ),
                    'siteurl' => get_template_directory_uri(),
                )
            );
        }, 999);
    }

    /**
     * Save permalinks after activation plugin
     *
     */
    public function change_permalinks() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
        $wp_rewrite->flush_rules();
    }

    /**
     * Function clearing WP Rocket cache
     *
     */
    public function clear_rocket_cache() {
        // Clear cache.
        if ( function_exists( 'rocket_clean_domain' ) ) {
            rocket_clean_domain();
        }
    }

}
