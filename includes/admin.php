<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
// https://adambrown.info/p/wp_hooks/hook

// ======================================================================== //		
// PHP Version notice if version < 5.3
// ======================================================================== // 

function php_version_notice() {
  $class = 'notice notice-error';
  $message = __( '<strong>Bootstrap Shortcoder for WordPress</strong> requires PHP version 5.3 or later. You are running PHP version ' . PHP_VERSION . '. Please upgrade to a supported version of PHP.', 'sample-text-domain' );

  printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}

//Only run this if the PHP version is less than 5.3
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
  add_action( 'admin_notices', 'php_version_notice' );
}

// ======================================================================== // 


/* bootstrap-shortcoder-help-all is not needed
// ======================================================================== //		
// Enqueue help button styles
// ======================================================================== // 

function bootstrap_shortcodes_styles_all() {
  wp_register_style( 'bootstrap-shortcoder-help-all', plugins_url( 'bootstrap-shortcoder/includes/templates/css/bootstrap-shortcoder-help-all.css' ) );
  wp_enqueue_style( 'bootstrap-shortcoder-help-all' );
}

add_action( 'admin_enqueue_scripts', 'bootstrap_shortcodes_styles_all' );

// ======================================================================== // 

*/

// ======================================================================== // 

// ======================================================================== //		
// Button creation and styles for the documentation popup button
// ======================================================================== // 
// scavenger: here we will start experimenting with BS 5.3
// ======================================================================== // 

//Function to register and enqueue the documentation stylesheets
function bootstrap_shortcodes_help() {
  // https://getbootstrap.com/docs/5.3/getting-started/download/#cdn-via-jsdelivr
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
  // https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js    // shall be loaded conditionally
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js   // +popper

  wp_register_style( 'modal-shortcodes', plugins_url( 'templates/css/modal-shortcodes.css' , __FILE__ ));
  wp_enqueue_style( 'modal-shortcodes' );

  // wp_register_script( 'popover-shortcodes', plugins_url( 'templates/js/popover-shortcodes.js'.$dev , __FILE__ ));
  wp_register_script( 'modal-shortcodes', plugins_url( 'templates/js/modal-shortcodes.js'.$dev , __FILE__ ));

  // front is conditionally loaded by ['BoostrapShortcodes', 'bootstrap_shortcodes_popper_script']
  // wp_enqueue_scripts( 'popover-shortcodes' ); // need some serious work, and it's just fluff anyway
  // wp_enqueue_scripts( 'modal-shortcodes' ); // defer trick:
  wp_enqueue_scripts(
        'modal-shortcodes',
        plugins_url( 'templates/js/modal-shortcodes.js'.$dev , __FILE__ ),
        [],
        '',
        [ 'strategy' => 'defer' ],
      );

  // bugfix: Visual Composer causes problems
  $handle = 'vc_bootstrap_js';
  $list = 'enqueued'; // *'enqueued', 'registered', 'queue', 'to_do', 'done'
  if (wp_script_is( $handle, $list )) {
    wp_dequeue_script( $handle );
  }
}
add_action( 'media_buttons', 'bootstrap_shortcodes_help' );


// ======================================================================== //		
// Add the Bootstrap Shortcodes buttons to Distraction Free Writing mode - Deprecated?
// ======================================================================== //
function bs_editor_modal($buttons) {
  $buttons[] = 'separator';
  $buttons['bootstrap-shortcoder'] = array(
    'title' => __('Bootstrap Shortcoder Help'),
    'onclick' => "jQuery('#bootstrap-shortcoder-help').modal('show');",
    'both' => false 
  );
  return $buttons;
}
add_action ('wp_fullscreen_buttons', 'bs_editor_modal'); // deprecated
// add_action ('mce_buttons', 'bs_editor_modal');  // TODO: test this



//Function create the documentation popup button
function add_bootstrap_button_modal() {
  //the id of the container I want to show in the popup
  $popup_id = 'bootstrap-shortcoder-help';

  //our popup's title
  $title = 'Bootstrap Shortcodes Help';

  // append the modal button
  // printf(
  // '<a data-bs-toggle="modal" data-bs-target="#bootstrap-shortcoder-help" title="%2$s" href="%3$s" class="%4$s">
  // <span class="bs_bootstrap-logo wp-media-buttons-icon"></span></a>',
  printf(
  '<a data-bs-toggle="modal" data-bs-target="#bootstrap-shortcoder-help" title="%2$s" href="%3$s" class="%4$s">
  🇧</a>',
  esc_attr( $popup_id ),
  esc_attr( $title ),
  esc_url( '#' ),
  esc_attr( 'button add_media bootstrap-shortcoder-button')
  //sprintf( '<img src="%s" style="height: 20px; position: relative; top: -2px;">', esc_url( $img ) )
  );
}
add_action( 'media_buttons', 'add_bootstrap_button_modal' );


//Function create the documentation popover button // does not work properly yet:
// does not close
// needs css to be full width
// needs scroll bar
// internal BS stuff does not seem to work
// why bother, we have a owrking modal
function add_bootstrap_button_popover() {
  // append the popover button
  // printf('<button type="button" class="button add_media bootstrap-shortcoder-button" data-toggle="popover" data-poload="templates/SHORTCODES-compiled.html" title="Insert SHORTCODES" data-content="dummy">🇧</button>');
  printf('<button type="button" class="button add_media bootstrap-shortcoder-button" data-poload="'.BSHORTCODER_URL.'includes/templates/SHORTCODES-compiled.html" title="Insert SHORTCODES">🇧</button>');
}
// add_action( 'media_buttons', 'add_bootstrap_button_popover' );



// add the button to the content editor, next to the media button on any admin page in the array below
// no need to chack where we are, media_buttons is only called with mce
// if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php', 'widgets.php', 'admin-ajax.php'))) {
  // add_action( 'media_buttons', 'bootstrap_shortcodes_help' );
  // add_action( 'media_buttons', 'add_bootstrap_button_modal' );
// }

// ======================================================================== // 



// ======================================================================== //		
// Include the help popup content in the footer oO WHAT??
// scavenger: MY MY MY, no wonder my admin was so slow...
// now it loads only with TinyMCE
// ======================================================================== // 

function boostrap_shortcodes_help_after_mce() {
  include( 'bootstrap-shortcoder-help.php');
}
add_action( 'after_wp_tiny_mce', 'boostrap_shortcodes_help_after_mce' );

// ======================================================================== // 




// ======================================================================== //


/* bootstrap-shortcoder-help-all is not needed
// ======================================================================== //		
// Gravity Forms is bossy.
// Register this script with Gravity Forms (if present) so it isn't stripped out
// ======================================================================== //

function bs_register_script($scripts){
  $scripts[] = "bootstrap-shortcoder-help-all";
  return $scripts;
}

add_filter("gform_noconflict_styles", "bs_register_script");

// ======================================================================== //

*/