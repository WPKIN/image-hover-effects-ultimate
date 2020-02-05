jQuery.noConflict();
(function ($) {
    'use strict';
    $('.oxi-image-hover-figure').on('touchstart', function (e) {
        "use strict";
        var link = jQuery(this);
        if (link.hasClass("oxi-touch")) {
            return true;
        } else {
            link.addClass("oxi-touch");
            $(".oxi-image-hover-figure").not(this).removeClass("oxi-touch");
            e.preventDefault();
            return false;
        }
    });
})(jQuery);