<?php
if ($session_data['member_type'] != $is_admin) {

    foreach ($arr_admin_menu as $k => $v) {
        if (!isset($v['role'])) {
            echo '<!-- Admin role not found! -->';
            $arr_admin_menu[$k] = null;
            continue;
        }
        if (!empty($v['role']) && !in_array($session_data['member_type'], $v['role'])) {
            echo '<!-- Permission deny! -->';
            $arr_admin_menu[$k] = null;
            continue;
        }
        // duyệt với từng phần tử cụ thể
        foreach ($v['arr'] as $k_sub => $v_sub) {
            if (
                isset($v_sub['role']) &&
                !empty($v_sub['role']) &&
                !in_array($session_data['member_type'], $v_sub['role'])
            ) {
                echo '<!-- Permission sub deny! -->';
                $v['arr'][$k_sub] = null;
                $arr_admin_menu[$k] = $v;
                continue;
            }
        }
    }
}
//print_r($arr_admin_menu);
//die('xx');
if ($debug_enable === true) {
    $body_class .= ' body-debug_enable';
}
?>
<!DOCTYPE html>
<html lang="<?php
echo(($html_lang == 'vn' || $html_lang == '') ? 'vi' : $html_lang);
?>" data-lang="<?php echo $html_lang; ?>" data-default-lang="<?php echo SITE_LANGUAGE_DEFAULT; ?>">
<head>
    <title>Quản trị</title>
    <meta charset="UTF-8"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <base href="<?php echo DYNAMIC_BASE_URL; ?>"/>
    <link href="<?php echo DYNAMIC_BASE_URL; ?>favicon.png" rel="shortcut icon" type="image/png"/>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/bootstrap-old/bootstrap.min-old.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/bootstrap-old/bootstrap-responsive.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/select2-4.0.13/css/select2.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="css/my-bootstrap.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="admin/css/fullcalendar.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="admin/css/maruti-style.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="admin/css/tagify.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="admin/css/base.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="admin/css/maruti-media.css" class="skin-color"/>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/awesome47/css/font-awesome.before.css?v=4.7"/>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/awesome47/css/font-awesome.min.css?v=4.7"/>
    <!--
    <link rel="stylesheet" type="text/css" media="all" href="fonts/fontawesome-free-5.15.1-web/css/fontawesome.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="fonts/fontawesome-free-5.15.1-web/css/brands.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="fonts/fontawesome-free-5.15.1-web/css/solid.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="fonts/fontawesome-free-5.15.1-web/css/v4-shims.min.css" />
    -->
    <script src="./thirdparty/jquery/jquery-3.6.1.min.js"></script>
    <script src="./thirdparty/validate/library.js"></script>
    <script src="./thirdparty/validate/jquery.validate.min.js"></script>
    <script src="./thirdparty/validate/localization/messages_vi.js"></script>
    <script src="./thirdparty/tinymce/tinymce.min.js?v=4.9.11"></script>
    <script src="./thirdparty/jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="./thirdparty/jquery-ui/jquery-ui.min.css"/>
    <script src="./thirdparty/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./thirdparty/angular/angular.min.js"></script>
    <script src="./thirdparty/vuejs/vue<?php echo($debug_enable !== true ? '.min' : ''); ?>.js"></script>
    <script src="./thirdparty/select2-4.0.13/js/select2.min.js"></script>
    <?php
    $base_model->adds_css([
        'css/flatsome-for-bootstrap.css',
        'css/d.css',
        'admin/css/admin_teamplate.css',
        'admin/css/show-debug-bar.css',
    ]);
    $base_model->adds_js([
        'admin/js/admin_functions.js',
        'admin/js/admin_functions2.js',
        'admin/js/admin_teamplate.js',
        'javascript/functions.js',
        'javascript/functions_footer.js',
        'themes/' . THEMENAME . '/js/functions.js',
        'javascript/eb.js'
    ]);
    $base_model->JSON_parse([
        'is_admin' => 1,
        'arr_admin_menu' => $arr_admin_menu,
        'arr_lang_list' => $arr_lang_list,
    ]);
    $base_model->JSON_echo([
        'allow_mysql_delete' => ALLOW_USING_MYSQL_DELETE ? 'true' : 'false',
    ], [
    ]);
    $WGR_config = [
        'cf_tester_mode' => ($debug_enable === true) ? 1 : 0,
        'current_user_id' => $current_user_id * 1,
    ];
    $base_model->JSON_parse([
        'WGR_config' => $WGR_config,
    ]);
    ?>
    <script>
        var web_link = window.location.protocol + '//' + document.domain + '/';
        var admin_link = web_link + '<?php echo CUSTOM_ADMIN_URI; ?>';
    </script>
