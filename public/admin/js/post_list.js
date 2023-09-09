// tạo select box các nhóm dữ liệu cho khung tìm kiếm
function each_to_group_taxonomy() {

    if ($(".each-to-group-taxonomy").length == 0) {
        return false;
    }
    //
    $(".each-to-group-taxonomy").each(function () {
        var a = $(this).attr("data-taxonomy") || "";
        var jd = $(this).attr("id") || "";
        if (jd == "") {
            jd = "_" + Math.random().toString(32).replace(".", "_");

            //
            $(this).attr({
                id: jd,
            });
        }
        //console.log(a);
        //console.log(jd);
        // chạy ajax nạp dữ liệu của taxonomy
        load_term_select_option(a, jd, function (data, jd) {
            //console.log(data);
            if (data.length > 0) {
                // tạo select
                $("#" + jd)
                    .removeClass("set-selected")
                    .append(create_term_select_option(data));

                // xóa các option không có count -> đỡ phải lọc
                $("#" + jd + " option[data-count='0']").remove();
                // tạo lại selected
                WGR_set_prop_for_select("#" + jd);
                MY_select2("#" + jd);
            } else {
                $("#" + jd)
                    .parent(".hide-if-no-taxonomy")
                    .hide();
            }
        });
    });
}

//
$(document).ready(function () {

    //
    each_to_group_taxonomy();

    // thay đổi số thứ tự của post
    $(".change-update-menu_order")
        .attr({
            type: "number",
        })
        .on("dblclick", function () {
            $(this).select();
        })
        .change(function () {
            var a = $(this).attr("data-id") || "";
            if (a != "") {
                var v = $(this).val();
                v *= 1;
                if (!isNaN(v)) {
                    if (v <= 0) {
                        v = 0;
                    }
                    //console.log(a + ":", v);

                    //
                    $(this).addClass("pending").val(v);

                    //
                    jQuery.ajax({
                        type: "POST",
                        url: "admin/asjaxs/update_menu_order",
                        dataType: "json",
                        data: {
                            id: a * 1,
                            order: v,
                        },
                        timeout: 33 * 1000,
                        error: function (jqXHR, textStatus, errorThrown) {
                            jQueryAjaxError(
                                jqXHR,
                                textStatus,
                                errorThrown,
                                new Error().stack
                            );
                        },
                        success: function (data) {
                            console.log(data);
                            if (typeof data.error != "undefined") {
                                WGR_alert(data.error, "error");
                            } else {
                                WGR_alert("OK");
                            }
                            $(".change-update-menu_order").removeClass("pending");
                        },
                    });
                }
            }
        });
    /* hàm duyệt bài viết*/
    $(".changePostStatus").click(function () {
        var a = $(this).attr("data-id") || "";
        var post = $(this).attr("data-title") || "";
            if (confirm('Xác nhận duyệt bài viết: '+ post)){
                if (a != "") {
                    var v = $(this).val();

                    //console.log(a + ":", v);

                    //
                    $(this).addClass("pending").val(v);

                    //
                    jQuery.ajax({
                        type: "POST",
                        url: "admin/asjaxs/post_success",
                        dataType: "json",
                        data: {
                            id: a * 1,
                        },
                        timeout: 33 * 1000,
                        error: function (jqXHR, textStatus, errorThrown) {
                            jQueryAjaxError(
                                jqXHR,
                                textStatus,
                                errorThrown,
                                new Error().stack
                            );
                        },
                        success: function (data) {
                            if (typeof data.error != "undefined") {
                                WGR_alert(data.error, "error");
                            } else {
                                WGR_alert("Duyệt bài viết thành công");
                                $('.changePostStatus_'+ a).hide();
                                $('.post_'+a).text(PostType_arrStatus[PostType_PUBLIC])
                            }
                            $(".changePostStatus").removeClass("pending");
                        },
                    });

                }
            }

    });
    /* hàm check các thông số bài viết tự động*/
    $(".checkPostInformation").click(function () {
        alert('Đang phát triển')
        var a = $(this).attr("data-id") || "";
        var post = $(this).attr("data-title") || "";
        if (a != "") {
                var v = $(this).val();

                //console.log(a + ":", v);

                //
                $(this).addClass("pending").val(v);

                //
                jQuery.ajax({
                    type: "POST",
                    url: "admin/asjaxs/post_success",
                    dataType: "json",
                    data: {
                        id: a * 1,
                    },
                    timeout: 33 * 1000,
                    error: function (jqXHR, textStatus, errorThrown) {
                        jQueryAjaxError(
                            jqXHR,
                            textStatus,
                            errorThrown,
                            new Error().stack
                        );
                    },
                    success: function (data) {
                        if (typeof data.error != "undefined") {
                            WGR_alert(data.error, "error");
                        } else {
                            WGR_alert("Duyệt bài viết thành công");
                            $('.changePostStatus_'+ a).hide();
                            $('.post_'+a).text(PostType_arrStatus[PostType_PUBLIC])
                        }
                        $(".changePostStatus").removeClass("pending");
                    },
                });

            }
    });
    // modal tạo note của admin
    $('#noteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var post_id = button.data('id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        $.ajax({
            url: 'admin/asjaxs/get_post_comments',
            type: "POST",
            dataType: "json",
            data: {
                id: post_id,
            },
            timeout: 33 * 1000,
            error: function (jqXHR, textStatus, errorThrown) {
                jQueryAjaxError(
                    jqXHR,
                    textStatus,
                    errorThrown,
                    new Error().stack
                );
            },
            success: function (data) {
                if (typeof data.error != "undefined") {
                    WGR_alert(data.error, "error");
                } else {
                    var listNote = data.data;
                    var html = "<table class='table table-sm table-info'><tr><th width='20%'>Người tạo</th><th width='60%'>Nội dung</th><th width='20%'>Thời gian</th></tr>";
                    for (var i = 0; i < listNote.length; i++) {
                        html += '<tr><td><sup>'+UserType[listNote[i].member_type]+'</sup> ' + listNote[i].user_nicename + '</td>';
                        html += '<td>' + listNote[i].comment_content + '</td>';
                        html += '<td>' + listNote[i].comment_date + '</td></tr>';
                    }
                    html += '</table>';
                    $('.list__note').empty().html(html);
                }
            },
        });
        var modal = $(this)
        modal.find('.modal-title').text('Viết chú ý cho bài viết: ' + recipient);
        modal.find('.input_post_id').val(post_id);
        modal.find('#message-note').val('');
    })
    // modal nhận note của nhan vien
    // thao tac lưu note của admin
    $('.saveNote').on('click', function () {
        var post_id = $('.input_post_id').val();
        var content = $('#message-note').val();
        if (content !='') {
            $.ajax({
                url: 'admin/asjaxs/save_post_comment',
                type: "POST",
                dataType: "json",
                data: {
                    id: post_id,
                    content: content,
                },
                timeout: 33 * 1000,
                error: function (jqXHR, textStatus, errorThrown) {
                    jQueryAjaxError(
                        jqXHR,
                        textStatus,
                        errorThrown,
                        new Error().stack
                    );
                },
                success: function (data) {
                    if (typeof data.error != "undefined") {
                        WGR_alert(data.error, "error");
                    } else {
                        WGR_alert("Thành công");
                        var listNote = data.data;

                        var html = "<table class='table table-sm table-info'><tr><th width='20%'>Người tạo</th><th width='60%'>Nội dung</th><th width='20%'>Thời gian</th></tr>";
                        for (var i = 0; i < listNote.length; i++) {
                            html += '<tr><td><sup>'+UserType[listNote[i].member_type]+'</sup> ' + listNote[i].user_nicename + '</td>';
                            html += '<td>' + listNote[i].comment_content + '</td>';
                            html += '<td>' + listNote[i].comment_date + '</td></tr>';
                        }
                        html += '</table>';
                        $('.list__note').html(html);

                    }
                },

            });
        } else  {
            WGR_alert('Nhập nội dung ghi chú!', "error");
        }

    })

});

