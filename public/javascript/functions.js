if (typeof $ == "undefined") {
    $ = jQuery;
}
var bg_load = "Loading...", youtube_video_default_size = 9 / 16, primary_domain_usage_eb = "",
    disable_eblazzy_load = false, height_for_lazzy_load = 0, sb_submit_cart_disabled = 0,
    ebe_arr_cart_product_list = [], ebe_arr_cart_customer_info = [], arr_ti_le_global = {};
var global_window_width = jQuery(window).width(), web_link = window.location.protocol + "//" + document.domain + "/";

function WGR_html_alert(m, lnk) {
    return WGR_alert(m, lnk);
}

function WGR_alert(m, lnk) {
    if (typeof m == "undefined") {
        m = "";
    }
    if (typeof lnk == "undefined") {
        lnk = "";
    }
    if (top != self) {
        top.WGR_alert(m, lnk);
    } else {
        if (m != "") {
            var cl = "";
            if (lnk == "error") {
                cl = "redbg";
            } else if (lnk == "warning") {
                cl = "orgbg";
            }
            var jd = "_" + Math.random().toString(32).replace(/\./gi, "_");
            var htm = ['<div id="' + jd + '" class="' + cl + '" onClick="$(this).fadeOut();">', m, "</div>",].join(" ");
            if ($("#my_custom_alert").length <= 0) {
                $("body").append('<div id="my_custom_alert"></div>');
            }
            $("#my_custom_alert").append(htm).show();
            setTimeout(function () {
                $("#" + jd).remove();
                if ($("#my_custom_alert div").length <= 0) {
                    $("#my_custom_alert").fadeOut();
                }
            }, 6000);
        } else if (lnk != "") {
            return WGR_redirect(lnk);
        }
    }
    return false;
}

function WGR_redirect(l) {
    if (top != self) {
        top.WGR_redirect(l);
    } else if (typeof l != "undefined" && l != "") {
        window.location = l;
    }
}

function WGR_show_try_catch_err(e) {
    return ("name: " + e.name + "; line: " + (e.lineNumber || e.line) + "; script: " + (e.fileName || e.sourceURL || e.script) + "; stack: " + (e.stackTrace || e.stack) + "; message: " + e.message);
}

var current_croll_up_or_down = 0;

function WGR_show_or_hide_to_top() {
    var new_scroll_top = window.scrollY || jQuery(window).scrollTop();
    if (new_scroll_top > 120) {
        jQuery("body").addClass("ebfixed-top-menu");
        if (current_croll_up_or_down > new_scroll_top) {
            jQuery("body").addClass("ebfixed-up-menu").removeClass("ebfixed-down-menu");
        } else if (current_croll_up_or_down < new_scroll_top) {
            jQuery("body").addClass("ebfixed-down-menu").removeClass("ebfixed-up-menu");
        }
        current_croll_up_or_down = new_scroll_top;
        if (new_scroll_top > 500) {
            jQuery("body").addClass("ebshow-top-scroll");
            _global_js_eb.ebBgLazzyLoad(new_scroll_top);
        } else {
            jQuery("body").removeClass("ebshow-top-scroll");
        }
    } else {
        jQuery("body").removeClass("ebfixed-top-menu").removeClass("ebfixed-up-menu").removeClass("ebfixed-down-menu").removeClass("ebshow-top-scroll");
    }
}


function WGR_set_prop_for_select(for_id) {
    $(for_id).each(function () {
        var a = $(this).attr("data-select") || "";
        if (a != "" && !$(this).hasClass("set-selected")) {
            a = a.split(",");
            $(this).val(a[0]).addClass("set-selected");
            for (var i = 0; i < a.length; i++) {
                $('option[value="' + a[i] + '"]', this).prop("selected", true).addClass("bold").addClass("gray2bg");
            }
        }
    });
}

