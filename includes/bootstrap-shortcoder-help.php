<?php

// ======================================================================== //		
// Get the contents of the help document, save them in a variable
// ======================================================================== // 

$html = file_get_contents(dirname(__FILE__) . '/help/README.html');

// ======================================================================== // 



// ======================================================================== //		
// Include some jQuery to edit the help document
// ======================================================================== //
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        
        // ======================================================================== //		
        // Send example shortcodes to the TinyMCE editor when an "Insert Example"
        // button is clicked.
        // the insert code buttons have those classes: btn btn-primary btn-sm insert-code
        // button.parent = p and prev = <pre><code>example</code></pre>
            // <h3 id="buttons">Buttons</h3>
            // <pre><code>[button type=&quot;success&quot; size=&quot;lg&quot; link=&quot;#&quot;] ... [/button]</code></pre> [<pre><code>[button type=&quot;primary&quot; size=&quot;md&quot; link=&quot;#&quot;] ... [/button]</code></pre> dynamically added--> [<p><button data-bs-dismiss="modal" class="btn btn-primary btn-sm insert-code">Insert Example <i class="glyphicon glyphicon-share-alt"></i></button></p>]
        // ======================================================================== //
        
            jQuery(".insert-code").click(function() {
                var example = jQuery( this ).parent().prev().find("code").text();
                var lines = example.split('\n');
                var paras = '';
                jQuery.each(lines, function(i, line) {
                    if (line) {
                        paras += line + '<br>';
                    }
                });
                var win = window.dialogArguments || opener || parent || top;
                win.send_to_editor(paras);
            });
        
        // ======================================================================== //
    
    
        // ======================================================================== //		
        // Send example shortcodes to the TinyMCE editor when a new example button is clicked
        // the insert code buttons are in groups btn-group-md and have those classes: btn insert-code
        // How do we get to the code we want to insert? here is the structure of each original example:
            // <h3 id="buttons">Buttons</h3>
            // <pre><code>[button type=&quot;success&quot; size=&quot;lg&quot; link=&quot;#&quot;] ... [/button]</code></pre>
        // new structure:
            // <h3 id="buttons">Buttons</h3>
            // <h4 id="btn-default, primary, success, info, warning, danger, link">btn-default</h4>
            // <pre><code>[button type=&quot;success&quot; size=&quot;lg&quot; link=&quot;#&quot;] ... [/button]</code></pre> [<pre><code>[button type=&quot;primary&quot; size=&quot;md&quot; link=&quot;#&quot;] ... [/button]</code></pre> dynamically added--> [<p><button data-bs-dismiss="modal" class="btn btn-primary btn-sm insert-code">Insert Example <i class="glyphicon glyphicon-share-alt"></i></button></p>]
            // ...
        // ======================================================================== //
        
            jQuery(".drop-code").click(function() {
                // href in this case is the specific example after the new h4s
                // console.log(this);
                // console.log(this.getAttribute('href'));              // #bs-btn-primary
                // console.log(jQuery(this.getAttribute('href')));         // supposedly the h4
                // console.log(jQuery(this.getAttribute('href')).next());  // supposedly the pre
                // console.log(jQuery(this.getAttribute('href')).next().find("code"));
                var example = jQuery(this.getAttribute('href')).next().find("code").text();
                var lines = example.split('\n');
                var paras = '';
                jQuery.each(lines, function(i, line) {
                    if (line) {
                        paras += line + '<br>';
                    }
                });
                var win = window.dialogArguments || opener || parent || top;
                win.send_to_editor(paras);
            });
        
        // ======================================================================== //
    
    
        
        // ======================================================================== //		
        // Create tabs from the help documentation content, splitting on the H2s
        // ======================================================================== //
        // scavenger: all is now disabled
        // ======================================================================== //
        
            // jQuery('#bootstrap-shortcoder-help h2').each(function(){
                // var id = jQuery(this).attr("id");
                // jQuery(this).removeAttr("id").nextUntil("h2").andSelf().wrapAll('<div class="tab-pane" id="bs-' + id + '" />');
            // });
            //Make the documentation tab active
            // jQuery('#bs-shortcode-reference').addClass('active');  // scavenger unneeded
        
            //Hide header info from the readme, not relevent to documentation.
            // jQuery("#bootstrap-shortcoder-help #bootstrap-shortcoder-for-wordpress").nextUntil("#bootstrap-shortcoder-help #bs-requirements").hide();
        
        // ======================================================================== //
        
    });
</script>


<?php
// ======================================================================== //		
?>



<?php
// ======================================================================== //		
// Create the documentation popup modal
// ======================================================================== //
?>

<div id="bootstrap-shortcoder-help" class="modal fade" tabindex="-1" aria-labelledby="bootstrap-shortcoder-help-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
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
            
            $html = preg_replace('/(<a href="http:[^"]+")>/is','\\1 target="_blank">',$html);
            $html = str_replace('<table>', '<table class="table table-striped">', $html);
            $html = str_replace('<ul>', '<div class="list-group">', $html);
            $html = str_replace('</ul>', '</div>', $html);
            $html = str_replace('<li><a ', '<a class="list-group-item" ', $html);
            $html = str_replace('</li>', '', $html);
            $html = str_replace('href="#', 'href="#bs-', $html);
            $html = str_replace('<hr>', '<hr><a class="btn btn-link btn-default pull-right" href="#bs-top"><i class="text-muted glyphicon glyphicon-arrow-up"></i></a>', $html);
            $html = str_replace('<h3 id="', '<h3 id="bs-', $html);
            $html = str_replace('</pre>', '</pre><p><button data-bs-dismiss="modal" class="btn btn-primary btn-sm insert-code">Insert Example <i class="glyphicon glyphicon-share-alt"></i></button></p>', $html);
            
            ////Insert the HTML now that we're done editing it
            file_put_contents('/run/cache/README-transformed.html', $html);
            echo $html;

            // ======================================================================== //
        ?>
        </div><!-- /.tab-content -->

      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
// ======================================================================== //
?>
