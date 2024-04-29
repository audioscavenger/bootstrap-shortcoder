<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
// https://adambrown.info/p/wp_hooks/hook
// https://rachievee.com/the-wordpress-hooks-firing-sequence/

// ======================================================================== //		
// Include some functional css and jQuery for the shortcodes dropper
//        moved inside respective templates/js and css
// ======================================================================== //

// <style type="text/css">
// </style>

// <script defer type="text/javascript">
// </script>
?>


<?php
// ======================================================================== //		
?>



<?php
// ======================================================================== //		
// Create the documentation popup modal
// ======================================================================== //
?>

<div id="bootstrap-shortcoder-help" class="modal fade" tabindex="-1" aria-labelledby="bootstrap-shortcoder-help-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
          <h1 class="modal-title fs-5" id="bootstrap-shortcoder-help-modal">Bootstrap Shortcodes Insert</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs" id="bs-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="bs-shortcode-reference-tab" data-bs-toggle="tab" data-bs-target="#bs-shortcode-reference-tab-pane" type="button" role="tab" aria-controls="bs-shortcode-reference-tab-pane" aria-selected="true">Shortcode Reference</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="bs-requirements-tab" data-bs-toggle="tab" data-bs-target="#bs-requirements-tab-pane" type="button" role="tab" aria-controls="bs-requirements-tab-pane" aria-selected="false">Requirements</button>
          </li>
        </ul>
        
        <div class="tab-content" id="bs-top">
        <?php
            // ======================================================================== //		
            // Put HTML content in the page so we can pop it up in a modal
            // But first edit the HTML to make it more useful as popup documentation
            //      * Alter links to open in new tabs
            //      * Add Bootstrap styling to tables
            //      * Add Bootstrap styling to lists (and replace ULs with DIVs, and LIs with As)
            //      * Edit anchors to be on-page jumps
            //      * Add back-to-top buttons after sections
            //      * Add IDs to h3 tags for the above on-page jumps
            //      * Add "Insert Example" buttons after code examples
            // ======================================================================== //
            // Since 4.0.3 we will use the compiled version, I am not maintaining the README.md
            //      because the structure is incompatible with tab-content; we could shuffle stuff around
            //      with PHP and some markers placed perperly, but why do I care? I don't even have grunt installed.
            // ======================================================================== //
            
            // ======================================================================== //		
            // Get the contents of the help document, save them in a variable
            // ======================================================================== // 
            // $html = file_get_contents(dirname(__FILE__) . '/templates/SHORTCODES.html');
            $html_compiled = file_get_contents(dirname(__FILE__) . '/templates/SHORTCODES-compiled.html');
            // ======================================================================== // 

            // $html = preg_replace('/(<a href="http:[^"]+")>/is','\\1 target="_blank">',$html);
            // $html = str_replace('<table>', '<table class="table table-striped">', $html);
            // $html = str_replace('<ul>', '<div class="list-group">', $html);
            // $html = str_replace('</ul>', '</div>', $html);
            // $html = str_replace('<li><a ', '<a class="list-group-item" ', $html);
            // $html = str_replace('</li>', '', $html);
            // $html = str_replace('href="#', 'href="#bs-', $html);
            // $html = str_replace('<hr>', '<hr><a class="btn btn-link btn-primary pull-right" href="#bs-top"><i class="text-muted glyphicon glyphicon-arrow-up"></i></a>', $html);
            // $html = str_replace('<h3 id="', '<h3 id="bs-', $html);
            // $html = str_replace('</pre>', '</pre><p><button data-bs-dismiss="modal" class="btn btn-primary btn-sm insert-code">Insert Example <i class="glyphicon glyphicon-share-alt"></i></button></p>', $html);
            
            // file_put_contents('/run/cache/SHORTCODES-compiled.html', $html);
            // Insert the HTML now that we're done editing it
            // echo $html;
            echo $html_compiled;

            // ======================================================================== //
        ?>
        </div><!-- /.tab-content -->
        <a id="scroll-up" class="secondary-color">
            <i class="fa fa-angle-up"></i>
        </a>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
// ======================================================================== //
?>