var g_func = {
    non_mark: function (str) {
        str = str.toLowerCase();
        str = str.replace(/\u00e0|\u00e1|\u1ea1|\u1ea3|\u00e3|\u00e2|\u1ea7|\u1ea5|\u1ead|\u1ea9|\u1eab|\u0103|\u1eb1|\u1eaf|\u1eb7|\u1eb3|\u1eb5/g, "a");
        str = str.replace(/\u00e8|\u00e9|\u1eb9|\u1ebb|\u1ebd|\u00ea|\u1ec1|\u1ebf|\u1ec7|\u1ec3|\u1ec5/g, "e");
        str = str.replace(/\u00ec|\u00ed|\u1ecb|\u1ec9|\u0129/g, "i");
        str = str.replace(/\u00f2|\u00f3|\u1ecd|\u1ecf|\u00f5|\u00f4|\u1ed3|\u1ed1|\u1ed9|\u1ed5|\u1ed7|\u01a1|\u1edd|\u1edb|\u1ee3|\u1edf|\u1ee1/g, "o");
        str = str.replace(/\u00f9|\u00fa|\u1ee5|\u1ee7|\u0169|\u01b0|\u1eeb|\u1ee9|\u1ef1|\u1eed|\u1eef/g, "u");
        str = str.replace(/\u1ef3|\u00fd|\u1ef5|\u1ef7|\u1ef9/g, "y");
        str = str.replace(/\u0111/g, "d");
        return str;
    },
    non_mark_seo: function (str) {
        str = this.non_mark(str);
        str = str.replace(/\s/g, "-");
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|$|_/g, "");
        str = str.replace(/-+-/g, "-");
        str = str.replace(/^\-+|\-+$/g, "");
        for (var i = 0; i < 5; i++) {
            str = str.replace(/--/g, "-");
        }
        str = (function (s) {
            var str = "", re = /^\w+$/, t = "";
            for (var i = 0; i < s.length; i++) {
                t = s.substr(i, 1);
                if (t == "-" || t == "+" || re.test(t) == true) {
                    str += t;
                }
            }
            return str;
        })(str);
        return str;
    },
    strip_tags: function (input, allowed) {
        if (typeof input == "undefined" || input == "") {
            return "";
        }
        if (typeof allowed == "undefined") {
            allowed = "";
        }
        allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join("");
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi, cm = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
        return input.replace(cm, "").replace(tags, function ($0, $1) {
            return allowed.indexOf("<" + $1.toLowerCase() + ">") > -1 ? $0 : "";
        });
    },
    trim: function (str) {
        return jQuery.trim(str);
    },
    setc: function (name, value, seconds, days, set_domain) {
        var expires = "";
        if (typeof days == "number" && days > 0) {
            seconds = days * 24 * 3600;
        } else {
            days = 0;
        }
        if (typeof seconds == "number") {
            seconds = seconds * 1000;
            var date = new Date();
            date.setTime(date.getTime() + seconds);
            expires = "; expires=" + date.toGMTString();
        }
        var cdomain = "";
        if (typeof set_domain != "undefined") {
            if (set_domain.toString().split(".").length == 1) {
                cdomain = window.location.host || document.domain || "";
            } else {
                cdomain = set_domain;
            }
            cdomain = cdomain.split(".");
            if (cdomain[0] == "www") {
                cdomain[0] = "";
                cdomain = cdomain.join(".");
            } else if (cdomain[0] != "") {
                cdomain = "." + cdomain.join(".");
            } else {
                cdomain = cdomain.join(".");
            }
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + ";domain=" + cdomain + ";path=/";
        } else {
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + ";path=/";
        }
        if (WGR_check_option_on(WGR_config.cf_tester_mode)) console.log("Set cookie: " + name + " with value: " + value + " for domain: " + cdomain + " time: " + seconds + " (" + days + " day)");
    },
    getc: function (name) {
        var nameEQ = encodeURIComponent(name) + "=", ca = document.cookie.split(";"), re = "";
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === " ") {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
                re = decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
        }
        if (re == "") {
            return null;
        }
        return re;
    },
    delck: function (name) {
        g_func.setc(name, "", 0 - 24 * 3600 * 7);
    },
    text_only: function (str) {
        if (typeof str == "undefined" || str == "") {
            return "";
        }
        str = str.toString().replace(/[^a-zA-Z\s]/g, "");
        if (str == "") {
            return "";
        }
        return str;
    },
    number_only: function (str, format) {
        if (typeof str == "undefined" || str == "") {
            return 0;
        }
        if (typeof format == "string" && format != "") {
            str = str.toString().replace(eval(format), "");
            if (str == "") {
                return 0;
            }
            return str * 1;
        } else {
            str = str.toString().replace(/[^0-9\-\+]/g, "");
            if (str == "") {
                return 0;
            }
            return str * 1;
        }
    },
    only_number: function (str) {
        return g_func.number_only(str);
    },
    float_only: function (str) {
        return g_func.number_only(str, "/[^0-9-+.]/g");
    },
    money_format: function (str) {
        str = str.toString().replace(/\,/g, "").split(".");
        str[0] = str[0] * 1;
        return g_func.formatCurrency(str.join("."), ",", 2);
    },
    number_format: function (str) {
        return g_func.formatCurrency(str);
    },
    formatV2Currency: function (number, decimals, dec_point, thousands_sep) {
        number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
        var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
            dec = typeof dec_point === "undefined" ? "." : dec_point, s = "", toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return "" + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || "").length < prec) {
            s[1] = s[1] || "";
            s[1] += new Array(prec - s[1].length + 1).join("0");
        }
        return s.join(dec).split(dec + "00")[0];
    },
    formatCurrency: function (num, dot, num_thap_phan) {
        if (typeof num == "undefined" || num == "") {
            return 0;
        }
        if (typeof dot == "undefined" || dot == "") {
            dot = ",";
        }
        var dec_point = ".";
        if (dot != ",") {
            dec_point = ",";
        }
        if (typeof num_thap_phan == "undefined" || num_thap_phan == "") {
            num_thap_phan = 0;
        }/** v3*/
        return g_func.formatV2Currency(num, num_thap_phan, dec_point, dot);
    },
    wh: function () {
    },
    opopup: function (o) {
    },
    mb_v2: function () {
        return WGR_is_mobile();
    },
    mb: function (a) {
        return g_func.mb_v2();
    },
    /*** Returns a random number between min (inclusive) and max (exclusive)*/getRandomArbitrary: function (min, max) {
        return Math.random() * (max - min) + min;
    },
    /*** Returns a random integer between min (inclusive) and max (inclusive)* Using Math.round() will give you a non-uniform distribution!*/getRandomInt: function (min, max) {
        if (min != max && min < max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        return 0;
    },
    rand: function (min, max) {
        return g_func.getRandomInt(min, max);
    },
    short_string: function (str, len, more) {
        str = jQuery.trim(str);
        if (len > 0 && str.length > len) {
            var a = str.split(" ");
            str = "";
            for (var i = 0; i < a.length; i++) {
                if (a[i] != "") {
                    str += a[i] + " ";
                    if (str.length > len) {
                        break;
                    }
                }
            }
            str = jQuery.trim(str);
            if (typeof more == "undefined" || more == true || more == 1) {
                str += "...";
            }
        }
        return str;
    },
};

