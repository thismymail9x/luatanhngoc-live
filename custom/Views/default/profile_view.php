<?php
$base_model->add_css(  'themes/' . THEMENAME . '/css/author.css');
?>
<script src="<?php echo DYNAMIC_BASE_URL ?>thirdparty/tinymce/tinymce.min.js"></script>

<div id="loginbox" class="s14 global-profile_view">
    <div class="user-info_form">
        <form name="profile_form" class="form-vertical" accept-charset="utf-8" action="" method="post" target="target_eb_iframe" enctype="multipart/form-data">
            <?php $base_model->csrf_field(); ?>
            <div class="control-group normal_text">
                <h3 class="title-box-category">
                    <?php echo $seo['title']; ?>
                </h3>
            </div>
            <br>
            <div class="s14 main-profile">
                <div id="data-user_email">
                    <div class="row change-user_email">
                        <div class="col small-12 medium-4 large-4 bold">Email</div>
                        <div class="col small-12 medium-8 large-8">
                            <?php echo $data['user_email']; ?> - <em class="cur bluecolor click-change-email">Thay đổi
                                email <i class="fa fa-edit"></i></em>
                        </div>
                    </div>
                    <div class="row changed-user_email d-none">
                        <div class="col small-12 medium-4 large-4 l40 bold">Email (bắt buộc)</div>
                        <div class="col small-12 medium-8 large-8">
                            <div class="form-control">
                                <input type="email" placeholder="Email" name="data[user_email]" id="data_user_email" value="<?php echo $data['user_email']; ?>" disabled readonly aria-required="true" required>
                            </div>
                            <div class="top-menu-space10">Nếu bạn thay đổi email, chúng tôi sẽ gửi một email xác nhận
                                đến địa chỉ email cũ. <strong>Email mới sẽ không được kích hoạt cho đến khi bạn xác nhận
                                    thay đổi</strong> - <em class="cur bluecolor cancel-change-email">Hủy bỏ <i class="fa fa-remove"></i></em></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 bold">Tài khoản</div>
                    <div class="col small-12 medium-8 large-8">
                        <?php
                        echo $data['user_login'];


                        // chức năng riêng dành cho admin
                        if (isset($session_data['userLevel']) && $session_data['userLevel'] > 0) {
                        ?>
                            <a href="./<?php echo CUSTOM_ADMIN_URI; ?>">@</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 bold">Về tác giả</div>
                    <div class="col small-12 medium-8 large-8">
                        <textarea id="profileUser" class="ckeditor auto-ckeditor" name="user_meta[description]" cols="30" rows="10"><?php echo $data['description']; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 l40 bold">Ảnh đại diện</div>
                    <div class="col small-12 medium-8 large-8">
                        <label data-updating="1" for="file-input-media" id="click-chose-media"> <img src="images/_blank.png" height="150" width="50%" <?php if ($data['avatar'] != '') { ?>style="background-image: url(
                            <?php echo $data['avatar']; ?>);" <?php
                                                                                                                                            }
                                                                ?> />
                            <input id="file-input-media" accept="image/*" type="file" class="cur" />
                            <input type="hidden" name="data[avatar]" id="file-input-avatar" value="<?php echo $data['avatar']; ?>" />
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 l40 bold">Họ và Tên đệm</div>
                    <div class="col small-12 medium-8 large-8">
                        <div class="form-control">
                            <input type="text" placeholder="Họ và Tên đệm" name="data[display_name]" id="data_display_name" value="<?php echo $data['display_name']; ?>" aria-required="true" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 l40 bold">Tên gọi</div>
                    <div class="col small-12 medium-8 large-8">
                        <div class="form-control">
                            <input type="text" placeholder="Tên gọi" name="data[user_nicename]" id="data_user_nicename" value="<?php echo $data['user_nicename']; ?>" aria-required="true" required>
                        </div>
                    </div>
                </div>
                <div class="row data-user_birthday">
                    <div class="col small-12 medium-4 large-4 l40 bold">Ngày sinh</div>
                    <div class="col small-12 medium-8 large-8">
                        <div class="form-control">
                            <input type="date" placeholder="Ngày sinh" name="data[user_birthday]" value="<?php echo $data['user_birthday']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row data-user_phone">
                    <div class="col small-12 medium-4 large-4 l40 bold">Điện thoại liên hệ</div>
                    <div class="col small-12 medium-8 large-8">
                        <div class="form-control">
                            <input type="text" placeholder="Điện thoại liên hệ" name="data[user_phone]" value="<?php echo $data['user_phone']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 l40 hide-if-mobile"></div>
                    <div class="col small-12 medium-8 large-8 form-actions ">
                        <button type="submit" class="btn btn-success fz-14"><i class="fa fa-save"></i> Cập nhật thông tin cá
                            nhân</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <hr />
    <div class="user-pasword_form">
        <form name="pasword_form" class="form-vertical" accept-charset="utf-8" action="" method="post" target="target_eb_iframe">
            <?php $base_model->csrf_field(); ?>
            <div class="control-group normal_text">
                <h3 class="title-box-category">Đổi mật khẩu đăng nhập</h3>
            </div>
            <br>
            <div class="s14">
                <div class="row">
                    <div class="col small-12 medium-4 large-4 l40 bold">Thay đổi mật khẩu</div>
                    <div class="col small-12 medium-8 large-8">
                        <div class="form-control">
                            <input type="text" placeholder="Thay đổi mật khẩu" name="data[ci_pass]" id="data_ci_pass" value="" onfocus="$('.redcolor-if-pass-focus').addClass('redcolor');" onblur="$('.redcolor-if-pass-focus').removeClass('redcolor');" aria-required="true" required autocomplete="off">
                        </div>
                        <span class="redcolor-if-pass-focus">* <em>Chỉ nhập mật khẩu khi bạn cần đổi mật khẩu đăng
                                nhập</em>.</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col small-12 medium-4 large-4 l40 hide-if-mobile"></div>
                    <div class="col small-12 medium-8 large-8 form-actions fz-14">
                        <button type="submit" class="btn btn-success"><i class="fa fa-key"></i> Thay đổi mật khẩu</button>
                    </div>
                </div>
            </div>

        </form>
        <hr />
    </div>
    <div>
        <div class="row">
            <div class="col small-12 medium-4 large-4 bold">Ngày đăng ký</div>
            <div class="col small-12 medium-8 large-8">
                <?php echo $data['user_registered']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col small-12 medium-4 large-4 bold">Đăng nhập cuối</div>
            <div class="col small-12 medium-8 large-8">
                <?php echo $data['last_login']; ?> (<?php echo $data['login_type']; ?>)
            </div>
        </div>
        <div class="row">
            <div class="col small-12 medium-4 large-4 bold">Cập nhật cuối</div>
            <div class="col small-12 medium-8 large-8">
                <?php echo $data['last_updated']; ?>
            </div>
        </div>
    </div>
