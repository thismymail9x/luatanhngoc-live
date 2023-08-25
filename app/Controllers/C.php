<?php

namespace App\Controllers;

// Libraries
use App\Libraries\LanguageCost;
use App\Libraries\PostType;
use App\Libraries\TaxonomyType;

//
class C extends Home
{
    // các thuộc tính viết bài
    protected $table = 'posts';
    protected $metaTable = 'postmeta';
    protected $taxonomy = TaxonomyType::POSTS;
    protected $tags = TaxonomyType::TAGS;
    protected $post_type = '';
    protected $name_type = '';
    protected $post_arr_status = [];
    protected $controller_slug = 'c';
    public function __construct()
    {
        parent::__construct();
        // hỗ trợ lấy theo params truyền vào từ url
        if ($this->post_type == '') {
            $this->post_type = $this->MY_get('post_type', PostType::POST);
        }
        $this->name_type = PostType::typeList($this->post_type);

        // báo lỗi nếu không xác định được post_type
        //if ( $this->post_type == '' || $this->name_type == '' ) {
        if ($this->name_type == '') {
            die('Post type not register in system: ' . $this->post_type);
        }
        //
        $this->post_arr_status = PostType::arrStatus();
        //print_r( $this->post_arr_status );

        // chỉnh lại bảng select của model
        $this->post_model->table = $this->table;
        $this->post_model->metaTable = $this->metaTable;
    }

    public function custom_taxonomy($taxonomy_type, $id, $slug = '', $page_name = '', $page_num = 1)
    {
        // chỉ kiểm tra custom taxonomy
        if (!in_array($taxonomy_type, [
            TaxonomyType::TAGS,
            //TaxonomyType::OPTIONS,
            TaxonomyType::PROD_OTPS,
            //TaxonomyType::BLOG_TAGS,
            TaxonomyType::PROD_TAGS,
        ])) {
            global $arr_custom_taxonomy;
            //print_r($arr_custom_taxonomy);

            //echo $taxonomy_type . '<br>' . PHP_EOL;
            //echo $id . '<br>' . PHP_EOL;
            //echo $slug . '<br>' . PHP_EOL;
            //echo $page_num . '<br>' . PHP_EOL;

            // với custom taxonomy -> kiểm tra xem taxonomy này phải được đăng ký thì mới hiển thị ra
            if (!isset($arr_custom_taxonomy[$taxonomy_type])) {
                return $this->page404('ERROR ' . strtolower(__FUNCTION__) . ':' . __LINE__ . '! Danh mục này chưa được đăng ký hiển thị...');
            }
            // hoặc custom taxonomy có đăng ký nhưng không hiển thị với người khác ngoại trừ admin
            else if (isset($arr_custom_taxonomy[$taxonomy_type]['public']) && $arr_custom_taxonomy[$taxonomy_type]['public'] != 'on') {
                return $this->page404('ERROR ' . strtolower(__FUNCTION__) . ':' . __LINE__ . '! Bạn không được phép xem thông tin danh mục này...');
            }
        }

        //
        return $this->showCategory($id, $taxonomy_type, $page_num, $slug);
    }

    /**
     *
     */
    public function user_add()
    {
        $id = $this->MY_get('id', 0);
        $postController = new \App\Controllers\Admin\Posts();
        //
        $file_view = 'add';

        // edit
        $url_next_post = '';
        $prev_post = [];
        $next_post = [];
        if ($id > 0) {
            // select dữ liệu từ 1 bảng bất kỳ
            $data = $this->post_model->select_post($id, [
                'post_type' => $this->post_type,
                //'lang_key' => $this->lang_key,
            ]);
            if (empty($data)) {
                die('Dữ liệu không tồn tại');
            }
        }
        // add
        else {
            $data = $this->base_model->default_data($this->table);
            $data['post_meta'] = [];
        }
        $post_tags = '';
        $parent_post = [];
        // lấy danh sách các trang để chọn bài cha
        $post_cat = $this->taxonomy;
        if ($this->tags != '') {
            //$post_tags = $this->term_model->get_all_taxonomy( $this->tags, 0, [ 'get_child' => 1 ], $this->tags . '_get_child' );
            $post_tags = $this->tags;
        }

        //
        if ($this->debug_enable === true) {
            echo '<!-- ';
            print_r($data);
            echo ' -->';
        }

        //
        //echo ADMIN_ROOT_VIEWS;

        // tạo dữ liệu danh mục của bài viết mục đích dùng để tạo menu
        $contentAction = $data['post_content'];
//        $resultCategory = $this->createCategoryArray($contentAction);
//        $data['post_content'] = $resultCategory['post_content'];
        // dùng để foreah ra danh mục của bài viết
//        $data['content_category'] = $resultCategory['category_array'];
        // đổi nội dung bài viết = các key có sẵn
        foreach (REPLACE_CONTENT as $k => $v) {
            $data['post_content'] = str_replace($k, view($v), $data['post_content']);
        }

        //
        $this->teamplate['main'] = view(
            'posts/'. $file_view,
            array(
                'controller_slug' => $this->controller_slug,
                'lang_key' => $this->lang_key,
                'post_tags' => $post_tags,
                'parent_post' => $parent_post,
                'quick_menu_list' => [],
                'data' => $data,
                'post_lang' => ($data['lang_key'] != '' ? LanguageCost::typeList($data['lang_key']) : ''),
                'meta_detault' => PostType::meta_default($this->post_type),
                'post_arr_status' => $this->post_arr_status,
                'taxonomy' => $this->taxonomy,
                'tags' => $this->tags,
                'post_type' => $this->post_type,
                'name_type' => $this->name_type,
                'preview_url' => $this->MY_get('preview_url', ''),
                'preview_offset_top' => $this->MY_get('preview_offset_top', ''),
                // mảng tham số tùy chỉnh dành cho các custom post type
                'meta_custom_type' => [],
                'meta_custom_desc' => [],
                // thêm phần controller slug theo từng taxonomy
                'arr_taxnomy_controller' => TaxonomyType::controllerList(),
            )
        );
        return view('posts', $this->teamplate);
    }

}