function WGR_duy_tri_dang_nhap(max_i) {
    if (typeof WGR_config.current_user_id != "undefined" && WGR_config.current_user_id <= 0) {
        return false;
    }
    if (typeof max_i != "number") {
        max_i = 15;
    } else if (max_i < 0) {
        window.location = window.location.href;
        return false;
    }
    if (typeof WGR_config.current_user_id != "undefined") {
        console.log("Current user ID: " + WGR_config.current_user_id + " (max i: " + max_i + ")");
    }
    jQuery.ajax({
        type: "GET",
        url: "logged/confirm_login",
        dataType: "json",
        timeout: 33 * 1000,
        error: function (jqXHR, textStatus, errorThrown) {
            jQueryAjaxError(jqXHR, textStatus, errorThrown, new Error().stack);
        },
        success: function (data) {
            console.log(data);
            setTimeout(function () {
                WGR_duy_tri_dang_nhap(max_i - 1);
            }, 5 * 60 * 1000);
        },
    });
    return true;
}

function get_taxonomy_data_by_ids(arr, jd) {
    if (jd > 0) {
        for (var i = 0; i < arr.length; i++) {
            if (arr[i].term_id * 1 == jd) {
                return arr[i];
            }
        }
        for (var i = 0; i < arr.length; i++) {
            if (typeof arr[i].child_term == "undefined" || arr[i].child_term.length <= 0) {
                continue;
            }
            var taxonomy_data = get_taxonomy_data_by_ids(arr[i].child_term, jd);
            if (taxonomy_data !== null) {
                return taxonomy_data;
            }
        }
    }
    return null;
}

