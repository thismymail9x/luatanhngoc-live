<?php

use App\Libraries\PostType;
use App\Libraries\UsersType;
//
$base_model->add_css(  'themes/' . THEMENAME . '/css/posts.css');
$base_model->add_css(  'themes/' . THEMENAME . '/css/post_list.css');
?>
<script src="<?php echo DYNAMIC_BASE_URL ?>thirdparty/tinymce/tinymce.min.js"></script>
<script src="<?php echo DYNAMIC_BASE_URL ?>thirdparty/select2-4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo DYNAMIC_BASE_URL ?>thirdparty/select2-4.0.13/css/select2.min.css"/>
<div class="w90">
    <div class="widget-box ng-main-content" id="myApp">
        <div class="row">
            <div class="col-2">
                <ul class="menuPost">
                    <li><a href="<?=base_url('/c/lists')?>"><i class="fa fa-list-ul" aria-hidden="true"></i> Danh sách</a></li>
                    <li><a href="<?=base_url('/c/user_add')?>"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a></li>
                    <li><a href="<?=base_url('/c/statistic')?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Thống kê</a></li>
                </ul>
            </div>
            <div class="col-10">
                <div class="widget-content nopadding">
                    <form action="" method="post" name="admin_global_form" id="admin_global_form"
                          onSubmit="return action_before_submit_post();" accept-charset="utf-8" class="form-horizontal"
                    >
                        <input type="hidden" name="is_duplicate" id="is_duplicate" value="0"/>
                        <input type="hidden" name="data[lang_key]" value="<?php echo $data['lang_key']; ?>"/>
                        <div class="control-group">
                            <label for="data_post_title" class="control-label">Tiêu đề:</label>
                            <div class="controls">
                                <input type="text" class="span6 required form-control" placeholder="Tiêu đề" name="data[post_title]"
                                       id="data_post_title" value="<?php $base_model->the_esc_html($data['post_title']); ?>"
                                       autofocus aria-required="true" required/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="data_post_title" class="control-label">Tiêu đề (ngắn): </label>
                            <div class="controls">
                                <input type="text" class="span6 required form-control" placeholder="Tiêu đề (ngắn)"
                                       name="data[post_shorttitle]" id="data_post_shorttitle"
                                       value="<?php $base_model->the_esc_html($data['post_shorttitle']); ?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="hidden" name="old_postname" id="old_postname"
                                       value="<?php echo $data['post_name']; ?>"/>
                                <?php
                                if ($data['ID'] > 0) {
                                    ?>
                                    <div>
                                        <a href="<?php $post_model->the_post_permalink($data); ?>"
                                           class="bluecolor set-new-url"><?php echo $data['post_permalink']; ?></a> <i
                                                class="fa fa-eye bluecolor"></i>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group control-group-post_content">
                            <label class="control-label">Nội dung</label>
                            <div class="controls ">
                        <textarea id="Resolution" rows="20"
                                  data-height="550"
                                  class="ckeditor auto-ckeditor" placeholder="Nhập thông tin chi tiết..."
                                  name="data[post_content]"><?php echo $data['post_content']; ?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Mô tả</label>
                            <div class="controls ">
                        <textarea rows="2"  placeholder="Tóm tắt" name="data[post_excerpt]" id="data_post_excerpt"
                                  class="span30 fix-textarea-height form-control"><?php echo $data['post_excerpt']; ?></textarea>
                                <div data-for="data_post_excerpt" class="cur bold click-enable-editer">
                                    <input type="checkbox"/> Sử dụng chế độ soạn thảo HTML cho phần tóm tắt.
                                </div>
                            </div>
                        </div>
                        <?php
                        foreach ($meta_detault as $k => $v) {
                            if ($k == 'post_category' && $taxonomy == '') {
                                continue;
                            } else if ($k == 'post_tags' && $tags == '') {
                                continue;
                            }
                            $input_type = PostType::meta_type($k, $meta_custom_type);
                            if ($input_type == 'hidden') {
                                ?>
                                <input type="hidden" name="post_meta[<?php echo $k; ?>]" id="post_meta_<?php echo $k; ?>"
                                       value="<?php $post_model->echo_esc_meta_post($data, $k); ?>"/>
                                <?php
                                continue;
                            }
                            if ($input_type == 'checkbox') {
                                ?>
                                <div class="control-group post_meta_<?php echo $k; ?>">
                                    <div class="controls controls-checkbox">
                                        <label for="post_meta_<?php echo $k; ?>">
                                            <input type="checkbox" name="post_meta[<?php echo $k; ?>]"
                                                   id="post_meta_<?php echo $k; ?>" value="on"
                                                   data-value="<?php $post_model->echo_meta_post($data, $k); ?>"/>
                                            <?php echo $v; ?>
                                        </label>
                                        <?php
                                        PostType::meta_desc($k, $meta_custom_desc);
                                        ?>
                                    </div>
                                </div>
                                <?php
                                continue;
                            } ?>
                            <div class="control-group post_meta_<?php echo $k; ?>">
                                <label for="post_meta_<?php echo $k; ?>" class="control-label">
                                    <?php echo $v; ?>
                                </label>
                                <div class="controls">
                                    <?php
                                    if ($k == 'post_category') {
                                        ?>
                                        <select class="form-select" data-select="<?php $post_model->echo_meta_post($data, $k); ?>"
                                                name="post_meta[<?php echo $k; ?>][]" id="post_meta_<?php echo $k; ?>" multiple>
                                            <option value="">[ Chọn <?php echo $v; ?> ]</option>
                                        </select>

                                        <?php
                                    } else if ($k == 'post_tags') {
                                        ?>
                                        <select class="form-select"  data-select="<?php $post_model->echo_meta_post($data, $k); ?>"
                                                name="post_meta[<?php echo $k; ?>][]" id="post_meta_<?php echo $k; ?>" multiple>
                                            <option value="">[ Chọn
                                                <?php echo $v; ?> ]
                                            </option>
                                        </select>
                                        <?php
                                    } else if ($input_type == 'textarea') {
                                        ?>
                                        <textarea placeholder="<?php echo $v; ?>" name="post_meta[<?php echo $k; ?>]"
                                                  id="post_meta_<?php echo $k; ?>"
                                                  class="f80 <?php echo PostType::meta_class($k); ?>"><?php $post_model->echo_meta_post($data, $k); ?></textarea>
                                        <?php
                                    } else if ($input_type == 'select' || $input_type == 'select_multiple') {
                                        $select_multiple = '';
                                        $meta_multiple = '';
                                        if ($input_type == 'select_multiple') {
                                            $select_multiple = 'multiple';
                                            $meta_multiple = '[]';
                                        }
                                        $select_options = PostType::meta_select($k);
                                        ?>
                                        <select class="form-select" data-select="<?php $post_model->echo_meta_post($data, $k); ?>"
                                                name="post_meta[<?php echo $k; ?>]<?php echo $meta_multiple; ?>"
                                                id="post_meta_<?php echo $k; ?>" <?php echo $select_multiple; ?>>
                                            <?php
                                            foreach ($select_options as $option_k => $option_v) {
                                                echo '<option value="' . $option_k . '">' . $option_v . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="<?php echo $input_type; ?>" class="span10 form-control" placeholder="<?php echo $v; ?>"
                                               name="post_meta[<?php echo $k; ?>]" id="post_meta_<?php echo $k; ?>"
                                               value="<?php $post_model->echo_esc_meta_post($data, $k); ?>"/>
                                        <?php
                                    }
                                    PostType::meta_desc($k, $meta_custom_desc);
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <p class="text-center mt-2">
                            <button class="btn btn-success" type="submit">Lưu</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <br>
</div>
<?php

$base_model->JSON_parse([
    'parent_post' => $parent_post,
    'post_arr_status' => $post_arr_status,
    'quick_menu_list' => $quick_menu_list,
//'prev_post' => $prev_post,
//'next_post' => $next_post,
    'post_pending' => PostType::PENDING
]);
$base_model->JSON_echo([
], [
    'controller_slug' => $controller_slug,
    'current_post_type' => $post_type,
    'page_post_type' => PostType::PAGE,
//'auto_update_module' => $auto_update_module,
//'url_next_post' => $url_next_post,
    'post_cat' => $post_cat,
    'post_tags' => $post_tags,
    'post_lang_key' => $data['lang_key'],
    'preview_url' => $preview_url,
    'preview_offset_top' => $preview_offset_top,
]);
$base_model->adds_js([
    'admin/js/admin_functions.js',
    'admin/js/admin_functions2.js',
    'admin/js/admin_teamplate.js',
    'javascript/functions.js',
    'javascript/functions_footer.js',
    'themes/' . THEMENAME . '/js/functions.js',
    'javascript/eb.js',
    'admin/js/preview_url.js',
    'admin/js/posts.js',
    'admin/js/posts_add.js',
    'admin/js/' . $post_type . '.js',
    'admin/js/' . $post_type . '_add.js',
]);

$base_model->adds_js([
    'admin/js/active-support-label.js',
]);

?>
