<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
// https://adambrown.info/p/wp_hooks/hook

//Function to register and enqueue the documentation stylesheets
function bootstrap_shortcodes_scripts() {
  // https://getbootstrap.com/docs/5.3/getting-started/download/#cdn-via-jsdelivr
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
  // https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js    // shall be loaded conditionally
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js   // +popper

  //// bootstrap-shortcoder/includes/BestEditor/class-best-editor.php
  if (wp_script_is( 'bootstrap', 'enqueued' )) {  // *'enqueued', 'registered', 'queue', 'to_do', 'done'
    wp_dequeue_script( 'bootstrap' );
  }

  // function dequeue_dequeue_bootstrap_script(){
      // wp_dequeue_style( 'bootstrap' ); //Name of Style ID.
  // }
  // add_action( 'wp_enqueue_scripts', 'dequeue_dequeue_bootstrap_script' );

  // front popper is conditionally loaded by \BootstrapShortcodes\bootstrap_shortcodes_popper_script
  // wp_register_script( 'popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js' ); 
  // wp_register_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js' );
  wp_register_script( 'bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' );

  // front is conditionally loaded by ['BoostrapShortcodes', 'bootstrap_shortcodes_popper_script']
  // wp_enqueue_scripts( 'popper' );
  // wp_enqueue_scripts( 'bootstrap' );
  wp_enqueue_scripts( 'bootstrap-bundle' );

}
add_action( 'media_buttons', 'bootstrap_shortcodes_scripts' );
