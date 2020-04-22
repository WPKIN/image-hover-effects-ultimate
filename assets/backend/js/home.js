jQuery.noConflict();
(function ($) {
    var styleid = '';
    var childid = '';
    function Oxi_Image_Admin_Home(functionname, rawdata, styleid, childid, callback) {
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

    $(".addons-pre-check").on("click", function (e) {
        var data = $(this).attr('sub-type');
        if (data === 'premium') {
            alert("Sorry Extension will Works with only Premium Version");
            return false;
        } else {
            return true;
        }

    });

})(jQuery)