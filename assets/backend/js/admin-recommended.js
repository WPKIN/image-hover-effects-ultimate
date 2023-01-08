jQuery.noConflict();
(function ($) {
    "use strict";
    $(document).on("click", ".oxi-image-admin-recommended-dismiss", function (e) {
        e.preventDefault();
        var notice = $(this).attr('sup-data');
        $.ajax({
            url: oxi_image_admin_recommended.ajaxurl,
            method: 'POST',
            data: {
                action: 'oxi_image_admin_recommended',
                _wpnonce: oxi_image_admin_recommended.nonce,
                notice: 'Done',
            }
        }).done(function (response) {

            console.log(response);
            $('.oxi-addons-admin-notifications').remove();
        });
        return false;
    });
})(jQuery);
