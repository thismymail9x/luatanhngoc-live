
// chỉnh lại chiều cao cho textediter nếu có
$(".auto-ckeditor").each(function () {
    var h = $(this).attr("data-height") || "";
    var jd = $(this).attr("id") || "";

    if (h != "" && jd != "") {
        WGR_load_textediter("#" + jd, {
            height: h * 1,
        });
        /*
        CKEDITOR.replace(jd, {
            height: h * 1
        });
        */
    } else {
        console.log(
            "%c auto-ckeditor not has attr data-height or id",
            "color: red;"
        );
    }
});

$('body').delegate('.receivePost','click',function () {
    const trParent = $(this).closest('tr');
    // Lấy nội dung văn bản của phần tử .bold nằm trong cùng thẻ tr
    const name = trParent.find('.bold').text();
    let id = trParent.data('id');
    if (confirm('Xác nhận viết bài '+ name +'?')) {
        jQuery.ajax({
            type: "POST",
            url: "c/receivePost",
            dataType: "json",
            data: {id: id},
            timeout: 33 * 1000,
            error: function (jqXHR, textStatus, errorThrown) {
                jQueryAjaxError(jqXHR, textStatus, errorThrown, new Error().stack);
            },
            success: function (data) {
                if (data.ok != undefined) {
                    WGR_alert('Thành công')
                }
                if (data.error != undefined) {
                    WGR_alert(data.error,'error')
                }

            },
        });
    }
})