<?php

use App\Libraries\PostType;

$base_model->add_css('admin/css/posts_list.css');
$base_model->add_css('admin/css/' . $post_type . '.css');
?>
    <ul class="admin-breadcrumb">
        <li>Danh sách
            <?php echo $name_type; ?> (
            <?php echo $totalThread; ?>)
        </li>
    </ul>
    <div id="app" class="ng-main-content">
        <div class="cf admin-search-form">
            <div class="lf f62">
                <form name="frm_admin_search_controller" action="./admin/<?php echo $controller_slug; ?>" method="get">
                    <div class="cf">
                        <div class="lf f25">
                            <input name="s" value="<?php echo $by_keyword; ?>"
                                   placeholder="Tìm kiếm <?php echo $name_type; ?>" autofocus aria-required="true"
                                   >
                        </div>
                        <div class="lf f25 hide-if-no-taxonomy">
                            <select name="term_id" data-select="<?php echo $by_term_id; ?>" :data-taxonomy="taxonomy"
                                    onChange="document.frm_admin_search_controller.submit();"
                                    class="each-to-group-taxonomy">
                                <option value="0">- Danh mục
                                    <?php echo $name_type; ?> -
                                </option>
                            </select>
                        </div>
                        <div class="lf f20">
                            <select name="post_status" :data-select="post_status"
                                    onChange="document.frm_admin_search_controller.submit();">
                                <option value="">- Trạng thái
                                    <?php echo $name_type; ?> -
                                </option>
                                <option :value="k" v-for="(v, k) in PostType_arrStatus">{{v}}</option>
                            </select>
                        </div>
                        <div class="lf f20">
                            <select name="post_author" :data-select="post_author"
                                    onChange="document.frm_admin_search_controller.submit();">
                                <option value="">- Tác giả
                                    -
                                </option>
                                <option :value="v.ID" v-for="(v, k) in authors">{{v.user_nicename}}</option>
                            </select>
                        </div>
                        <div class="lf f10">
                            <button type="submit" class="btn-success"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
                    </div>
                    <div class="cf">
                        <div class="lf f25">
                            <input autocomplete="off" type="date" id="startDate" class="form-control mb-0"
                                   name="start_date"
                                   placeholder="Ngày duyệt từ" value="<?= @$start_date ?>">
                        </div>
                        <div class="lf f25">
                            <input autocomplete="off" type="date" id="endDate" class="form-control mb-0"
                                   name="end_date"
                                   placeholder="Ngày duyệt đến" value="<?= @$end_date ?>">
                        </div>
                        <div class="lf f20">
                            <select name="salary_type" :data-select="salary_type"
                                    onChange="document.frm_admin_search_controller.submit();">
                                <option value="">- Kiểu KPI
                                    -
                                </option>
                                <option :value="k" v-for="(v, k) in SALARY_TYPE">{{v}}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="lf f38 text-right">
                <?php
                include ADMIN_ROOT_VIEWS . 'posts/list_right_button.php';
                ?>
            </div>
        </div>
        <br>
        <?php
        include ADMIN_ROOT_VIEWS . 'posts/list_select_all.php';
        if ($list_table_path != '') {
            include ADMIN_ROOT_VIEWS . $list_table_path . '/list_table.php';
        } else {
            include __DIR__ . '/list_table.php';
        }
        ?>
    </div>
    <div class="public-part-page">
        <?php echo $pagination; ?> Trên tổng số
        <?php echo $totalThread; ?> bản ghi.
    </div>
<?php
$base_model->JSON_parse(
    [
        'json_data' => $data,
        'PostType_arrStatus' => $post_arr_status,
        'authors' => $authors,
        'PostType_PUBLIC' => PostType::PUBLICITY,
        'SALARY_TYPE' => SALARY_TYPE,
        'UserType' => \App\Libraries\UsersType::typeList()
    ]
);
?>
    <script>
        WGR_vuejs('#app', {
            allow_mysql_delete: allow_mysql_delete,
            post_type: '<?php echo $post_type; ?>',
            post_status: '<?php echo $post_status; ?>',
            salary_type: '<?php echo $salary_type; ?>',
            post_author: '<?php echo $post_author; ?>',
            taxonomy: '<?php echo $taxonomy; ?>',
            controller_slug: '<?php echo $controller_slug; ?>',
            for_action: '<?php echo $for_action; ?>',
            PostType_DELETED: '<?php echo PostType::DELETED; ?>',
            PostType_PUBLIC: '<?php echo PostType::PUBLICITY; ?>',
            PostType_PENDING: '<?php echo PostType::PENDING; ?>',
            session_data: '<?php echo $session_data['member_type']; ?>',
            ADMIN_ROLE: '<?php echo \App\Libraries\UsersType::ADMIN ?>',
            SALARY_TYPE: SALARY_TYPE,
            PostType_arrStatus: PostType_arrStatus,
            authors: authors,
            data: json_data,
        });
    </script>
<?php
include ADMIN_ROOT_VIEWS . 'posts/sync_modal.php';
$base_model->add_js('admin/js/post_list.js');
$base_model->add_js('admin/js/' . $post_type . '.js');