/*(function (a) {if (a !== null) {sessionStorage.removeItem('logout_redirect');window.location = a;}})(sessionStorage.getItem('logout_redirect'));*/
$('a[href="#"], a[href="javascript:;"]').click(function () {
    return false;
}).attr({rel: "noreferrer noopener",});
$('a[href="users/logout"], a[href="./users/logout"]').click(function () {
    var a =
        $(this).attr("data-title") ||
        $(this).attr("title") ||
        "Xác nhận Đăng xuất khỏi tài khoản!";
    var result = confirm(a);
    //console.log(result);

    // Xóa auto login qua firebase
    if (result === true) {
        localStorage.removeItem("firebase_auto_login");
    }
    return result;
});

/** t\u1ea1o hi\u1ec7u \u1ee9ng selected cho c\u00e1c th\u1ebb a*/function action_active_menu_item() {
    var a = window.location.href;
    $('a[href="' + a + '"]').addClass("active-menu-item");
    if (WGR_config.cf_tester_mode > 0) console.log(a);
    var base_url = $("base").attr("href") || "";
    if (base_url != "") {
        a = a.replace(base_url, "").split("/page/")[0];
        if (WGR_config.cf_tester_mode > 0) console.log(a);
        $('a[href="' + a + '"], a[href="./' + a + '"]').addClass("active-menu-item");
    }
    if (WGR_config.site_lang_sub_dir > 0) {
        var data_lang = $("html").attr("data-lang") || "";
        var data_default_lang = $("html").attr("data-default-lang") || "";
        if (data_lang != "" && data_default_lang != "" && data_lang != data_default_lang) {
            $('a[href="./"], a[href="' + web_link + '"]').attr({href: "./" + data_lang + "/",});
        }
    }
    $(".sub-menu a.active-menu-item").addClass("active").parent("li").addClass("current-menu-item");
    $("ul li.current-menu-item").addClass("active").parent("ul").parent("li").addClass("current-menu-parent");
    $("ul li.current-menu-parent").addClass("active").parent("ul").parent("li").addClass("current-menu-grand").addClass("active");
}

if (support_format_webp() !== true) {
    attr_data_webp = "data-img";
}
_global_js_eb.ebBgLazzyLoad();
_global_js_eb.loadFlatsomeSlider();
_global_js_eb.auto_margin();
jQuery(document).ready(function () {
    move_custom_code_to();
    action_each_to_taxonomy();
    action_active_menu_item();/*if (jQuery(document).height() > jQuery(window).height() * 1.5) {}*/
    setInterval(function () {
        WGR_show_or_hide_to_top();
    }, 250);
    if (height_for_lazzy_load == 0) {
        height_for_lazzy_load = jQuery(window).height();
    }
    _global_js_eb.ebe_currency_format();
    if (typeof sync_ajax_post_term == "function") {
        sync_ajax_post_term();
    }
    $(document).ready(function () {
        $("body").addClass("document-ready");
    });
}).keydown(function (e) {
    if (e.keyCode == 27) {
        hide_if_esc();
    }
});
jQuery(window).resize(function () {
    _global_js_eb.auto_margin();
});
jQuery("#oi_scroll_top, .oi_scroll_top").click(function () {
    window.scroll(0, 0);/*jQuery('body,html').animate({scrollTop: 0}, 500);*/
});