</head>
<body class="is-admin <?php echo $body_class; ?>">
<div id="admin-header" class="cf whitecolor awhitecolor">
    <div class="lf f50">
        <?php if ($session_data['member_type'] == \App\Libraries\UsersType::ADMIN) { ?>
            <div class="d-inline"><a href="./<?php echo CUSTOM_ADMIN_URI; ?>"><i
                            class="fa fa-cog"></i> <?php $lang_model->the_text('admin_quan_tri_he_thong', 'Quản trị hệ thống'); ?>
                </a></div>
            &nbsp; | &nbsp;
        <?php } ?>
        <div class="d-inline"><a href="./"><i
                        class="fa fa-home"></i> <?php $lang_model->the_text('admin_ve_trang_chu', 'Về trang chủ'); ?>
            </a></div>
        &nbsp; | &nbsp;
        <div class="d-inline"><?php $lang_model->the_text('admin_ngon_ngu', 'Ngôn ngữ'); ?>:
            <select data-select="<?php echo $html_lang; ?>" id="admin-change-language">
            </select>
        </div>
    </div>
    <div class="lf f20">
        <div class="admin-menu-search text-center">
            <input type="search" id="admin_menu_search"
                   placeholder="Search in admin menu. Ex: post, product, setting, config, user..."/>
        </div>
        <div class="admin-menu-result">
            <div class="admin-menu-padding">
                <div class="admin-menu-header">View search result menu for "<strong class="admin-menu-key"></strong>"
                </div>
                <div id="admin_menu_result"></div>
                <div class="admin-menu-none">No result for "<strong class="admin-menu-key"></strong>"</div>
            </div>
        </div>
    </div>
    <div class="lf f30 text-right"><?php $lang_model->the_text('admin_xin_chao', 'Xin chào'); ?>: <a
                title="<?php $lang_model->the_text('admin_thong_tin_ca_nhan', 'Thông tin cá nhân'); ?>"
                href="./users/profile">
            <?php
            echo($session_data['display_name'] != '' ? $session_data['display_name'] : $session_data['user_login']);
            ?>
        </a> &nbsp; | &nbsp; <a title="<?php $lang_model->the_text('admin_dang_xuat', 'Đăng xuất'); ?>"
                                data-bs-toggle="modal" data-bs-target="#logoutModal" href="javascript:;"><i
                    class="fa fa-sign-out"></i> <?php $lang_model->the_text('admin_dang_xuat', 'Đăng xuất'); ?></a>
    </div>
</div>
<div id="adminmenumain">
    <div id="sidebar">
        <ul class="cf order-admin-menu">
        </ul>
    </div>
</div>
<div class="preview-btn">
    <a href="#" title="Quay lại trang chính" class="btn btn-primary back-preview-mode"><i class="fa fa-arrow-left"></i></a>
    <button type="button" title="Mở rộng sang 2 bên" onclick="return expand_preview_mode();" class="btn btn-success"><i
                class="fa fa-arrows-h"></i></button>
    <button type="button" title="Tắt chế độ Preview" onclick="return close_preview_mode();" class="btn btn-danger"><i
                class="fa fa-arrows"></i></button>
</div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <ul class="cf">
                <li><a href="./" title="Go to Home" class="tip-bottom"> <i class="fa fa-home"></i> Trang chủ</a>
                </li>
                <li><a href="./<?php echo CUSTOM_ADMIN_URI; ?>" title="Go to Home" class="tip-bottom"> <i
                                class="fa fa-cog"></i> Quản trị</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php

            include dirname(__DIR__) . '/includes/msg_view.php';
            ?>
            <div id="for_vue">
                <?php
                echo $content;
                ?>
            </div>
        </div>
    </div>
</div>
<div class="text-center admin-copyright">&copy;
    <?php echo date('Y'); ?> <a href="<?php echo PARTNER_WEBSITE; ?>" target="_blank" rel="nofollow">
        <?php echo PARTNER_BRAND_NAME; ?>
    </a> - All rights reserved. Code using framework <a href="https://codeigniter.com/" target="_blank" rel="nofollow">Codeigniter
        <?php echo \CodeIgniter\CodeIgniter::CI_VERSION; ?>
    </a> - <span class="cur" onClick="$('#target_eb_iframe').addClass('show-target-eb');">Show process</span>
</div>
<?php
$base_model->adds_js([
    'admin/js/admin_footer.js',
    'admin/js/active-support-label.js',
    'javascript/datetimepicker.js',
    'javascript/pagination.js',
]);
?>
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Đăng xuất</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Xác nhận đăng xuất khỏi hệ thống...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="./users/logout" class="d-inline btn btn-primary"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>
    </div>
</div>
<iframe id="target_eb_iframe" name="target_eb_iframe" title="EB iframe" src="about:blank" width="99%" height="550"
        frameborder="0">AJAX form
</iframe>
</body>
</html>
