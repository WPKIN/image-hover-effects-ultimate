jQuery.noConflict();
(function ($) {

    $(".oxi-image-hover-load-more-infinite").each(function () {
        var $WRAPPER = $(this);
        $(window).scroll(function () {
            if ($(window).scrollTop() > ($(document).height() - $(window).height() - 10)) {
                if (!($WRAPPER.hasClass("post-loading"))) {
                    $WRAPPER.addClass("post-loading");
                    $CLASS = $WRAPPER.data('class');
                    $function = $WRAPPER.data('function');
                    $args = $WRAPPER.data('args');
                    $settings = $WRAPPER.data('settings');
                    $page = parseInt($WRAPPER.data("page")) + 1;

                    $.ajax({
                        url: oxi_image_hover_editor.ajaxurl,
                        type: "post",
                        data: {
                            action: "oxi_image_hover_data",
                            _wpnonce: oxi_image_hover_editor.nonce,
                            class: $CLASS,
                            functionname: $function,
                            rawdata: $settings,
                            args: $args,
                            optional: $page,
                        },
                        success: function (response) {
                            if (response == 'sdfghjklcns') {
                                $WRAPPER.remove();
                            } else {
                                $WRAPPER.data("page", $page);
                                $(response).insertBefore($WRAPPER);
                                $WRAPPER.removeClass("post-loading");
                            }
                        }
                    });

                }
            }
        });
    });

    $(document).on("click", ".oxi-image-load-more-button", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var $WRAPPER = $(this);
        $WRAPPER.addClass("button--loading");
        $CLASS = $WRAPPER.data('class');
        $function = $WRAPPER.data('function');
        $args = $WRAPPER.data('args');
        $settings = $WRAPPER.data('settings');
        $page = parseInt($WRAPPER.data("page")) + 1;
        $.ajax({
            url: oxi_image_hover_editor.ajaxurl,
            type: "post",
            data: {
                action: "oxi_image_hover_data",
                _wpnonce: oxi_image_hover_editor.nonce,
                class: $CLASS,
                functionname: $function,
                rawdata: $settings,
                args: $args,
                optional: $page,
            },
            success: function (response) {
                if (response == 'sdfghjklcns') {
                    $WRAPPER.parent().remove();
                } else {
                    $WRAPPER.data("page", $page);
                    $(response).insertBefore($WRAPPER.parent());
                    $WRAPPER.removeClass("button--loading");
                }
            }
        });

    });
})(jQuery)