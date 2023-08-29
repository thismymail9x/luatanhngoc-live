
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