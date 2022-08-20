<?php
/**
 * DKNG Plugin
 *
 * @package           Dkng\Wp
 *
 * @wordpress-plugin
 * Plugin Name:       DKNG Plugin
 * Plugin URI:        brbr
 * Description:       DKNG Plugin.
 * Version:           1.0.1
 * Author:            brbr
 * Author URI:
 * License:           GPL-2.0+
 * License URI:
 * Text Domain:       dkng-plugin
 * Domain Path:       /languages
 */

use Dkng\Wp\Start;

if (!defined('WPINC')) {
    die;
}

// Define SVN_PLUGIN_PATH.
if ( !defined( 'SVN_PLUGIN_PATH' ) ) {
    define( 'SVN_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

// Define SVN_PLUGIN_URL.
if ( !defined( 'SVN_PLUGIN_URL' ) ) {
    define( 'SVN_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
}

// Define SVN_PLUGIN_URL.
if ( !defined( 'SVN_PLUGIN_TPLS' ) ) {
    define( 'SVN_PLUGIN_TPLS', SVN_PLUGIN_PATH . 'src/templates/');
}

call_user_func(function() {
    require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

    $plugin = new Start(__FILE__);
    $plugin->run();


    add_action( 'plugins_loaded', array( Dkng\Wp\PageTemplater::class, 'get_instance' ) );
});

register_activation_hook( __FILE__, array( Dkng\Wp\Activation::class, 'do_my_hook' ) );
register_deactivation_hook( __FILE__, array( Dkng\Wp\Deactivation::class, 'do_my_hook' ) );