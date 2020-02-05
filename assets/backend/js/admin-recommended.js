
jQuery.noConflict();
(function ($) {
    "use strict";
    $(document).on("click", ".oxi-image-admin-recommended-dismiss", function (e) {
        e.preventDefault();
        $.ajax({
            url: oxi_image_hover_admin_recommended.ajaxurl,
            type: 'post',
            data: {
                action: 'oxi_image_hover_admin_recommended',
                _wpnonce: oxi_image_hover_admin_recommended.nonce,
                notice: $(this).attr('sup-data'),
            },
            success: function (response) {
                console.log(response);
                $('.oxi-addons-admin-notifications').remove();
            },
            error: function (error) {
                console.log('Something went wrong!');
            },
        });
        return false;
    });
})(jQuery);
