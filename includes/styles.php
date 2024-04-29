<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
// https://adambrown.info/p/wp_hooks/hook

//Function to register and enqueue the documentation stylesheets
function bootstrap_shortcodes_styles() {
  // https://getbootstrap.com/docs/5.3/getting-started/download/#cdn-via-jsdelivr
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
  // https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js    // shall be loaded conditionally
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js
  // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js   // +popper

  //// bootstrap-shortcoder/includes/BestEditor/class-best-editor.php
  if (wp_style_is( 'bootstrap', 'enqueued' )) {  // *'enqueued', 'registered', 'queue', 'to_do', 'done'
      ( 'bootstrap' );
  }

  // function dequeue_dequeue_bootstrap_style(){
      // wp_dequeue_style( 'bootstrap' ); //Name of Style ID.
  // }
  // add_action( 'wp_enqueue_style', 'dequeue_dequeue_bootstrap_style' );

  wp_register_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );
  wp_register_style( 'bs-callout', plugins_url( 'css/bs-callout.css' , __FILE__ ));
  
  wp_enqueue_style( 'bootstrap' );
  wp_enqueue_style( 'bs-callout' );
  wp_enqueue_style( 'modal-shortcodes' );

}
add_action( 'media_buttons', 'bootstrap_shortcodes_styles' );

