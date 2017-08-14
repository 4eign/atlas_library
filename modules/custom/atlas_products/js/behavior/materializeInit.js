/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {

  Drupal.behaviors.materialcss = {
    attach: function (context) {
      $('.slider').slider();
    }
  }
    
})(jQuery);
