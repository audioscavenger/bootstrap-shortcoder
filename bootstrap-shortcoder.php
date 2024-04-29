<?php
/*
Plugin Name: Bootstrap Shortcoder
Plugin URI: https://github.com/audioscavenger/bootstrap-shortcoder
Description: The plugin adds a shortcodes for all Bootstrap 3 elements.
Version: 4.0.5
Author: IT Cooking
Author URI: https://gitea.derewonko.com/audioscavenger/bootstrap-shortcoder
License: MIT
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 5.3
Text Domain: bootstrap-shortcoder
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (defined('BSHORTCODER_PLUGIN')) exit;  // Prevent problems if plugin is included twice (#472)

define('BSHORTCODER_PLUGIN', __FILE__);
define('BSHORTCODER_PLUGIN_DIR', __DIR__);
define('BSHORTCODER_URL', plugin_dir_url( __FILE__ ));

/* ============================================================= */
// https://codex.wordpress.org/Shortcode_API
// https://adambrown.info/p/wp_hooks/hook
// https://rachievee.com/the-wordpress-hooks-firing-sequence/

// https://getbootstrap.com/docs/5.3/helpers/color-background/
// https://getbootstrap.com/docs/5.3/utilities/colors/
// https://getbootstrap.com/docs/5.3/utilities/background/
/* ============================================================= */
$debug = false;
// $debug = true;

// ======================================================================== //
// Include necessary functions and files
// ======================================================================== //
// require_once( 'includes/defaults.php' );
// require_once( 'includes/functions.php' );
require_once( 'includes/shortcodes.php' );

if ( is_admin() ) {
  add_action( 'current_screen', 'bs_load_editor_scripts' );
  // add_action( 'after_wp_tiny_mce', 'bs_load_editor_scripts' );
  function bs_load_editor_scripts() {
    $currentScreen = get_current_screen();
    // ------------------------------------------------------------------------------ // posts     pages     post  page
       // echo('<pre>currentScreen      base='.$currentScreen->base.PHP_EOL);         // edit      edit      post  post
            // echo('currentScreen        id='.$currentScreen->id.PHP_EOL);           // edit-post edit-page post  page
    // echo('currentScreen post_type='.$currentScreen->post_type.'</pre>'PHP_EOL);    // post      page      post  page
    if( $currentScreen->id === "post" ) {
      require_once( 'includes/actions-filters.php' );
    }
  }
}

if ( ! class_exists( '\BoostrapShortcodes' ) ) {
  require 'includes/BoostrapShortcodes.php';
}
// new BoostrapShortcodes(); // seems unnecessary

// not sure what this is even for
/* 
if ( ! function_exists( 'BoostrapShortcodes' ) ) {
  // Returns the main instance of BoostrapShortcodes
  // @return BoostrapShortcodes
  
  function BoostrapShortcodes() {
    return \BoostrapShortcodes::instance();
  }

  // \BoostrapShortcodes::init();
  // BoostrapShortcodes();  // seems unnecessary
}
*/

//// Initialize shortcodes
// https://stackoverflow.com/questions/71212439/wordpress-plugin-cant-create-shortcodes-from-within-a-class
add_action( 'init', ['BoostrapShortcodes', 'register_shortcodes'] );

//// Conditionally include popper functionality (see function for conditionals)
// ======================================================================== //
// Conditionally include popper initialization script.
//  Only includes script if content contains [popover|tooltip] shortcode
//  https://getbootstrap.com/docs/5.3/components/popovers/
//  https://getbootstrap.com/docs/5.3/components/tooltips/
// ======================================================================== //
// add_action( 'the_post', array( $this, 'bootstrap_shortcodes_popper_script' ), 9999 );
// add_action( 'the_post', ['BoostrapShortcodes', 'bootstrap_shortcodes_popper_script'], 99 );  // we load bootstrap.bundle now

add_filter('the_content', ['BoostrapShortcodes', 'bs_fix_shortcodes']);

