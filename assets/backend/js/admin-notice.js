
jQuery.noConflict();
(function ($) {
    "use strict";
    $(document).on("click", ".oxi-image-support-reviews", function (e) {
        e.preventDefault();
        var notice = $(this).attr('sup-data'),
        $function = 'notice_dissmiss';
        $.ajax({
            url: ImageHoverUltimate.root + 'ImageHoverUltimate/v1/' + $function,
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', ImageHoverUltimate.nonce);
            },
            data: {
                notice: notice,
            }
        }).done(function (response) {
            console.log(response);
            $('.shortcode-addons-review-notice').remove();
        });
    });
})(jQuery);
