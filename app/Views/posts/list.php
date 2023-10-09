<link rel="stylesheet" type="text/css" media="all" href="./thirdparty/select2-4.0.13/css/select2.min.css"/>

<script src="./thirdparty/angular/angular.min.js"></script>
<script src="./thirdparty/vuejs/vue<?php echo($debug_enable !== true ? '.min' : ''); ?>.js"></script>
<script src="./thirdparty/select2-4.0.13/js/select2.min.js"></script>

<?php
use App\Libraries\PostType;
$base_model->add_css('admin/css/posts_list.css');
$base_model->add_css(  'themes/' . THEMENAME . '/css/post_list.css');
$base_model->add_css(  'themes/' . THEMENAME . '/css/users.css');
?>

    <div id="app" class="ng-main-content">
        <div class="row">
            <div class="col small-12 medium-2 large-2 global-profile-menu">
                <?php
                $menu_model->the_menu( 'user-profile-menu' );
                ?>
            </div>
            <div class="col-10">
                <h3 class="mb-2">Danh sách
                    <?php echo $name_type; ?> (<?php echo $totalThread; ?>)</h3>
                <div class="cf admin-search-form">
                    <div class="lf w-100">
                        <form name="frm_admin_search_controller" action="./<?php echo $controller_slug; ?>/lists" method="get">
                            <div class="cf">
                                <div class="lf f25 mr-3">
                                    <input class="form-control custom_element" name="s" value="<?php echo $by_keyword; ?>"
                                           placeholder="Tìm kiếm <?php echo $name_type; ?>" autofocus aria-required="true" >
                                </div>
                                <div class="lf f30 hide-if-no-taxonomy">
                                    <select name="term_id" data-select="<?php echo $by_term_id; ?>" :data-taxonomy="taxonomy"
                                            onChange="document.frm_admin_search_controller.submit();" class="each-to-group-taxonomy custom_element">
                                        <option value="0">- Danh mục
                                            <?php echo $name_type; ?> -
                                        </option>
                                    </select>
                                </div>
                                <div class="lf f25">
                                    <select class="custom_element" id="post_status" name="post_status" :data-select="post_status"
                                            onChange="document.frm_admin_search_controller.submit();">
                                        <option value="">- Trạng thái
                                            <?php echo $name_type; ?> -
                                        </option>
                                        <option :value="k" v-for="(v, k) in PostType_arrStatus">{{v}}</option>
                                    </select>
                                </div>
                                <div class="lf f20">
                                    <button type="submit" class="btn btn-success custom_element_small"><i class="fa fa-search"></i> Tìm kiếm</button>
                                </div>
                            </div>
                            <div class="cf mt-2">
                                <div class="lf f25 mr-3">
                                    <input autocomplete="off" title="Ngày duyệt từ" type="date" id="startDate" class="form-control custom_element  mb-0"
                                           name="start_date"
                                           placeholder="Ngày duyệt từ" value="<?= @$start_date ?>">
                                </div>
                                <div class="lf f30">
                                    <input autocomplete="off" title="Ngày duyệt đến" type="date" id="endDate" class="form-control  custom_element  mb-0"
                                           name="end_date"
                                           placeholder="Ngày duyệt đến" value="<?= @$end_date ?>">
                                </div>
                                <div class="lf f25">
                                    <select onChange="document.frm_admin_search_controller.submit();" class="form-control custom_element" id="salary_type" name="salary_type" :data-select="salary_type">
                                        <option value="">- Kiểu KPI
                                            -
                                        </option>
                                        <option :value="k" v-for="(v, k) in SALARY_TYPE">{{v}}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <?php

                if ($list_table_path != '') {
                    include ADMIN_ROOT_VIEWS . $list_table_path . '/list_table.php';
                }
                else {
                    include __DIR__ . '/list_table.php';
                }
                ?>
                <div class="public-part-page">
                    <?php echo $pagination; ?> Trên tổng số
                    <?php echo $totalThread; ?> bản ghi.
                </div>
            </div>
        </div>

    </div>

<?php
$base_model->adds_js([
    'admin/js/admin_functions.js',
    'admin/js/admin_functions2.js',
    'admin/js/admin_teamplate.js',
    'javascript/functions.js',
    'javascript/functions_footer.js',
    'themes/' . THEMENAME . '/js/functions.js',
    'javascript/eb.js'
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
    'draftStatus'=> PostType::DRAFT,
    'privateStatus'=> PostType::PRIVATELY,
]);
$base_model->JSON_parse(
    [
        'json_data' => $data,
        'PostType_arrStatus' => $post_arr_status,
        'UserType'=>\App\Libraries\UsersType::typeList(),
        'SALARY_TYPE' => SALARY_TYPE,
    ]
);
?>
    <script>
        WGR_vuejs('#app', {
            post_type: '<?php echo $post_type; ?>',
            currentPage : '<?php echo $currentPage ; ?>',
            post_per_page : '<?php echo $post_per_page; ?>',
            post_status: '<?php echo $post_status; ?>',
            salary_type: '<?php echo $salary_type; ?>',
            taxonomy: '<?php echo $taxonomy; ?>',
            controller_slug: '<?php echo $controller_slug; ?>',
            for_action: '<?php echo $for_action; ?>',
            PostType_DELETED: '<?php echo PostType::DELETED; ?>',
            PostType_arrStatus: PostType_arrStatus,
            draftStatus: draftStatus,
            SALARY_TYPE: SALARY_TYPE,
            privateStatus: privateStatus,
            data: json_data,
        });
    </script>
<?php
$base_model->add_js('admin/js/post_list.js');
$base_model->add_js('admin/js/' . $post_type . '.js');
