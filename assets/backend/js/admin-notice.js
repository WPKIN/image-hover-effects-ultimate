
jQuery.noConflict();
(function ($) {
    "use strict";
    $(document).on("click", ".oxi-image-support-reviews", function (e) {
        e.preventDefault();
      
        $.ajax({
            url: oxi_image_notice_dissmiss.ajaxurl,
            type: 'post',
            data: {
                action: 'oxi_image_notice_dissmiss',
                _wpnonce: oxi_image_notice_dissmiss.nonce,
                notice: $(this).attr('sup-data'),
            },
            success: function (response) {
                $('.shortcode-addons-review-notice').remove();
            },
            error: function (error) {
                console.log('Something went wrong!');
            },
        });
    });
})(jQuery);
