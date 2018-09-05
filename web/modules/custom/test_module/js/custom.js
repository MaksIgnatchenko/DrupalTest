(function ($, Drupal) {
    Drupal.behaviors.slider = {
        attach: function (context, settings) {
            console.log(drupalSettings);
            $('.custom-slick-slider').slick();
            var greating = drupalSettings.test_module.slick.greating;
            alert(greating);
        }
    };
})(jQuery, Drupal);