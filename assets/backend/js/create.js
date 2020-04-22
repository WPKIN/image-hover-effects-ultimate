jQuery.noConflict();
(function ($) {
    var styleid = '';
    var childid = '';
    function Image_Hover_Admin_Create(functionname, rawdata, styleid, childid, callback) {
        if (functionname !== "") {
            $.ajax({
                url: ImageHoverUltimate.root + 'ImageHoverUltimate/v1/' + functionname,
                method: 'POST',
                dataType: "json",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', ImageHoverUltimate.nonce);
                },
                data: {
                    styleid: styleid,
                    childid: childid,
                    rawdata: rawdata
                }
            }).done(function (response) {
                callback(response);
            });
        }
    }
    $(".oxi-addons-addons-template-create").on("click", function (e) {
        e.preventDefault();
        $('#style-name').val('');
        $('#oxistyledata').val($(this).attr('effects-data'));
        $("#oxi-addons-style-create-modal").modal("show");
    });

    $("#oxi-addons-style-modal-form").submit(function (e) {
        e.preventDefault();
        $a = $('#oxistyledata').val() + "-" + $("input[name='image-hover-box-layouts']:checked").val();
        var data = {
            name: $('#style-name').val(),
            style: JSON.parse($('#' + $a).val())
        };
        var rawdata = JSON.stringify(data);
        var functionname = "create_new";
        $('.modal-footer').prepend('<span class="spinner sa-spinner-open-left"></span>');
        Image_Hover_Admin_Create(functionname, rawdata, styleid, childid, function (callback) {
            setTimeout(function () {
                document.location.href = callback;
            }, 1000);
        });
    });

    $(".oxi-addons-addons-style-btn-warning").on("click", function (e) {
        e.preventDefault();
        var functionname = "shortcode_deactive";
        $This = $(this);
        $This.append('<span class="spinner sa-spinner-open"></span>');
        Image_Hover_Admin_Create(functionname, $This.attr('data-effects'), $This.attr('data-value'), childid, function (callback) {
            setTimeout(function () {
                if (callback === "done") {
                    $This.parents('.oxi-addons-col-1').remove();
                }
            }, 1000);
        });
        return false;
    });

    $(".oxi-addons-addons-style-btn-active").on("click", function (e) {
        e.preventDefault();
        var functionname = "shortcode_active";
        $This = $(this);
        $This.append('<span class="spinner sa-spinner-open"></span>');
        Image_Hover_Admin_Create(functionname, $This.attr('data-effects'), $This.attr('data-value'), childid, function (callback) {
            setTimeout(function () {
                document.location.href = callback;
            }, 1000);
        });
        return false;
    });

})(jQuery)