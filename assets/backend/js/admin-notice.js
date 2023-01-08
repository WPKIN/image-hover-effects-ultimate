jQuery.noConflict();
(function ($) {
    "use strict";
    $(document).on("click", ".oxi-image-support-reviews", function (e) {
        e.preventDefault();
        var notice = $(this).attr('sup-data'),
            $function = 'notice_dissmiss';
        $.ajax({
            url: oxi_image_admin_notice.ajaxurl,
            method: 'POST',
            data: {
                _wpnonce: oxi_image_admin_notice.nonce,
                action: 'oxi_image_admin_notice',
                notice: notice,
            }
        }).done(function (response) {
            $('.oxilab-image-hover-review-notice').remove();
        });
    });
})(jQuery);