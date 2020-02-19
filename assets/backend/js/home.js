jQuery.noConflict();
(function ($) {
    var styleid = '';
    var childid = '';
    function Oxi_Image_Admin_Home(functionname, rawdata, styleid, childid, callback) {
        if (functionname !== "") {
            $.ajax({
                url: oxi_image_hover_editor.ajaxurl,
                type: "post",
                data: {
                    action: "oxi_image_hover_data",
                    _wpnonce: oxi_image_hover_editor.nonce,
                    functionname: functionname,
                    styleid: styleid,
                    childid: childid,
                    rawdata: rawdata
                },
                success: function (response) {
                    console.log(response);
                    callback(response);
                }
            });
        }
    }

})(jQuery)