var taxonomy_ids_unique = [];
var arr_ajax_taxonomy = [];
var ready_load_ajax_taxonomy = false;
var loading_ajax_taxonomy = false;
var reload_ajax_taxonomy = false;

function action_each_to_taxonomy() {
    try {
        if (WGR_config.cf_tester_mode > 0 && arguments.callee.caller !== null) {
            console.log("Call in: " + arguments.callee.caller.name.toString());
        }
    } catch (e) {
        WGR_show_try_catch_err(e);
    }
    if (loading_ajax_taxonomy === true) {
        if (WGR_config.cf_tester_mode > 0) console.log("loading ajax taxonomy");
        reload_ajax_taxonomy = true;
        return false;
    }
    loading_ajax_taxonomy = true;
    taxonomy_ids_unique = [];
    if (WGR_config.cf_tester_mode > 0) console.log("action each to taxonomy:", $(".each-to-taxonomy").length);
    $('.each-to-taxonomy[data-id="0"], .each-to-taxonomy[data-id=""]').removeClass("each-to-taxonomy").addClass("zero-to-taxonomy");
    $(".each-to-taxonomy").each(function () {
        var a = $(this).attr("data-id") || "";
        var as = $(this).attr("data-ids") || "";
        if (a == "") {
            a = as;
        }
        if (a != "") {
            a = a.split(",");
            for (var i = 0; i < a.length; i++) {
                if (a[i] != "") {
                    a[i] = $.trim(a[i]);
                    a[i] *= 1;
                    if (a[i] > 0) {
                        var has_add = false;
                        for (var j = 0; j < taxonomy_ids_unique.length; j++) {
                            if (a[i] == taxonomy_ids_unique[j]) {
                                has_add = true;
                                break;
                            }
                        }
                        if (has_add === false) {
                            taxonomy_ids_unique.push(a[i]);
                        }
                    }
                }
            }
            $(this).addClass("loading-to-taxonomy").removeClass("each-to-taxonomy");
        }
    });
    if (taxonomy_ids_unique.length == 0) {
        if (WGR_config.cf_tester_mode > 0) console.log("taxonomy ids unique length");
        reset_each_to_taxonomy();
        return false;
    }
    jQuery.ajax({
        type: "POST",
        url: "ajaxs/get_taxonomy_by_ids",
        dataType: "json",
        data: {ids: taxonomy_ids_unique.join(","),},
        timeout: 33 * 1000,
        error: function (jqXHR, textStatus, errorThrown) {
            jQueryAjaxError(jqXHR, textStatus, errorThrown, new Error().stack);
        },
        success: function (data) {
            if (WGR_config.cf_tester_mode > 0) console.log(data);
            if (reload_ajax_taxonomy === true) {
                setTimeout(function () {
                    if (WGR_config.cf_tester_mode > 0) console.log("reload ajax taxonomy");
                    action_each_to_taxonomy();
                }, 100);
            }
            reset_each_to_taxonomy();
            return after_each_to_taxonomy(data);
        },
    });
}

function reset_each_to_taxonomy() {
    ready_load_ajax_taxonomy = true;
    loading_ajax_taxonomy = false;
    reload_ajax_taxonomy = false;
}

