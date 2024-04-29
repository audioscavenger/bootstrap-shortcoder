// https://stackoverflow.com/questions/8130069/load-a-bootstrap-popover-content-with-ajax-is-this-possible

jQuery('*[data-poload]').click(function() {
    var e=jQuery(this);
    e.off('click');
    jQuery.get(e.data('poload'),function(data) {
        console.log('loaded');
        e.popover({
          html:true,
          content: data
          }).popover('show');
    });
});
