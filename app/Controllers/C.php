<?php

namespace App\Controllers;

// Libraries
use App\Libraries\LanguageCost;
use App\Libraries\PostType;
use App\Libraries\TaxonomyType;
use App\Libraries\UsersType;

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
    protected $timestamp_post_data = [];
    protected $default_post_data = [];
    // dùng để chọn xem hiển thị nhóm sản phẩm nào ra ở phần danh mục
    protected $main_category_key = 'post_category';
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
            } // hoặc custom taxonomy có đăng ký nhưng không hiển thị với người khác ngoại trừ admin
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
        if (empty($this->session_data)) {
            return redirect()->to(base_url());
        }
        $id = $this->MY_get('id', 0);
//        $postController = new \App\Controllers\Admin\Posts();
        //
        $file_view = 'add';
        if (!empty($this->MY_post('data'))) {
            // update
            if ($id > 0) {
                return $this->update($id);
            }
            // insert
            return $this->add_new();
        }
        // edit
        if ($id > 0) {
            // select dữ liệu từ 1 bảng bất kỳ
            $data = $this->post_model->select_post($id, [
                'post_type' => $this->post_type,
                //'lang_key' => $this->lang_key,
            ]);
            if (empty($data)) {
                die('Dữ liệu không tồn tại');
            }
        } // add
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
        $this->teamplate['breadcrumb'] = view(
            'breadcrumb_view',
            array(
                'breadcrumb' => $this->breadcrumb
            )
        );
        $this->teamplate['main'] = view(
            'posts/' . $file_view,
            array(
                'seo' => $this->base_model->default_seo('Thông tin tài khoản', $this->getClassName(__CLASS__) . '/' . __FUNCTION__),
                'session_data' => $this->session_data,
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
                'post_cat' => $post_cat,
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
        return view('layout_view', $this->teamplate);

    }

    protected function add_new($data = NULL)
    {
        if ($data === NULL) {
            $data = $this->MY_post('data');
        }
        $data['post_type'] = $this->post_type;
        // hungtd add logic là với quyền Tác giả bài viết sẽ ở trạng thái chờ duyệt
        $data['post_status'] = PostType::PENDING;
        // random lượt xem bài viết
        $data['post_viewed'] = rand(1000, 5000);

        $result_id = $this->post_model->insert_post($data, [], true);
        if (is_array($result_id) && isset($result_id['error'])) {
            $this->base_model->alert($result_id['error'], 'error');
        }

        if ($result_id > 0) {
            // tạo thành công thì xuất thông báo, và chuyển đến trang danh sách bài viết
            return redirect()->to($this->get_user_permalink($result_id));
            $this->base_model->alert('Tạo bài viết thành công!', $this->get_user_permalink($result_id));
        }
        $this->base_model->alert('Lỗi tạo ' . $this->name_type . ' mới', 'error');
    }

    public function get_user_permalink($id = 0, $controller_slug = 'c')
    {
        //$url = base_url( 'admin/' . $controller_slug . '/add' ) . '?post_type=' . $post_type;
        $url = base_url($controller_slug . '/user_add');
        if ($id > 0) {
            //$url .= '&id=' . $id;
            $url .= '?id=' . $id;
        }
        return $url;
    }

    protected function get_preview_url()
    {
        $result = [];

        //
        $a = $this->MY_get('preview_url', '');
        if (
            $a != ''
        ) {
            $result[] = 'preview_url=' . urlencode($a);
        }

        //
        $a = $this->MY_get('preview_offset_top', '');
        if ($a != '') {
            $result[] = 'preview_offset_top=' . $a;
        }

        //
        if (!empty($result)) {
            return '&' . implode('&', $result);
        }
        return '';
    }

    protected function update($id)
    {
        $this->updating($id);
        $data = $this->MY_post('data');
        // hungtd add logic là với quyền Tác giả bài viết sẽ ở trạng thái chờ duyệt
        $data['post_status'] = PostType::PENDING;
        // nạp lại trang nếu có đổi slug duplicate
        if (
            // url vẫn còn duplicate
            isset($data['post_name']) && strstr($data['post_name'], '-duplicate-') == true &&
            // tiêu đề không còn Duplicate
            isset($data['post_title']) && strstr($data['post_title'], ' - Duplicate ') == false
        ) {
            // nạp lại trang
            //$this->base_model->alert('', DYNAMIC_BASE_URL . ltrim($_SERVER['REQUEST_URI'], '/'));
            //$this->base_model->alert('', $this->post_model->get_admin_permalink($this->post_type, $id, $this->controller_slug));
            $this->base_model->alert('', $this->get_user_permalink($id));
        } else {
            // so sánh url cũ và mới
            $old_postname = $this->MY_post('old_postname');
            //print_r($old_postname);

            // nếu có sự khác nhau
            if (isset($data['post_name']) && $old_postname != $data['post_name']) {
                // lấy data mới -> sau khi update
                $new_data = $this->post_model->select_post($id, [
                    'post_type' => $this->post_type,
                ]);
                //print_r($new_data);

                // -> lấy url mới -> thiết lập lại url ở fronend
                echo '<script>top.set_new_post_url("' . $this->post_model->update_post_permalink($new_data) . '", "' . $new_data['post_name'] . '");</script>';
            }
        }

        //
        echo '<script>top.after_update_post();</script>';

        //
        $this->base_model->alert('Cập nhật ' . $this->name_type . ' thành công');
    }

    protected function updating($id)
    {
        $data = $this->MY_post('data');
        //print_r( $data );
        //print_r( $_POST );

        // nhận dữ liệu default từ javascript khởi tạo và truyền vào trong quá trình submit
        if (isset($data['default_post_data'])) {
            foreach ($data['default_post_data'] as $k => $v) {
                if (!isset($this->default_post_data[$k])) {
                    $this->default_post_data[$k] = '';
                }
            }
        }
        //print_r( $this->default_post_data );
        foreach ($this->default_post_data as $k => $v) {
            if (!isset($data[$k])) {
                $data[$k] = $v;
            }
        }

        // convert datetime to timestamp
        //print_r( $data );
        //print_r( $this->timestamp_post_data );
        foreach ($this->timestamp_post_data as $k => $v) {
            //echo $k . '<br>' . PHP_EOL;
            //echo $data[ $k ] . '<br>' . PHP_EOL;
            if (isset($data[$k]) && $data[$k] != '') {
                $data[$k] = strtotime($data[$k]);
            }
        }
        //print_r( $data );

        //
        $result_id = $this->post_model->update_post($id, $data, [
            'post_type' => $this->post_type,
        ]);

        // nếu có lỗi thì thông báo lỗi
        if ($result_id !== true && is_array($result_id) && isset($result_id['error'])) {
            $this->base_model->alert($result_id['error'], 'error');
        }

        // dọn dẹp cache liên quan đến post này -> reset cache
        $this->cleanup_cache($this->post_model->key_cache($id));
        //
        if (isset($data['post_title'])) {
            // bổ sung thêm xóa cache với menu
            if ($this->post_type == PostType::MENU || $this->post_type == PostType::HTML_MENU) {
                $post_name = $this->base_model->_eb_non_mark_seo($data['post_title']);
                //echo $post_name . '<br>' . PHP_EOL;
                $this->cleanup_cache('get_the_menu-' . $post_name);
            } // hoặc page
            else if ($this->post_type == PostType::PAGE) {
                $this->cleanup_cache('get_page-' . $data['post_name']);
            } // hoặc ads
            else if ($this->post_type == PostType::ADS) {
                $this->cleanup_cache('get_the_ads-');
            }
        }

        // xóa cache cho term liên quan
        if (isset($_POST['post_meta']) && isset($_POST['post_meta']['post_category'])) {
            foreach ($_POST['post_meta']['post_category'] as $v) {
                //echo $v . '<br>' . PHP_EOL;
                $this->cleanup_cache($this->term_model->key_cache($v));
            }
        }

        //
        return true;
    }
    // danh sách bài viết của user + các bài viết có trạng
    public function lists()
    {
        //
        $post_per_page = 20;
        // URL cho các action dùng chung
        $for_action = '';
        // URL cho phân trang
        $urlPartPage =  $this->controller_slug . '?part_type=' . $this->post_type;

        //
        $by_keyword = $this->MY_get('s');
        $post_status = $this->MY_get('post_status');
        $by_term_id = $this->MY_get('term_id', 0);
        $by_user_id = $this->MY_get('user_id', 0);

        // các kiểu điều kiện where
        if (!isset($ops['where'])) {
            $where = [];
        }
        //$where[ $this->table . '.post_status !=' ] = PostType::DELETED;
        $where[$this->table . '.post_type'] = $this->post_type;
        $where[$this->table . '.lang_key'] = $this->lang_key;
        if ($by_user_id > 0) {
            $where[$this->table . '.post_author'] = $by_user_id;
            $urlPartPage .= '&user_id=' . $by_user_id;
            $for_action .= '&user_id=' . $by_user_id;
        }

        // tìm kiếm theo từ khóa nhập vào
        $where_or_like = [];
        $where_in = [];
        if ($by_keyword != '') {
            $urlPartPage .= '&s=' . $by_keyword;
            $for_action .= '&s=' . $by_keyword;

            // nếu là email -> tìm theo email thành viên

                $by_like = $this->base_model->_eb_non_mark_seo($by_keyword);
                // tối thiểu từ 1 ký tự trở lên mới kích hoạt tìm kiếm
                if (strlen($by_like) > 0) {
                    //var_dump( strlen( $by_like ) );
                    // nếu là số -> chỉ tìm theo ID
                    if (is_numeric($by_like) === true) {
                        $where_or_like = [
                            'ID' => $by_like * 1,
                            'post_author' => $by_like,
                            'post_parent' => $by_like,
                        ];
                    } else {
                        $where_or_like = [
                            'post_name' => $by_like,
                            'post_title' => $by_keyword,
                        ];
                    }
                }
        }

        //
        if ($post_status == '') {
            $by_post_status = [
                PostType::DRAFT,
                PostType::PUBLICITY,
                PostType::PENDING,
                PostType::PRIVATELY,
            ];
        } else {
            $urlPartPage .= '&post_status=' . $post_status;
            $for_action .= '&post_status=' . $post_status;

            $by_post_status = [
                $post_status,
            ];
        }
        $where_in[$this->table . '.post_status'] = $by_post_status;

        // tổng kết filter
        $filter = [
            'where_in' => $where_in,
            'or_like' => $where_or_like,
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
            'limit' => -1
        ];

        // nếu có lọc theo term_id -> thêm câu lệnh để lọc
        if ($by_term_id > 0) {
            // lấy các nhóm con của nhóm này
            $ids = $this->base_model->select(
                'GROUP_CONCAT(DISTINCT term_id SEPARATOR \',\') AS ids',
                'term_taxonomy',
                array(
                    // các kiểu điều kiện where
                    'parent' => $by_term_id,
                ),
                array(
                    // trả về COUNT(column_name) AS column_name
                    //'selectCount' => 'ID',
                    // hiển thị mã SQL để check
                    //'show_query' => 1,
                    // trả về câu query để sử dụng cho mục đích khác
                    //'get_query' => 1,
                    // trả về tổng số bản ghi -> tương tự mysql num row
                    //'getNumRows' => 1,
                    //'offset' => 0,
                    'limit' => -1
                )
            );
            //print_r( $ids );
            $ids = $ids[0]['ids'];

            //
            if ($ids != '') {
                $ids = str_replace(' ', '', $ids);
                $ids = explode(',', $ids);
                $ids[] = $by_term_id;
                //print_r( $ids );

                //
                $filter['where_in']['term_taxonomy.term_id'] = $ids;
            } else {
                $where['term_taxonomy.term_id'] = $by_term_id;
            }

            $urlPartPage .= '&term_id=' . $by_term_id;
            $for_action .= '&term_id=' . $by_term_id;

            $filter['join'] = [
                'term_relationships' => 'term_relationships.object_id = ' . $this->table . '.ID',
                'term_taxonomy' => 'term_relationships.term_taxonomy_id = term_taxonomy.term_taxonomy_id',
            ];
        }
        //print_r($where);
        //print_r($filter);


        //
        if (isset($ops['add_filter'])) {
            foreach ($ops['add_filter'] as $k => $v) {
                $filter[$k] = $v;
            }
        }


        /*
         * phân trang
         */
        $totalThread = $this->base_model->select('COUNT(ID) AS c', $this->table, $where, $filter);
        //print_r( $totalThread );
        $totalThread = $totalThread[0]['c'];
        //print_r( $totalThread );

        //
        if ($totalThread > 0) {
            $page_num = $this->MY_get('page_num', 1);

            $totalPage = ceil($totalThread / $post_per_page);
            if ($totalPage < 1) {
                $totalPage = 1;
            }
            //echo $totalPage . '<br>' . PHP_EOL;
            if ($page_num > $totalPage) {
                $page_num = $totalPage;
            } else if ($page_num < 1) {
                $page_num = 1;
            }
            $for_action .= ($page_num > 1 ? '&page_num=' . $page_num : '');
            //echo $totalThread . '<br>' . PHP_EOL;
            //echo $totalPage . '<br>' . PHP_EOL;
            $offset = ($page_num - 1) * $post_per_page;

            // chạy vòng lặp gán nốt các thông số khác trên url vào phân trang
            $urlPartPage = $this->base_model->auto_add_params($urlPartPage);

            //
            $pagination = $this->base_model->EBE_pagination($page_num, $totalPage, $urlPartPage, '&page_num=');


            // select dữ liệu từ 1 bảng bất kỳ
            $filter['offset'] = $offset;
            $filter['limit'] = $post_per_page;

            //
            $order_by = $this->MY_get('order_by', '');
            if ($order_by != '') {
                $order_by = [
                    $this->table . '.' . $order_by => 'DESC',
                ];
            }
            // mặc định sắp xếp theo stt và thời gian tạo
            else {
                $order_by = [
                    $this->table . '.menu_order' => 'DESC',
                    $this->table . '.time_order' => 'DESC',
                    $this->table . '.ID' => 'DESC',
                ];
            }
            $filter['order_by'] = $order_by;
            $data = $this->base_model->select('*', $this->table, $where, $filter);

            //
            $data = $this->post_model->list_meta_post($data);
            //print_r( $data );

            // xử lý dữ liệu cho angularjs
            foreach ($data as $k => $v) {
                // không cần hiển thị nội dung
                $v['post_content'] = '';
                $v['post_excerpt'] = '';
                //print_r($v);
                //continue;

                // lấy 1 số dữ liệu khác gán vào, để angularjs chỉ việc hiển thị
                $v['admin_permalink'] = $this->post_model->get_admin_permalink($this->post_type, $v['ID'], $this->controller_slug);
                if ($v['post_type'] == PostType::ORDER) {
                    $v['the_permalink'] = '#';
                } else {
                    $v['the_permalink'] = $this->post_model->get_post_permalink($v);
                }
                if (isset($v['post_meta'])) {
                    $v['thumbnail'] = $this->post_model->get_list_thumbnail($v['post_meta']);
                    $v['main_category_key'] = $this->post_model->return_meta_post($v['post_meta'], $this->main_category_key);
                } else {
                    $v['thumbnail'] = '';
                    $v['main_category_key'] = '';
                }

                //
                //print_r( $v );

                //
                $data[$k] = $v;
            }
        } else {
            $data = [];
            $pagination = '';
        }

        //
        $this->teamplate['breadcrumb'] = view(
            'breadcrumb_view',
            array(
                'breadcrumb' => $this->breadcrumb
            )
        );
        $this->teamplate['main'] = view(
            'posts/list',
            array(
                'seo' => $this->base_model->default_seo('Thông tin tài khoản', $this->getClassName(__CLASS__) . '/' . __FUNCTION__),
                'for_action' => $for_action,
                'by_post_status' => $by_post_status,
                'post_status' => $post_status,
                'by_keyword' => $by_keyword,
                'by_term_id' => $by_term_id,
                'by_user_id' => $by_user_id,
                'controller_slug' => $this->controller_slug,
                'pagination' => $pagination,
                'totalThread' => $totalThread,
                'main_category_key' => $this->main_category_key,
                'data' => $data,
                'taxonomy' => $this->taxonomy,
                'post_type' => $this->post_type,
                'name_type' => $this->name_type,
                'post_arr_status' => $this->post_arr_status,
                //'list_view_path' => $this->list_view_path,
                'list_table_path' => '',
            )
        );
        //return $this->teamplate_admin[ 'content' ];
        return view('layout_view', $this->teamplate);
    }
    public function cleanup_cache($for = '', $clean_all = false)
    {
        if ($for != '' || !empty($this->MY_post('data'))) {
            /*
             * ưu tiên sử dụng cleanup mặc định của codeigniter
             */
            // xóa theo key truyền vào -> dùng khi update post, term, config...
            if ($for != '') {
                $has_cache = $this->base_model->dcache($for, $clean_all);
                // 1 số phương thức không áp dụng được kiểu xóa này do không có key
                if ($has_cache === NULL) {
                    return false;
                }
              //  echo 'Using cache delete Matching `' . $for . '` --- Total clear: ' . $has_cache . '<br>' . PHP_EOL;
                //var_dump( $has_cache );
                //die( $for );
            }
            // xóa toàn bộ cache
            else {
                //var_dump( $this->base_model->cache->getCacheInfo() );
                //die( __CLASS__ . ':' . __LINE__ );
                $has_cache = $this->base_model->dcache();
            }

            // nếu lỗi -> thử phương thức xóa từng file
            if ($has_cache === false && MY_CACHE_HANDLER == 'file') {
                foreach (glob(WRITE_CACHE_PATH . $for . '*') as $filename) {
                    echo $filename . '<br>' . PHP_EOL;
                    $has_cache = true;

                    //
                    if (is_file($filename)) {
                        if (!$this->MY_unlink($filename)) {
                            $this->base_model->alert('Lỗi xóa file cache ' . basename($filename), 'error');
                        }
                    }
                }
            }
            //var_dump( $has_cache );

            // nếu có giá trị của for -> thường là gọi từ admin lúc update -> không alert
            if ($for != '') {
                $this->base_model->alert('Toàn bộ file cache đã được xóa',base_url('c/lists'));
                return false;
            }

            //
            if ($has_cache === true) {
                $this->base_model->alert('Toàn bộ file cache đã được xóa',base_url('c/lists'));

                // đồng bộ lại tổng số nhóm con cho các danh mục trước đã
                $this->term_model->sync_term_child_count();
            } else {
                $this->base_model->alert('Thư mục cache trống!', 'warning');
            }
            die(__CLASS__ . ':' . __LINE__);
        }
        return redirect()->back();
    }

}
