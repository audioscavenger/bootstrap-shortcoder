(function($) {
    $("[data-bs-toggle=popover]")
      .on('click', function(e) {e.preventDefault(); return true;})
      .popover()
})(jQuery);
