jQuery.noConflict();
(function ($) {
    var styleid = '';
    var childid = '';

    async function Oxi_Image_Admin_Home(functionname, rawdata, styleid, childid, callback) {
        if (functionname === "") {
            alert('Confirm Function Name');
            return false;
        }
        let result;
        try {
            result = await $.ajax({
                url: image_hover_settings.ajaxurl,
                method: 'POST',
                data: {
                    action: 'image_hover_settings',
                    _wpnonce: image_hover_settings.nonce,
                    functionname: functionname,
                    styleid: styleid,
                    childid: childid,
                    rawdata: rawdata
                }
            });
            try {
                console.log(JSON.parse(result));
                return callback(JSON.parse(result));
            } catch (e) {
                console.log(result);
                return callback(result)
            }

        } catch (error) {
            console.error(error);
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