/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {

  // Hello World.
  Drupal.behaviors.helloWorld = {
    attach: function (context) {
      console.log('Hello World');
      $(".button-collapse").sideNav();

    }
  }

})(jQuery);
