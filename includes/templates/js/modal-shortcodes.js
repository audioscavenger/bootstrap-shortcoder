// https://youmightnotneedjquery.com/
// jQuery(document).ready(function() {
document.addEventListener("DOMContentLoaded", function(event) { 
  
  // ======================================================================== //		
  // Send example shortcodes to the TinyMCE editor when an "Insert Example" button is clicked.
  // The code is looked for before the button: ( this ).parent().prev().find("code")
  //
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
  // The code is looked for from an h3 with id, and id comes from data-h3 inside the button: (this.dataset.h3).next().find("code")
  //
  // the drop code buttons have those classes: btn drop-code + data-h3=#id of the h3 with the code to drop
  // How do we get to the code we want to insert? here is the structure of each original example:
      // <button data-h3="#bs-btn-primary" data-bs-dismiss="modal" class="btn btn-primary drop-code">primary</button>
          // will call this code:
      // <h3 id="bs-btn-primary">btn-primary</h3>
      // <pre><code>[button type="primary" size="md" link="#"] primary [/button]</code></pre>
  // ======================================================================== //
  
  jQuery(".drop-code").click(function() {
    // cannot use href, it breaks the close modal event
    // also all the h3 id are prepended by bs- during rebuilding of the SHORTCODES
    // console.log('this.dataset.h3',this.dataset.h3);    // #bs-btn-primary
    var example = jQuery(this.dataset.h3).next().find("code").text();
    var lines = example.split('\n');
    var paras = '';
    jQuery.each(lines, function(i, line) {
        if (line) {
            paras += line + '<br>';
        }
    });
    var win = window.dialogArguments || opener || parent || top;
    // console.log(win);
    win.send_to_editor(paras);
  });
  
  // ======================================================================== //


  // ======================================================================== //		
  // scroll-up
  // ======================================================================== //
  jQuery("#scroll-up").on("click",function(){
      jQuery(".modal-body").animate({scrollTop:0},800);
      return false;
  });
  
});
