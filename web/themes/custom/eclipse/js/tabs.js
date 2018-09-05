(function ($, Drupal) {
    Drupal.behaviors.showAlert = {
        attach: function (context, settings) {
            $('.bodies').first().css('display', 'block');
            $('.icon-tab', context).on("click", function() {
                $('.icon-tab').css('border', '0px solid white');
                $(this).css('border', '5px solid white');
                $('.bodies').css('display', 'none');
                var id = 'body' + $(this).attr('id').replace( /^\D+/g, '');
                var bodyItem = document.getElementById(id);
                $(bodyItem).css('display', 'block');
            });
        }
    };
})(jQuery, Drupal);