function after_each_to_taxonomy(data) {
    $(".loading-to-taxonomy").each(function () {
        var a = $(this).attr("data-id") || "";
        var as = $(this).attr("data-ids") || "";
        var uri = $(this).attr("data-uri") || "";
        if (uri != "") {
            if (uri.split("%term_id%").length == 1) {
                if (uri.split("?").length > 1) {
                    uri += "&";
                } else {
                    uri += "?";
                }
                uri += "term_id=%term_id%";
            }
        }
        var a_class = $(this).attr("data-class") || "";
        var a_space = $(this).attr("data-space") || ", ";
        if (a == "") {
            a = as;
        }
        if (a != "") {
            a = a.split(",");
            var str = [];
            for (var i = 0; i < a.length; i++) {
                if (a[i] != "") {
                    var taxonomy_data = get_taxonomy_data_by_ids(data, a[i] * 1);
                    if (taxonomy_data === null) {
                        str.push("#" + a[i]);
                        continue;
                    }
                    arr_ajax_taxonomy.push(taxonomy_data);
                    var taxonomy_name = taxonomy_data.term_shortname != "" ? taxonomy_data.term_shortname : taxonomy_data.name;
                    if (uri != "") {
                        var url = uri;
                        for (var x in taxonomy_data) {
                            url = url.replace("%" + x + "%", taxonomy_data[x]);
                        }
                        taxonomy_name = '<a href="' + url + '" class="' + a_class + '">' + taxonomy_name + "</a>";
                    }
                    if (taxonomy_name != "") {
                        str.push(taxonomy_name);
                    }
                }
            }
            $(this).html(str.join(a_space));
        }
        $(this).addClass("loaded-to-taxonomy").removeClass("loading-to-taxonomy");
    });
}

function support_format_webp() {
    var elem = document.createElement("canvas");
    if (!!(elem.getContext && elem.getContext("2d"))) {
        return elem.toDataURL("image/webp").indexOf("data:image/webp") == 0;
    } else {
        return false;
    }
}

function WGR_is_mobile(a) {
    if (screen.width < 775 || jQuery(window).width() < 775) {
        return true;
    }
    if (typeof a == "undefined" || a == "") {
        a = navigator.userAgent;
    }
    if (a.split("Mobile").length > 1 ||// Many mobile devices (all iPhone, iPad, etc.)
        a.split("Android").length > 1 || a.split("Silk/").length > 1 || a.split("Kindle").length > 1 || a.split("BlackBerry").length > 1 || a.split("Opera Mini").length > 1 || a.split("Opera Mobi").length > 1) {
        return true;
    }
    return false;
}

function get_term_permalink(data) {
    return web_link + data.term_permalink;
}

function create_menu_by_taxonomy(arr, li_class, show_favicon, ops) {
    if (arr.length <= 0) {
        console.log("create menu by taxonomy:", arr.length);
        return "";
    }
    console.log("create menu by taxonomy:", arr.length);
    if (typeof show_favicon == "undefined") {
        show_favicon = false;
    }
    if (typeof li_class == "undefined" || li_class == "") {
        li_class = "parent-menu";
    }
    if (typeof ops != "object") {
        ops = {};
    }
    var str = "";
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].count * 1 <= 0 || arr[i].term_status * 1 > 0) {
            continue;
        }
        if (typeof arr[i].term_shortname == "undefined" || arr[i].term_shortname == "") {
            arr[i].term_shortname = arr[i].name;
        }
        var img_favicon = "";
        if (show_favicon === true && typeof arr[i].term_favicon != "undefined" && arr[i].term_favicon != "") {
            var ops_width = "", ops_height = "";
            if (typeof ops.width != "undefined") {
                ops_width = ' width="' + ops.width + '"';
            }
            if (typeof ops.height != "undefined") {
                ops_height = ' height="' + ops.height + '"';
            }
            img_favicon = '<img src="' + arr[i].term_favicon + '"' + ops_width + ops_height + ' alt="' + arr[i].term_shortname + '"> ';
        }
        var sub_menu = "";
        if (typeof arr[i].child_term != "undefined" && arr[i].child_term.length > 0) {
            sub_menu = create_menu_by_taxonomy(arr[i].child_term, "childs-menu", show_favicon, ops);
            if (sub_menu != "") {
                sub_menu = '<ul class="sub-menu">' + sub_menu + "</ul>";
            }
        }
        str += '<li data-id="' + arr[i].term_id + '" class="' + li_class + '"><a href="' + get_term_permalink(arr[i]) + '" data-id="' + arr[i].term_id + '">' + img_favicon + arr[i].term_shortname + ' <span class="taxonomy-count">' + arr[i].count + "</span></a>" + sub_menu + "</li>";
    }
    return str;
}

function WGR_check_option_on(a) {
    if (a * 1 > 0) {
        return true;
    }
    return false;
}

