<?php
/*
Plugin Name: Bootstrap Shortcoder
Plugin URI: https://github.com/audioscavenger/bootstrap-shortcoder
Description: The plugin adds a shortcodes for all Bootstrap 3 elements.
Version: 4.0.4
Author: IT Cooking
Author URI: https://gitea.derewonko.com/audioscavenger/bootstrap-shortcoder
License: MIT
*/

/* ============================================================= */
// https://codex.wordpress.org/Shortcode_API
// https://getbootstrap.com/docs/5.3/helpers/color-background/
// https://getbootstrap.com/docs/5.3/utilities/colors/
// https://getbootstrap.com/docs/5.3/utilities/background/
/* ============================================================= */
$debug = false;
// $debug = true;

// ======================================================================== //
// Include necessary functions and files
// ======================================================================== //

require_once( 'includes/defaults.php' );
require_once( 'includes/functions.php' );
require_once( 'includes/actions-filters.php' );

$shortcodes = array(
  'accordion',
  'accordion-body',
  'accordion-button',
  'accordion-collapse',
  'accordion-header',
  'accordion-item',
  'alert',
  'badge',
  'breadcrumb',
  'breadcrumb-item',
  'button',
  'button-group',
  'button-toolbar',
  'callout',
  'card-header',
  'card-footer',
  'card-body',
  'card',
  'cards',
  'caret',
  'carousel',
  'carousel-item',
  'code',
  'collapse',
  'collapsibles',
  'column',
  'container',
  'container-fluid',
  'divider',
  'dropdown',
  'dropdown-header',
  'dropdown-item',
  'emphasis',
  'icon',
  'jumbotron',
  'label',
  'lead',
  'list-group',
  'list-group-item',
  'list-group-item-heading',
  'list-group-item-text',
  'modal',
  'modal-footer',
  'nav',
  'nav-item',
  'panel',
  'popover',
  'progress',
  'progress-bar',
  'row',
  'row-container',
  'span',
  'tab',
  'tabs',
  'tooltip',
  'well',
);


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
add_action( 'the_post', ['BoostrapShortcodes', 'bootstrap_shortcodes_popper_script'], 99 );


// Begin Shortcodes
class BoostrapShortcodes {
  
  public static $shortcodes = [];
  public static $cards = 'group';

  static function bootstrap_shortcodes_popper_script()  {
    global $post;
    if ( has_shortcode( $post->post_content, 'popover') || has_shortcode( $post->post_content, 'tooltip') ) {
      wp_enqueue_script( 'popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js' );
      // wp_enqueue_script( 'popper' );
    }
  }

