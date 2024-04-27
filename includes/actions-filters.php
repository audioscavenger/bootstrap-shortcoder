<?php
  
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
// Function and filter to remove extra line breaks around shortcodes
// ======================================================================== // 

    function bs_fix_shortcodes($content){   
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']',
            ']<br>' => ']'
        );

        $content = strtr($content, $array);
        return $content;
    }

    add_filter('the_content', 'bs_fix_shortcodes');

// ======================================================================== // 



// ======================================================================== //		
// Button creation and styles for the documentation popup button
// ======================================================================== // 
// scavenger: here we will start experimenting with BS 5.3
// ======================================================================== // 

    //Function to register and enqueue the documentation stylesheets
    function bootstrap_shortcodes_help_styles() {
        // https://getbootstrap.com/docs/5.3/getting-started/download/#cdn-via-jsdelivr
        // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
        // https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js        // shall be loaded conditionally
        // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js
        // https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js     // +popper

        wp_register_style( 'bootstrap53-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );
        wp_register_style( 'bs-callout', dirname(__FILE__).'/css/bs-callout.css' );

        wp_enqueue_style( 'bootstrap53-css' );
        wp_enqueue_style( 'bs-callout' );

        wp_register_script( 'popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js' );
        wp_register_script( 'bootstrap53-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js' );
        wp_register_script( 'bootstrap53-js-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' );

        wp_enqueue_script( 'popper' );                   // front is conditionally loaded by bootstrap_shortcodes_popper_script
        wp_enqueue_script( 'bootstrap53-js' );

        // bugfix: Visual Composer causes problems
        $handle = 'vc_bootstrap_js';
        $list = 'enqueued';
        if (wp_script_is( $handle, $list )) {
            wp_dequeue_script( $handle );
        }
    }

    //Function create the documentation popup button
    function add_bootstrap_button() {
        //the id of the container I want to show in the popup
        $popup_id = 'bootstrap-shortcoder-help';

        //our popup's title
        $title = 'Bootstrap Shortcodes Help';

        //append the icon
        printf(
        '<a data-bs-toggle="modal" data-bs-target="#bootstrap-shortcoder-help" title="%2$s" href="%3$s" class="%4$s"><span class="bs_bootstrap-logo wp-media-buttons-icon"></span></a>',
        esc_attr( $popup_id ),
        esc_attr( $title ),
        esc_url( '#' ),
        esc_attr( 'button add_media bootstrap-shortcoder-button')
        //sprintf( '<img src="%s" style="height: 20px; position: relative; top: -2px;">', esc_url( $img ) )
        );
    }

    // add the button to the content editor, next to the media button on any admin page in the array below
    if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php', 'widgets.php', 'admin-ajax.php'))) {
        add_action( 'media_buttons', 'add_bootstrap_button', 11 );
        add_action( 'media_buttons', 'bootstrap_shortcodes_help_styles' );
    }

// ======================================================================== // 



// ======================================================================== //		
// Include the help popup content in the footer oO WHAT??
// scavenger: MY MY MY, no wonder my admin was so slow...
// now it loads only with TinyMCE
// ======================================================================== // 

    function boostrap_shortcodes_help_after_mce() {
        include( BS_SHORTCODES_DIR . 'bootstrap-shortcoder-help.php');
    }

    // add_action( 'admin_footer', 'boostrap_shortcodes_help' ); // heresy
    add_action( 'after_wp_tiny_mce', 'boostrap_shortcodes_help_after_mce' );

// ======================================================================== // 



// ======================================================================== //		
// Add the Bootstrap Shortcodes button to Distraction Free Writing mode 
// ======================================================================== //

    function bs_fullscreenbuttons($buttons) {
        $buttons[] = 'separator';
        $buttons['bootstrap-shortcoder'] = array(
            'title' => __('Bootstrap Shortcoder Help'),
            'onclick' => "jQuery('#bootstrap-shortcoder-help').modal('show');",
            'both' => false 
        );
        return $buttons;
    }

    add_action ('wp_fullscreen_buttons', 'bs_fullscreenbuttons');

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