function WGR_multi_vuejs(app_id, obj, _callBack, max_i) {
    app_id = app_id.split(",");
    for (var i = 0; i < app_id.length; i++) {
        app_id[i] = $.trim(app_id[i]);
        WGR_vuejs(app_id[i], obj, _callBack, max_i);
    }
}

function WGR_taxonomy_vuejs(app_id, obj, _callBack, max_i) {
    obj.action_taxonomy = 1;
    return WGR_vuejs(app_id, obj, _callBack, max_i);
}

function WGR_vuejs(app_id, obj, _callBack, max_i) {
    if (typeof max_i != "number") {
        max_i = 100;
    } else if (max_i < 0) {
        console.log("%c Max loaded Vuejs", "color: red");
        return false;
    }
    if (typeof Vue != "function") {
        setTimeout(function () {
            WGR_vuejs(app_id, obj, _callBack, max_i - 1);
        }, 100);
        return false;
    }
    if (typeof obj.action_taxonomy == "undefined") {
        obj.action_taxonomy = 0;
    }
    var tzoffset = new Date().getTimezoneOffset() * 60000; // offset in milliseconds
    obj.datetime = function (t, len) {
        if (typeof len != "number") {
            len = 19;
        }
        return new Date(t - tzoffset).toISOString().split(".")[0].replace("T", " ").substr(0, len);
    };
    obj.date = function (t) {
        return new Date(t - tzoffset).toISOString().split("T")[0];
    };
    obj.time = function (t, len) {
        if (typeof len != "number") {
            len = 8;
        }
        return new Date(t - tzoffset).toISOString().split(".")[0].split("T")[1].substr(0, len);
    };
    obj.number_format = function (n) {
        return new Intl.NumberFormat().format(n);
    };
    new Vue({
        el: app_id, data: obj, mounted: function () {
            $(app_id + ".ng-main-content, " + app_id + " .ng-main-content").addClass("loaded");
            if (typeof _callBack == "function") {
                _callBack();
            }
            action_each_to_taxonomy();
        },
    });
}

function move_custom_code_to() {
    $(".move-custom-code-to").each(function () {
        var data_to = $(this).attr("data-to") || "";
        if (data_to != "") {
            var str = $(this).html() || "";
            $(this).text("");
            var type_move = $(this).attr("data-type") || "";
            if (type_move == "before") {
                $(data_to).before(str);
            } else if (type_move == "after") {
                $(data_to).after(str);
            } else {
                $(data_to).append(str);
            }
            console.log("Move custom code to: " + data_to + " with type:", type_move);
        } else {
            console.log("%c move-custom-code-to[data-to] not found!", "color: darkviolet;");
        }
    }).addClass("move-custom-code-done").removeClass("move-custom-code-to");
}

function redirect_to_canonical(body_class) {
    if (body_class.split("page404").length > 1) {
        console.log("%c is 404 page!", "color: red;");
        return false;
    }
    var a = $('link[rel="canonical"]').attr("href") || "";
    if (a != "" && window.location.href.split(a).length === 1) {
        if (a.split("?").length > 1) {
            a += "&";
        } else {
            a += "?";
        }
        a += "canonical=client&uri=" + encodeURIComponent(window.location.href);
        window.location = a;
    }
}

function hide_if_esc() {
    if (top != self) {
        return top.hide_if_esc();
    }
    $(".hide-if-esc").hide();
    $("body").removeClass("no-scroll");
    return false;
}

function WGR_open_poup(str, tit, __callBack) {
    $("#popupModalLabel").html(tit);
    $("#popupModal .modal-body").html(str);
    if (typeof __callBack == "function") {
        __callBack();
    }
    $("#popupModal").modal("show");
}

function WGR_get_params(param) {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var a = urlParams.get(param);
    return a === null ? "" : a;
}

function jQueryAjaxError(jqXHR, textStatus, errorThrown, errorStack) {
    if (typeof errorStack != "undefined") {
        console.log(errorStack);
    }
    console.log(jqXHR);
    if (typeof jqXHR.responseText != "undefined") {
        console.log(jqXHR.responseText);
    }
    console.log(errorThrown);
    console.log(textStatus);
    if (textStatus === "timeout") {
    }
}