  static function register_shortcodes() {
    wp_enqueue_style( 'bs-callout', plugins_url( 'includes/css/bs-callout.css' , __FILE__ ));
    // wp_enqueue_style( 'bs-callout' );

    global $shortcodes;
    
    // add all these shortcodes to WP:
    foreach ( $shortcodes as $shortcode ) {
      // print_r($shortcode);

      $function = str_replace( '-', '_', $shortcode );
      $function = str_replace( 'card-block', 'card-body', $function );  // retro-compat
      add_shortcode( $shortcode, ['BoostrapShortcodes', $function] );
      
    } // foreach

  } // register_shortcodes


/*--------------------------------------------------------------------------------------
  *
  * alert
  *
  *-------------------------------------------------------------------------------------*/
  static function alert( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "type"          => false,
        "dismissable"   => false,
        "xclass"        => false,
        "data"          => false
    ), $atts );
  
    $class  = 'alert';
    $class .= ( $atts['type'] )         ? ' alert-' . $atts['type'] : ' alert-success';
    $class .= ( $atts['dismissable']   == 'true' )  ? ' alert-dismissable' : '';
    $class .= ( $atts['xclass'] )       ? ' ' . $atts['xclass'] : '';
  
    $dismissable = ( $atts['dismissable'] ) ? '<button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>' : '';
  
    $data_props = self::parse_data_attributes( $atts['data'] );
    return sprintf(
      '<div class="%s"%s>%s%s</div>',
      esc_attr( trim($class) ),
      ( $data_props )  ? ' ' . $data_props : '',
      $dismissable,
      do_shortcode( $content )
    );
  }
  
  
  static function button( $atts, $content = null ) {

    $atts = shortcode_atts( array(
      "type"     => false,
      "size"     => false,
      "xclass"   => false,
      "block"    => false,
      "dropdown" => false,
      "link"     => '',
      "target"   => false,
      "disabled" => false,
      "active"   => false,
      "title"    => false,
      "data"     => false,
    ), $atts );

    $class  = 'btn';
    $class .= ( $atts['type'] )     ? ' btn-' . $atts['type'] : ' btn-primary';
    $class .= ( $atts['size'] )     ? ' btn-' . $atts['size'] : '';
    $class .= ( $atts['block'] == 'true' )    ? ' btn-block' : '';
    $class .= ( $atts['dropdown']   == 'true' ) ? ' dropdown-toggle' : '';
    $class .= ( $atts['disabled']   == 'true' ) ? ' disabled' : '';
    $class .= ( $atts['active']     == 'true' )   ? ' active' : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

    return sprintf(
      '<a href="%s" class="%s"%s%s%s>%s</a>',
      esc_url( $atts['link'] ),
      esc_attr( trim($class) ),
      ( $atts['target'] )     ? sprintf( ' target="%s"', esc_attr( $atts['target'] ) ) : '',
      ( $atts['title'] )      ? sprintf( ' title="%s"',  esc_attr( $atts['title'] ) )  : '',
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );

  }

    /*--------------------------------------------------------------------------------------
    *
    * button_group
    *
    *-------------------------------------------------------------------------------------*/
  static function button_group( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "size"      => false,
        "vertical"  => false,
        "justified" => false,
        "dropup"    => false,
        "xclass"    => false,
        "data"      => false
    ), $atts );

    $class  = 'btn-group';
    $class .= ( $atts['size'] )         ? ' btn-group-' . $atts['size'] : '';
    $class .= ( $atts['vertical']   == 'true' )     ? ' btn-group-vertical' : '';
    $class .= ( $atts['justified']  == 'true' )    ? ' btn-group-justified' : '';
    $class .= ( $atts['dropup']     == 'true' )       ? ' dropup' : '';
    $class .= ( $atts['xclass'] )       ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }


    /*--------------------------------------------------------------------------------------
    *
    * callout
    *
    *-------------------------------------------------------------------------------------*/
  static function callout( $atts, $content = null  ) {
    // print_r(' '.__FUNCTION__.' '.$atts['type']);
    // shortcode_atts https://developer.wordpress.org/reference/functions/shortcode_atts/
    $atts = shortcode_atts( array(
        "type"   => false,
        "size"   => false,
        "xclass" => false,
        "data"   => false,
    ), $atts );
    // print_r(var_export($atts,true));
    // array(4) { // passed stuff from the shortcodes
      // ["type"]=> string(7) "primary" 
      // ["size"]=> string(2) "xl" 
      // ["xclass"]=> bool(false) 
      // ["data"]=> bool(false)
    // } 

    // it looks like we cannot input the defaults directly in $atts = shortcode_atts()
    // because the class values need to be prepended by callout- or whatever function this is
    $class  = 'callout';
    $class .= ( $atts['type'] )     ? ' callout-' . $atts['type'] : '';
    $class .= ( $atts['size'] )     ? ' callout-' . $atts['size'] : ' callout-lg';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

/*--------------------------------------------------------------------------------------
  *
  * cards
  *
  * @author Eric Derewonko
  * https://getbootstrap.com/docs/5.3/components/card/#card-layout
  * type =    group grid masonry
  * grid:     simply add a row [+col wrapper] to eache card
  * masonry:  must enqueue script "https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
  * 
  * https://getbootstrap.com/docs/5.3/components/card/#masonry
  * In v4 we used a CSS-only technique to mimic the behavior of Masonry-like columns, 
  * but this technique came with lots of unpleasant side effects. If you want to have 
  * this type of layout in v5, you can just make use of Masonry plugin. Masonry is not included in Bootstrap
  * https://getbootstrap.com/docs/5.3/examples/masonry/
  * 
  * how do we add a column to the child, when the parent is card-grid (has .row)? we can't.
  * solution 1: https://wordpress.stackexchange.com/questions/4088/pass-variable-to-nested-shortcode - complex and stupid
  * solution 2: use $GLOBALS['variable']
  * '<div class="col"><div class="%s"%s>%s</div></div>',
  *-------------------------------------------------------------------------------------*/
  static function cards( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        "type"    => 'group',
        "cols"    => 2,
        "xclass"  => false,
        "data"    => false
    ), $atts );
  
    // this will be reset each time we start a new cards container
    $cardColOpen = $cardColClose = '';
    self::$cards = $atts['type'];
          if (self::$cards == 'group') {
      $class  = 'card-group';
    } elseif (self::$cards == 'grid') {
      $class  = 'row row-cols-1 row-cols-md-'.$atts['cols'];
    } elseif (self::$cards == 'masonry') {
      $class = 'masonry';
    }
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    // global $debug; $pre = ($debug) ? '<pre> '.var_export($atts,true).' </pre><br>' : '';
    global $debug; $pre = ($debug) ? '<pre> '.__FUNCTION__.' </pre><br>' : '';
    return sprintf($pre.
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
  /*--------------------------------------------------------------------------------------
  *
  * card
  * https://getbootstrap.com/docs/5.3/components/card/
  * equal height: add .h-100
  *
  * https://getbootstrap.com/docs/5.3/helpers/color-background/
  * https://getbootstrap.com/docs/5.3/utilities/colors/
  * https://getbootstrap.com/docs/5.3/utilities/background/
  *
  * type=primary secondary etc -> class=text-bg-*
  * 
  * how do we add a column to the child, when the parent is card-grid (has .row)? we can't.
  * solution 1: https://wordpress.stackexchange.com/questions/4088/pass-variable-to-nested-shortcode - complex and stupid
  * solution 2: use $GLOBALS['variable']
  * '<div class="col"><div class="%s"%s>%s</div></div>',
  *-------------------------------------------------------------------------------------*/
  static function card( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        "type"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'card';
    $class .= ( $atts['type'] )     ? ' text-bg-' . $atts['type'] : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
    $cardColOpen = $cardColClose = '';
    if (self::$cards == 'grid') {
      $cardColOpen  = '<div class="col">';
      $cardColClose = '</div>';
    }
  
    // global $debug; $pre = ($debug) ? '<pre> '.var_export($atts,true).' </pre><br>' : '';
    global $debug; $pre = ($debug) ? '<pre> '.__FUNCTION__.' </pre><br>' : '';

    return sprintf($pre.
      $cardColOpen.'<div class="%s"%s>%s</div>'.$cardColClose,
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }


  /*--------------------------------------------------------------------------------------
  *
  * card_header
  *
  * https://getbootstrap.com/docs/5.3/helpers/color-background/
  * https://getbootstrap.com/docs/5.3/utilities/colors/
  * https://getbootstrap.com/docs/5.3/utilities/background/
  *
  * type=primary secondary etc -> class=text-bg-*
  *-------------------------------------------------------------------------------------*/
  static function card_header( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        "type"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'card-header';
    $class .= ( $atts['type'] )     ? ' text-bg-' . $atts['type'] : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    // global $debug; $pre = ($debug) ? '<pre> '.var_export($atts,true).' </pre><br>' : '';
    global $debug; $pre = ($debug) ? '<pre> '.__FUNCTION__.' </pre><br>' : '';
    return sprintf($pre.
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }


  /*--------------------------------------------------------------------------------------
  *
  * card_body
  *
  * https://getbootstrap.com/docs/5.3/helpers/color-background/
  * https://getbootstrap.com/docs/5.3/utilities/colors/
  * https://getbootstrap.com/docs/5.3/utilities/background/
  *
  * type=primary secondary etc -> class=text-bg-*
  *-------------------------------------------------------------------------------------*/
  static function card_body( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        "type"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'card-body';
    $class .= ( $atts['type'] )     ? ' text-bg-' . $atts['type'] : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    // global $debug; $pre = ($debug) ? '<pre> '.var_export($atts,true).' </pre><br>' : '';
    global $debug; $pre = ($debug) ? '<pre> '.__FUNCTION__.' </pre><br>' : '';
    return sprintf($pre.
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * card_footer
  *
  * https://getbootstrap.com/docs/5.3/helpers/color-background/
  * https://getbootstrap.com/docs/5.3/utilities/colors/
  * https://getbootstrap.com/docs/5.3/utilities/background/
  *
  * type=primary secondary etc -> class=text-bg-*
  *
  *-------------------------------------------------------------------------------------*/
  static function card_footer( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        "type"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'card-footer';
    $class .= ( $atts['type'] )     ? ' text-bg-' . $atts['type'] : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    // global $debug; $pre = ($debug) ? '<pre> '.var_export($atts,true).' </pre><br>' : '';
    global $debug; $pre = ($debug) ? '<pre> '.__FUNCTION__.' </pre><br>' : '';
    return sprintf($pre.
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }


    
  /*--------------------------------------------------------------------------------------
  *
  * column
  *
  * @author Simon Yeldon
  * @since 1.0
  * @todo pull and offset
  *-------------------------------------------------------------------------------------*/
  static function column( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "lg"          => false,
        "md"          => false,
        "sm"          => false,
        "xs"          => false,
        "offset_lg"   => false,
        "offset_md"   => false,
        "offset_sm"   => false,
        "offset_xs"   => false,
        "pull_lg"     => false,
        "pull_md"     => false,
        "pull_sm"     => false,
        "pull_xs"     => false,
        "push_lg"     => false,
        "push_md"     => false,
        "push_sm"     => false,
        "push_xs"     => false,
        "xclass"      => false,
        "data"        => false
    ), $atts );

    $class  = '';
    $class .= ( $atts['lg'] )			                                ? ' col-lg-' . $atts['lg'] : '';
    $class .= ( $atts['md'] )                                           ? ' col-md-' . $atts['md'] : '';
    $class .= ( $atts['sm'] )                                           ? ' col-sm-' . $atts['sm'] : '';
    $class .= ( $atts['xs'] )                                           ? ' col-xs-' . $atts['xs'] : '';
    $class .= ( $atts['offset_lg'] || $atts['offset_lg'] === "0" )      ? ' col-lg-offset-' . $atts['offset_lg'] : '';
    $class .= ( $atts['offset_md'] || $atts['offset_md'] === "0" )      ? ' col-md-offset-' . $atts['offset_md'] : '';
    $class .= ( $atts['offset_sm'] || $atts['offset_sm'] === "0" )      ? ' col-sm-offset-' . $atts['offset_sm'] : '';
    $class .= ( $atts['offset_xs'] || $atts['offset_xs'] === "0" )      ? ' col-xs-offset-' . $atts['offset_xs'] : '';
    $class .= ( $atts['pull_lg']   || $atts['pull_lg'] === "0" )        ? ' col-lg-pull-' . $atts['pull_lg'] : '';
    $class .= ( $atts['pull_md']   || $atts['pull_md'] === "0" )        ? ' col-md-pull-' . $atts['pull_md'] : '';
    $class .= ( $atts['pull_sm']   || $atts['pull_sm'] === "0" )        ? ' col-sm-pull-' . $atts['pull_sm'] : '';
    $class .= ( $atts['pull_xs']   || $atts['pull_xs'] === "0" )        ? ' col-xs-pull-' . $atts['pull_xs'] : '';
    $class .= ( $atts['push_lg']   || $atts['push_lg'] === "0" )        ? ' col-lg-push-' . $atts['push_lg'] : '';
    $class .= ( $atts['push_md']   || $atts['push_md'] === "0" )        ? ' col-md-push-' . $atts['push_md'] : '';
    $class .= ( $atts['push_sm']   || $atts['push_sm'] === "0" )        ? ' col-sm-push-' . $atts['push_sm'] : '';
    $class .= ( $atts['push_xs']   || $atts['push_xs'] === "0" )        ? ' col-xs-push-' . $atts['push_xs'] : '';
    $class .= ( $atts['xclass'] )                                       ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

/*--------------------------------------------------------------------------------------
  *
  * container
  *
  *-------------------------------------------------------------------------------------*/
  static function container( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "fluid"  => false,
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = ( $atts['fluid']   == 'true' )  ? 'container-fluid' : 'container';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
  
  /*--------------------------------------------------------------------------------------
  *
  * dropdown_divider
  * used in button
  *-------------------------------------------------------------------------------------*/
  static function divider( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data" => false
    ), $atts );

    $class  = 'divider';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<li class="%s"%s>%s</li>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

/*--------------------------------------------------------------------------------------
  *
  * dropdown_item
  * used in button
  *-------------------------------------------------------------------------------------*/
  static function dropdown_item( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "link"        => false,
        "disabled"    => false,
        "xclass"      => false,
        "data"        => false
    ), $atts );
  
    $li_class  = '';
    $li_class .= ( $atts['disabled']  == 'true' ) ? ' disabled' : '';
  
    $a_class  = '';
    $a_class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<li role="presentation" class="%s"><a role="menuitem" href="%s" class="%s"%s>%s</a></li>',
      esc_attr( $li_class ),
      esc_url( $atts['link'] ),
      esc_attr( $a_class ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * dropdown
  * used in button
  *
  *-------------------------------------------------------------------------------------*/
  static function dropdown( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'dropdown-menu';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<ul role="menu" class="%s"%s>%s</ul>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * jumbotron
  * 
  *
  *-------------------------------------------------------------------------------------*/
  static function jumbotron( $atts, $content = null ) {

    $atts = shortcode_atts( array(
          "title"  => false,
          "xclass" => false,
          "data"   => false
    ), $atts );
  
    $class  = 'jumbotron';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<div class="%s"%s>%s%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      ( $atts['title'] ) ? '<h1>' . esc_html( $atts['title'] ) . '</h1>' : '',
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * list_group_item_heading
  *
  *
  *-------------------------------------------------------------------------------------*/
  static function list_group_item_heading( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'list-group-item-heading';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<h4 class="%s"%s>%s</h4>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * list_group_item_text
  *
  *
  *-------------------------------------------------------------------------------------*/
  static function list_group_item_text( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'list-group-item-text';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<p class="%s"%s>%s</p>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * list_group_item
  *
  * @author M. W. Delaney
  *
  *-------------------------------------------------------------------------------------*/
  static function list_group_item( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "link"    => false,
        "type"    => false,
        "active"  => false,
        "target"   => false,
        "xclass"  => false,
        "data"    => false
    ), $atts );
  
    $class  = 'list-group-item';
    $class .= ( $atts['type'] )     ? ' list-group-item-' . $atts['type'] : '';
    $class .= ( $atts['active']   == 'true' )   ? ' active' : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<%1$s %2$s %3$s class="%4$s"%5$s>%6$s</%1$s>',
      ( $atts['link'] )     ? 'a' : 'li',
      ( $atts['link'] )     ? 'href="' . esc_url( $atts['link'] ) . '"' : '',
      ( $atts['target'] )   ? sprintf( ' target="%s"', esc_attr( $atts['target'] ) ) : '',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * list_group
  *
  * @author M. W. Delaney
  *
  *-------------------------------------------------------------------------------------*/
  static function list_group( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "linked" => false,
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'list-group';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<%1$s class="%2$s"%3$s>%4$s</%1$s>',
      ( $atts['linked'] == 'true' ) ? 'div' : 'ul',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * modal_footer
  *
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function modal_footer( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false,
    ), $atts );
  
    $class  = 'modal-footer';
    $class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '</div><div class="%s"%s>%s',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * modal
  *
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function modal( $atts, $content = null ) {

    if( isset($GLOBALS['modal_count']) )
      $GLOBALS['modal_count']++;
    else
      $GLOBALS['modal_count'] = 0;
  
    $atts = shortcode_atts( array(
        "text"    => false,
        "title"   => false,
        "size"    => false,
        "xclass"  => false,
        "data"    => false
    ), $atts );
  
    $a_class  = '';
    $a_class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
    $div_class  = 'modal fade';
    $div_class .= ( $atts['size'] ) ? ' bs-modal-' . $atts['size'] : '';
  
    $div_size = ( $atts['size'] ) ? ' modal-' . $atts['size'] : '';
  
    $id = 'custom-modal-' . $GLOBALS['modal_count'];
  
  
    $modal_output = sprintf(
        '<div class="%1$s" id="%2$s" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog %3$s">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                        %4$s
                    </div>
                    <div class="modal-body">
                        %5$s
                    </div>
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->
        </div> <!-- /.modal -->
        ',
      esc_attr( $div_class ),
      esc_attr( $id ),
      esc_attr( $div_size ),
      ( $atts['title'] ) ? '<h4 class="modal-title">' . $atts['title'] . '</h4>' : '',
      do_shortcode( $content )
    );
  
    add_action('wp_footer', function() use ($modal_output) {
        echo $modal_output;
    }, 100,0);
  
    return sprintf(
      '<a data-bs-toggle="modal" href="#%1$s" class="%2$s"%3$s>%4$s</a>',
      esc_attr( $id ),
      esc_attr( $a_class ),
      self::parse_data_attributes( $atts['data'] ),
      esc_html( $atts['text'] )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * row_container
  * for rows inside a column, fix a bug where the row would close too early
  * not sure about this one
  *-------------------------------------------------------------------------------------*/
  static function row_container( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'row';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
  /*--------------------------------------------------------------------------------------
  *
  * row
  *
  *
  *-------------------------------------------------------------------------------------*/
  static function row( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );
  
    $class  = 'row';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
  
    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }
  
/*--------------------------------------------------------------------------------------
  *
  * tab
  *
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function tab( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        'title'   => false,
        'active'  => false,
        'fade'    => false,
        'xclass'  => false,
        'data'    => false,
        'link'    => false
    ), $atts );
  
    if( $GLOBALS['tabs_default_active'] && $GLOBALS['tabs_default_count'] == 0 ) {
        $atts['active'] = true;
    }
    $GLOBALS['tabs_default_count']++;
  
    $class  = 'tab-pane';
    $class .= ( $atts['fade']   == 'true' )                            ? ' fade' : '';
    $class .= ( $atts['active'] == 'true' )                            ? ' active' : '';
    $class .= ( $atts['active'] == 'true' && $atts['fade'] == 'true' ) ? ' in' : '';
    $class .= ( $atts['xclass'] )                                      ? ' ' . $atts['xclass'] : '';
  
  
    if(!isset($atts['link']) || $atts['link'] == NULL) {
      $id = 'custom-tab-' . $GLOBALS['tabs_count'] . '-' . md5( $atts['title'] );
    } else {
      $id = $atts['link'];
    }
  
    return sprintf(
      '<div id="%s" class="%s"%s>%s</div>',
      sanitize_html_class($id),
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  
  }
  
/*--------------------------------------------------------------------------------------
  *
  * tabs
  *
  * @author Eric Derewonko
  * @since 1.0
  * Modified by TwItCh twitch@designweapon.com
  * Now acts a whole nav/tab/pill shortcode solution!
  *-------------------------------------------------------------------------------------*/
  static function tabs( $atts, $content = null ) {

    if( isset( $GLOBALS['tabs_count'] ) )
      $GLOBALS['tabs_count']++;
    else
      $GLOBALS['tabs_count'] = 0;
  
    $GLOBALS['tabs_default_count'] = 0;
  
    $atts = apply_filters('bs_tabs_atts',$atts);
  
    $atts = shortcode_atts( array(
        "type"    => false,
        "xclass"  => false,
        "data"    => false,
        "name"    => false,
    ), $atts );
  
    $ul_class  = 'nav';
    $ul_class .= ( $atts['type'] )     ? ' nav-' . $atts['type'] : ' nav-tabs';
    $ul_class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
  
    $div_class = 'tab-content';
  
    // If user defines name of group, use that for ID for tab history purposes
    if(isset($atts['name'])) {
      $id = $atts['name'];
    } else {
      $id = 'custom-tabs-' . $GLOBALS['tabs_count'];
    }
  
  
  
    $atts_map = bs_attribute_map( $content );
  
    // Extract the tab titles for use in the tab widget.
    if ( $atts_map ) {
      $tabs = array();
      $GLOBALS['tabs_default_active'] = true;
      foreach( $atts_map as $check ) {
          if( !empty($check["tab"]["active"]) ) {
              $GLOBALS['tabs_default_active'] = false;
          }
      }
      $i = 0;
      foreach( $atts_map as $tab ) {
  
        $class  ='';
        $class .= ( !empty($tab["tab"]["active"]) || ($GLOBALS['tabs_default_active'] && $i == 0) ) ? 'active' : '';
        $class .= ( !empty($tab["tab"]["xclass"]) ) ? ' ' . esc_attr($tab["tab"]["xclass"]) : '';
  
        if(!isset($tab["tab"]["link"])) {
          $tab_id = 'custom-tab-' . $GLOBALS['tabs_count'] . '-' . md5( $tab["tab"]["title"] );
        } else {
          $tab_id = $tab["tab"]["link"];
        }
  
        $tabs[] = sprintf(
          '<li%s><a href="#%s" data-bs-toggle="tab" >%s</a></li>',
          ( !empty($class) ) ? ' class="' . $class . '"' : '',
          sanitize_html_class($tab_id),
          $tab["tab"]["title"]
        );
        $i++;
      }
    }
    $output = sprintf(
      '<ul class="%s" id="%s"%s>%s</ul><div class="%s">%s</div>',
      esc_attr( $ul_class ),
      sanitize_html_class( $id ),
      self::parse_data_attributes( $atts['data'] ),
      ( $tabs )  ? implode( $tabs ) : '',
      sanitize_html_class( $div_class ),
      do_shortcode( $content )
    );
  
    return apply_filters('bs_tabs', $output);
  }
  
                             
  ///////////////////////////////////////////////////////
  // below are all the deprecated functions to be removed
  //////////////////////////////////////////////////////
  
  /*--------------------------------------------------------------------------------------
  *
  * button_toolbar
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function button_toolbar( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'btn-toolbar';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * caret present in nav, dropdown
  * deprecated, will be integrated in button/dropdown
  * will stay here andjust  return null
  *-------------------------------------------------------------------------------------*/
  static function caret( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'caret';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<span class="%s"%s>%s</span>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * dropdown_header
  *
  * @author M. W. Delaney
  *
  *-------------------------------------------------------------------------------------*/
  static function dropdown_header( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'dropdown-header';
    $class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<li class="%s"%s>%s</li>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * nav
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function nav( $atts, $content = null ) {

    $atts = shortcode_atts( array(
          "type"      => false,
          "stacked"   => false,
          "justified" => false,
          "xclass"    => false,
          "data"      => false
    ), $atts );

    $class  = 'nav';
    $class .= ( $atts['type'] )         ? ' nav-' . $atts['type'] : ' nav-tabs';
    $class .= ( $atts['stacked']   == 'true' )      ? ' nav-stacked' : '';
    $class .= ( $atts['justified'] == 'true' )    ? ' nav-justified' : '';
    $class .= ( $atts['xclass'] )       ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<ul class="%s"%s>%s</ul>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * nav_item
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function nav_item( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "link"     => false,
        "active"   => false,
        "disabled" => false,
        "dropdown" => false,
        "xclass"   => false,
        "data"     => false,
    ), $atts );

    $li_classes  = '';
    $li_classes .= ( $atts['dropdown'] ) ? 'dropdown' : '';
    $li_classes .= ( $atts['active']   == 'true' )   ? ' active' : '';
    $li_classes .= ( $atts['disabled'] == 'true' ) ? ' disabled' : '';

    $a_classes  = '';
    $a_classes .= ( $atts['dropdown']   == 'true' ) ? ' dropdown-toggle' : '';
    $a_classes .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    # Wrong idea I guess ....
    #$pattern = ( $dropdown ) ? '<li%1$s><a href="%2$s"%3$s%4$s%5$s></a>%6$s</li>' : '<li%1$s><a href="%2$s"%3$s%4$s%5$s>%6$s</a></li>';

    //* If we have a dropdown shortcode inside the content we end the link before the dropdown shortcode, else all content goes inside the link
    $content = ( $atts['dropdown'] ) ? str_replace( '[dropdown]', '</a>[dropdown]', $content ) : $content . '</a>';

    return sprintf(
      '<li%1$s><a href="%2$s"%3$s%4$s%5$s>%6$s</li>',
      ( ! empty( $li_classes ) ) ? sprintf( ' class="%s"', esc_attr( $li_classes ) ) : '',
      esc_url( $atts['link'] ),
      ( ! empty( $a_classes ) )  ? sprintf( ' class="%s"', esc_attr( $a_classes ) )  : '',
      ( $atts['dropdown'] )   ? ' data-bs-toggle="dropdown"' : '',
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );

  }

  /*--------------------------------------------------------------------------------------
  *
  * progress
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function progress( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "striped"   => false,
        "animated"  => false,
        "xclass"    => false,
        "data"      => false
    ), $atts );

    $class  = 'progress';
    $class .= ( $atts['striped']  == 'true' )  ? ' progress-striped' : '';
    $class .= ( $atts['animated']  == 'true' ) ? ' active' : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      ( $data_props )  ? ' ' . $data_props : '',
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * progress_bar
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function progress_bar( $atts, $content = null ) {

    $atts = shortcode_atts( array(
          "type"      => false,
          "percent"   => false,
          "label"     => false,
          "xclass"    => false,
          "data"      => false
    ), $atts );

    $class  = 'progress-bar';
    $class .= ( $atts['type'] )   ? ' progress-bar-' . $atts['type'] : '';
    $class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s" role="progressbar" %s%s>%s</div>',
      esc_attr( trim($class) ),
      ( $atts['percent'] )      ? ' aria-value="' . (int) $atts['percent'] . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . (int) $atts['percent'] . '%;"' : '',
      ( $data_props )   ? ' ' . $data_props : '',
      ( $atts['percent'] )      ? sprintf('<span%s>%s</span>', ( !$atts['label'] ) ? ' class="sr-only"' : '', (int) $atts['percent'] . '% Complete') : ''
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * code
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function code( $atts, $content = null ) {

    $atts = shortcode_atts( array(
          "inline"      => false,
          "scrollable"  => false,
          "xclass"      => false,
          "data"        => false
    ), $atts );

    $class  = '';
    $class .= ( $atts['scrollable']   == 'true' )  ? ' pre-scrollable' : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<%1$s class="%2$s"%3$s>%4$s</%1$s>',
      ( $atts['inline'] ) ? 'code' : 'pre',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * breadcrumb
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function breadcrumb( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'breadcrumb';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<ol class="%s"%s>%s</ol>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * breadcrumb_item
  * deprecated
  * @author M. W. Delaney
  *
  *-------------------------------------------------------------------------------------*/
  static function breadcrumb_item( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "link" => false,
        "xclass" => false,
        "data" => false
    ), $atts );

    $class  = '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<li><a href="%s" class="%s"%s>%s</a></li>',
      esc_url( $atts['link'] ),
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * label
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function label( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "type"      => false,
        "xclass"    => false,
        "data"      => false
    ), $atts );

    $class  = 'label';
    $class .= ( $atts['type'] )     ? ' label-' . $atts['type'] : ' label-primary';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<span class="%s"%s>%s</span>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * badge
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function badge( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "right"   => false,
        "xclass"  => false,
        "data"    => false
    ), $atts );

    $class  = 'badge';
    $class .= ( $atts['right']   == 'true' )    ? ' pull-right' : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<span class="%s"%s>%s</span>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * icon
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function icon( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "type"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'glyphicon';
    $class .= ( $atts['type'] )     ? ' glyphicon-' . $atts['type'] : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<span class="%s"%s>%s</span>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * well
  * deprecated
  * @since 1.0
  *
  * Options:
  *   size: sm = small, lg = large
  *
  *-------------------------------------------------------------------------------------*/
  static function well( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "size"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'well';
    $class .= ( $atts['size'] )     ? ' well-' . $atts['size'] : '';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }




  /*--------------------------------------------------------------------------------------
  *
  * collapsibles
  *
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function collapsibles( $atts, $content = null ) {

    if( isset($GLOBALS['collapsibles_count']) )
      $GLOBALS['collapsibles_count']++;
    else
      $GLOBALS['collapsibles_count'] = 0;

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class = 'panel-group';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

    $id = 'custom-collapse-'. $GLOBALS['collapsibles_count'];


    return sprintf(
      '<div class="%s" id="%s"%s>%s</div>',
        esc_attr( trim($class) ),
        esc_attr($id),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );

  }


  /*--------------------------------------------------------------------------------------
  *
  * collapse
  *
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function collapse( $atts, $content = null ) {

    if( isset($GLOBALS['single_collapse_count']) )
      $GLOBALS['single_collapse_count']++;
    else
      $GLOBALS['single_collapse_count'] = 0;

    $atts = shortcode_atts( array(
        "title"   => false,
        "type"    => false,
        "active"  => false,
        "xclass"  => false,
        "data"    => false
    ), $atts );

    $panel_class = 'panel';
    $panel_class .= ( $atts['type'] )     ? ' panel-' . $atts['type'] : ' panel-primary';
    $panel_class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

    $collapse_class = 'panel-collapse';
    $collapse_class .= ( $atts['active'] == 'true' )  ? ' in' : ' collapse';

    $a_class = '';
    $a_class .= ( $atts['active'] == 'true' )  ? '' : 'collapsed';

    $parent = isset( $GLOBALS['collapsibles_count'] ) ? 'custom-collapse-' . $GLOBALS['collapsibles_count'] : 'single-collapse';
    $current_collapse = $parent . '-' . $GLOBALS['single_collapse_count'];

    $data_props = self::parse_data_attributes( $atts['data'] );
    return sprintf(
      '<div class="%1$s"%2$s>
        <div class="panel-heading">
          <h4 class="panel-title">
            <a class="%3$s" data-bs-toggle="collapse"%4$s href="#%5$s">%6$s</a>
          </h4>
        </div>
        <div id="%5$s" class="%7$s">
          <div class="panel-body">%8$s</div>
        </div>
      </div>',
      esc_attr( $panel_class ),
      ( $data_props )   ? ' ' . $data_props : '',
      $a_class,
      ( $parent )       ? ' data-bs-parent="#' . $parent . '"' : '',
      $current_collapse,
      $atts['title'],
      esc_attr( $collapse_class ),
      do_shortcode( $content )
    );
  }


  /*--------------------------------------------------------------------------------------
  *
  * carousel
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function carousel( $atts, $content = null ) {

    if( isset($GLOBALS['carousel_count']) )
      $GLOBALS['carousel_count']++;
    else
      $GLOBALS['carousel_count'] = 0;

    $GLOBALS['carousel_default_count'] = 0;

    $atts = shortcode_atts( array(
        "interval" => false,
        "pause"    => false,
        "wrap"     => false,
        "xclass"   => false,
        "data"     => false,
    ), $atts );

    $div_class  = 'carousel slide';
    $div_class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';

    $inner_class = 'carousel-inner';

    $id = 'custom-carousel-'. $GLOBALS['carousel_count'];


    $atts_map = bs_attribute_map( $content );

    // Extract the slide titles for use in the carousel widget.
    if ( $atts_map ) {
      $indicators = array();
      $GLOBALS['carousel_default_active'] = true;
      foreach( $atts_map as $check ) {
        if( !empty($check["carousel-item"]["active"]) ) {
          $GLOBALS['carousel_default_active'] = false;
        }
      }
      $i = 0;
      foreach( $atts_map as $slide ) {
        $indicators[] = sprintf(
          '<li class="%s" data-bs-target="%s" data-bs-slide-to="%s"></li>',
          ( !empty($slide["carousel-item"]["active"]) || ($GLOBALS['carousel_default_active'] && $i == 0) ) ? 'active' : '',
          esc_attr( '#' . $id ),
          esc_attr( $i )
        );
        $i++;
      }
    }
    return sprintf(
      '<div class="%s" id="%s" data-bs-ride="carousel"%s%s%s%s>%s<div class="%s">%s</div>%s%s</div>',
      esc_attr( $div_class ),
      esc_attr( $id ),
      ( $atts['interval'] )   ? sprintf( ' data-bs-interval="%d"', $atts['interval'] ) : '',
      ( $atts['pause'] )      ? sprintf( ' data-bs-pause="%s"', esc_attr( $atts['pause'] ) ) : '',
      ( $atts['wrap'] == 'true' )       ? sprintf( ' data-bs-wrap="%s"', esc_attr( $atts['wrap'] ) ) : '',
      self::parse_data_attributes( $atts['data'] ),
      ( $indicators ) ? '<ol class="carousel-indicators">' . implode( $indicators ) . '</ol>' : '',
      esc_attr( $inner_class ),
      do_shortcode( $content ),
      '<a class="left carousel-control"  href="' . esc_url( '#' . $id ) . '" data-bs-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>',
      '<a class="right carousel-control" href="' . esc_url( '#' . $id ) . '" data-bs-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>'
    );
  }


  /*--------------------------------------------------------------------------------------
  *
  * carousel_item
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/
  static function carousel_item( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "active"  => false,
        "caption" => false,
        "xclass"  => false,
        "data"    => false
    ), $atts );

    if( $GLOBALS['carousel_default_active'] && $GLOBALS['carousel_default_count'] == 0 ) {
        $atts['active'] = true;
    }
    $GLOBALS['carousel_default_count']++;

    $class  = 'item';
    $class .= ( $atts['active']   == 'true' ) ? ' active' : '';
    $class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';


    //$content = preg_replace('/class=".*?"/', '', $content);
    $content = preg_replace('/alignnone/', '', $content);
    $content = preg_replace('/alignright/', '', $content);
    $content = preg_replace('/alignleft/', '', $content);
    $content = preg_replace('/aligncenter/', '', $content);

    return sprintf(
      '<div class="%s"%s>%s%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content ),
      ( $atts['caption'] ) ? '<div class="carousel-caption">' . esc_html( $atts['caption'] ) . '</div>' : ''
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * tooltip
  * deprecated
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/


  static function tooltip( $atts, $content = null ) {

    $atts = shortcode_atts( array(
       'title'     => '',
       'placement' => 'top',
       'animation' => 'true',
       'html'      => 'false',
       'data'      => ''
    ), $atts );

    $class  = 'bs-tooltip';

    $atts['data']   .= ( $atts['animation'] ) ? self::check_for_data($atts['data']) . 'animation,' . $atts['animation'] : '';
    $atts['data']   .= ( $atts['placement'] ) ? self::check_for_data($atts['data']) . 'placement,' . $atts['placement'] : '';
    $atts['data']   .= ( $atts['html'] )      ? self::check_for_data($atts['data']) . 'html,'      .$atts['html']      : '';

    $return = '';
    $tag = 'span';
    $content = do_shortcode($content);
    $return .= self::get_dom_element($tag, $content, $class, $atts['title'], $atts['data']);
    return $return;

  }

  /*--------------------------------------------------------------------------------------
  *
  * popover
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/

  static function popover( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        'title'     => false,
        'text'      => '',
        'placement' => 'top',
        'animation' => 'true',
        'html'      => 'false',
        'data'      => ''
    ), $atts );

    $class = 'bs-popover';

    $atts['data']   .= self::check_for_data($atts['data']) . 'toggle,popover';
    $atts['data']   .= self::check_for_data($atts['data']) . 'content,' . str_replace(',', '&#44;', $atts['text']);
    $atts['data']   .= ( $atts['animation'] ) ? self::check_for_data($atts['data']) . 'animation,' . $atts['animation'] : '';
    $atts['data']   .= ( $atts['placement'] ) ? self::check_for_data($atts['data']) . 'placement,' . $atts['placement'] : '';
    $atts['data']   .= ( $atts['html'] )      ? self::check_for_data($atts['data']) . 'html,'      . $atts['html']      : '';

    $return = '';
    $tag = 'span';
    $content = do_shortcode($content);
    $return .= self::get_dom_element($tag, $content, $class, $atts['title'], $atts['data']);
    return html_entity_decode($return);

  }


  /*--------------------------------------------------------------------------------------
  *
  * media
  * deprecated
  * @author
  * @since 1.0
  *
  *-------------------------------------------------------------------------------------*/

  static function media( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'media';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass']: '';


    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }


  static function media_body( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "title"  => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $div_class  = 'media-body';
    $div_class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

    $h4_class  = 'media-heading';
    $h4_class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<div class="%s"%s><h4 class="%s">%s</h4>%s</div>',
      esc_attr( $div_class ),
      self::parse_data_attributes( $atts['data'] ),
      esc_attr( $h4_class ),
      esc_html(  $atts['title']),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * lead
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function lead( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = 'lead';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<p class="%s"%s>%s</p>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
  *
  * emphasis
  * deprecated
  *
  *-------------------------------------------------------------------------------------*/
  static function emphasis( $atts, $content = null ) {

    $atts = shortcode_atts( array(
        "type"   => false,
        "xclass" => false,
        "data"   => false
    ), $atts );

    $class  = '';
    $class .= ( $atts['type'] )   ? 'text-' . $atts['type'] : 'text-muted';
    $class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';


    return sprintf(
      '<span class="%s"%s>%s</span>',
      esc_attr( trim($class) ),
      self::parse_data_attributes( $atts['data'] ),
      do_shortcode( $content )
    );
  }


  /*
  * Parse data-attributes for shortcodes
  * 
  *-------------------------------------------------------------------------------------*/
  static function parse_data_attributes( $data ) {

    $data_props = ' ';

    if( $data ) {
      $data = explode( '|', $data );

      foreach( $data as $d ) {
        $d = explode( ',', $d );
        // scavenger bs 5.3 warning: verify if that breaks anything
        $data_props .= sprintf( 'data-bs-%s="%s" ', esc_html( $d[0] ), esc_attr( trim( $d[1] ) ) );
      }
    }
    return $data_props;
  }

  /*--------------------------------------------------------------------------------------
  *
  * get DOMDocument element and apply shortcode parameters to it. Create the element if it doesn't exist
  *
  *-------------------------------------------------------------------------------------*/
  static function get_dom_element( $tag, $content, $class, $title = '', $data = null ) {

    //clean up content
    $content = trim(trim($content), chr(0xC2).chr(0xA0));
    $previous_value = libxml_use_internal_errors(TRUE);

    $dom = new DOMDocument;
    $dom->loadXML(utf8_encode($content));

    libxml_clear_errors();
    libxml_use_internal_errors($previous_value);

    if(!$dom->documentElement) {
        $element = $dom->createElement($tag, utf8_encode($content));
        $dom->appendChild($element);
    }

    $dom->documentElement->setAttribute('class', $dom->documentElement->getAttribute('class') . ' ' . esc_attr( utf8_encode($class) ));
    if( $title ) {
        $dom->documentElement->setAttribute('title', $title );
    }
    if( $data ) {
        $data = explode( '|', $data );
        foreach( $data as $d ):
        $d = explode(',',$d);
        // scavenger bs 5.3 warning: make sure nothing breaks
        $dom->documentElement->setAttribute('data-bs-'.$d[0],trim($d[1]));
        endforeach;
    }
    return utf8_decode( $dom->saveXML($dom->documentElement) );
  }

  /*--------------------------------------------------------------------------------------
  *
  * Scrape the shortcode's contents for a particular DOMDocument tag or tags, 
  * pull them out, apply attributes, and return just the tags.
  * Deprecated and unused
  *-------------------------------------------------------------------------------------*/
  static function scrape_dom_element( $tag, $content, $class, $title = '', $data = null ) {

    $previous_value = libxml_use_internal_errors(TRUE);

    $dom = new DOMDocument;
    $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

    libxml_clear_errors();
    libxml_use_internal_errors($previous_value);
    foreach ($tag as $find) {
      $tags = $dom->getElementsByTagName($find);
      foreach ($tags as $find_tag) {
          $outputdom = new DOMDocument;
          $new_root = $outputdom->importNode($find_tag, true);
          $outputdom->appendChild($new_root);

          if(is_object($outputdom->documentElement)) {
            $outputdom->documentElement->setAttribute('class', $outputdom->documentElement->getAttribute('class') . ' ' . esc_attr( $class ));
            if( $title ) {
                $outputdom->documentElement->setAttribute('title', $title );
            }
            if( $data ) {
                $data = explode( '|', $data );
                foreach( $data as $d ):
                  $d = explode(',',$d);
                  // scavenger bs 5.3 warning: make sure nothing breaks
                  $outputdom->documentElement->setAttribute('data-bs-'.$d[0],trim($d[1]));
                endforeach;
            }
          }
          return $outputdom->saveHTML($outputdom->documentElement);

      }
    }
  }

  /*--------------------------------------------------------------------------------------
  *
  * Find if content contains a particular tag, if not, create it, either way wrap it in a wrapper tag
  *
  *       Example: Check if the contents of [page-header] include an h1, 
  *                if not, add one, then wrap it all in a div so we can add classes to that.
  * Deprecated, unused
  *
  *-------------------------------------------------------------------------------------*/
  static function nest_dom_element($find, $append, $content) {

    $previous_value = libxml_use_internal_errors(TRUE);

    $dom = new DOMDocument;
    $dom->loadXML(utf8_encode($content));

    libxml_clear_errors();
    libxml_use_internal_errors($previous_value);

    //Does $content include the tag we're looking for?
    $hasFind = $dom->getElementsByTagName($find);

    //If not, add it and wrap it all in our append tag
    if( $hasFind->length == 0 ) {
        $wrapper = $dom->createElement($append);
        $dom->appendChild($wrapper);

        $tag = $dom->createElement($find, $content);
        $wrapper->appendChild($tag);
    }

    //If so, just wrap everything in our append tag
    else {
        $new_root = $dom->createElement($append);
        $new_root->appendChild($dom->documentElement);
        $dom->appendChild($new_root);
    }
    return $dom->saveXML($dom->documentElement);
  }

  /*--------------------------------------------------------------------------------------
  *
  * Add dividers to data attributes content if needed
  *
  *-------------------------------------------------------------------------------------*/
  static function check_for_data( $data ) {
    if( $data ) {
      return "|";
    }
  }

  /*--------------------------------------------------------------------------------------
  *
  * If the user puts a return between the shortcode and its contents, sometimes we want to strip the resulting P tags out
  *
  *-------------------------------------------------------------------------------------*/
  static function strip_paragraph( $content ) {
      $content = str_ireplace( '<p>','',$content );
      $content = str_ireplace( '</p>','',$content );
      return $content;
  }

} //BoostrapShortcodes

new BoostrapShortcodes();  // seems unnecessary