</div>
<br>
<script>
    // load editor cho description
    WGR_load_tinyediter('#profileUser',{
        height:200,
        // plugins:['emoticons'],
        toolbar: [
            "undo redo bold italic underline"
        ]
    });
    // tạo tinymce cho bình luận
    function WGR_load_tinyediter(for_id, ops) {
        if (typeof ops == "undefined") {
            ops = {};
        }
        if (typeof ops["height"] == "undefined") {
            ops["height"] = 250;
        }
        if (typeof ops["plugins"] == "undefined") {
            ops["plugins"] = [
                "textcolor colorpicker",
                "print preview paste importcss searchreplace directionality",
                "code visualblocks visualchars fullscreen image link media template codesample table hr",
                "pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern",
                "noneditable help charmap emoticons",
            ];
        }
        if (typeof ops["toolbar"] == "undefined") {
            var arr_toolbar = [
                "undo redo",
                "bold italic underline strikethrough",
                "fontselect fontsizeselect formatselect",
                //'sub sup',
                "alignleft aligncenter alignright alignjustify",
                //'justifyleft justifycenter justifyright justifyfull',
                "forecolor backcolor",
                "bullist numlist outdent indent",
                "image media",
                "link table",
                //'insertdate inserttime',
                //'showcomments addcomment',
                "preview removeformat fullscreen code",
                "help",
            ];
            ops["toolbar"] = arr_toolbar.join(" | ");
        }
        // console.log(ops,'ccc');

        //
        tinymce.init({
            selector: "textarea" + for_id,
            height: ops["height"],
            placeholder: 'Chia sẻ ý kiến của bạn',
            plugins: ops["plugins"],
            toolbar: ops["toolbar"],
            menubar:false,
            statusbar: true,
        });
    }

</script>
