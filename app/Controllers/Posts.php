<?php

namespace App\Controllers;

// Libraries
use App\Libraries\PostType;
use App\Libraries\TaxonomyType;

//
class Posts extends Csrf
{
    protected $post_type = PostType::POST;
    protected $taxonomy = TaxonomyType::POSTS;
    protected $file_view = 'post_view';

    public function __construct()
    {
        parent::__construct();
    }

    public function index($id = 0, $slug = '')
    {
        return $this->post_details($id, $slug);
    }

    public function post_details($id = 0, $slug = '', $data = NULL)
    {
        //echo $id . ' <br>' . PHP_EOL;
        //echo $slug . ' <br>' . PHP_EOL;
        //echo 'post details <br>' . PHP_EOL;
        //print_r($data);

        //
        $this->cache_key = $this->post_model->key_cache($id);
        $cache_value = $this->MY_cache($this->cache_key);
        // Will get the cache entry named 'my_foo'
        //var_dump( $cache_value );
        // có thì in ra cache là được
        //if ( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' && $cache_value !== NULL ) {
        if ($this->hasFlashSession() === false && $cache_value !== NULL) {
            return $this->show_cache($cache_value);
        }

        //
        if ($data === NULL) {
            $data = $this->post_model->select_public_post($id, [
                //'post_name' => $slug_1,
                'post_type' => $this->post_type,
            ]);
            //print_r($data);
        }
        //print_r( $data );
        //die( __CLASS__ . ':' . __LINE__ );
        if (empty($data)) {
            //print_r( $data );
            return $this->page404('ERROR ' . strtolower(__FUNCTION__) . ':' . __LINE__ . '! Không xác định được dữ liệu bài viết...');
        }

        // kiểm tra quyền truy cập chi tiết 1 post
        if ($this->post_permission($data) !== true) {
            return $this->page404($this->post_permission($data));
        }

        // kiểm tra lại slug -> nếu sai thì redirect 301 qua url mới
        $this->post_model->check_canonical($slug, $data);

        // update lượt xem -> daidq (2021-12-14): chuyển phần update này qua view, ai thích dùng thì kích hoạt cho nó nhẹ
        //$this->post_model->update_views( $data[ 'ID' ] );

        //
        $data['post_content'] = $this->replace_content($data['post_content']);
        //print_r( $data );

        // lấy thông tin danh mục để tạo breadcrumb
        $cats = [];
        if (isset($data['post_meta']['post_category'])) {
            $post_category = explode(',', $data['post_meta']['post_category']);
            $post_category = $post_category[0];

            //
            if ($post_category > 0) {
                $cats = $this->term_model->get_all_taxonomy($this->taxonomy, $post_category);
                //print_r( $cats );

                if (!empty($cats)) {
                    $this->create_term_breadcrumb($cats);
                }
            }
        }
        //print_r( $this->taxonomy_slider );
        //print_r( $this->posts_parent_list );
        //print_r($data);
        $data = $this->post_model->metaTitleDescription($data);

        // tìm các bài cùng nhóm
        $same_cat_data = [];
        $config_key = 'eb_post_per_page';
        //if ($this->post_type == PostType::BLOG) {
        if ($this->post_type == PostType::PROD) {
            $config_key = 'eb_product_per_page';
        }
        $post_per_page = $this->base_model->get_config($this->getconfig, $config_key, 5);
        if (
            $post_per_page > 0 &&
            isset($data['post_meta']['post_category']) &&
            !empty($data['post_meta']['post_category'])
        ) {
            //print_r( $data[ 'post_meta' ][ 'post_category' ] );

            //
            /*
            $same_cat_data = $this->post_model->select_list_post($this->post_type, [
            'term_id' => $data['post_meta']['post_category'],
            'taxonomy' => $this->taxonomy,
            ], $post_per_page);
            */

            //
            $arr_where_in = [
                'term_id' => explode(',', $data['post_meta']['post_category'])
            ];

            // lấy 1 bài phía trước
            $same_cat_data = $this->base_model->select('*', WGR_POST_VIEW, [
                'ID >' => $data['ID'],
                'post_status' => PostType::PUBLICITY,
                'taxonomy' => $this->taxonomy,
            ], [
                'where_in' => $arr_where_in,
                'order_by' => [
                    'menu_order' => 'ASC',
                    //'time_order' => 'ASC',
                    'ID' => 'ASC',
                ],
                //'get_sql' => 1,
                //'show_query' => 1,
                //'debug_only' => 1,
                //'offset' => 0,
                'limit' => 1
            ]);
            if (!empty($same_cat_data)) {
                $same_cat_data = $this->post_model->list_meta_post([$same_cat_data]);
                //print_r( $same_cat_data );

                $post_per_page -= 1;
            }

            // sau đó là các bài phía sau
            if ($post_per_page > 0) {
                $after_cat_data = $this->base_model->select('*', WGR_POST_VIEW, [
                    'ID <' => $data['ID'],
                    'post_status' => PostType::PUBLICITY,
                    'taxonomy' => $this->taxonomy,
                ], [
                    'where_in' => $arr_where_in,
                    'order_by' => [
                        'menu_order' => 'DESC',
                        'time_order' => 'DESC',
                        'ID' => 'DESC',
                    ],
                    //'get_sql' => 1,
                    //'show_query' => 1,
                    //'debug_only' => 1,
                    //'offset' => 0,
                    'limit' => $post_per_page
                ]);
                if (!empty($after_cat_data)) {
                    $after_cat_data = $this->post_model->list_meta_post($after_cat_data);

                    // gộp lại
                    foreach ($after_cat_data as $after_data) {
                        $same_cat_data[] = $after_data;
                    }
                }
            }
            //print_r( $same_cat_data );
        }

        // nếu có post cha -> lấy cả thông tin post cha
        $parent_data = [];
        if ($data['post_parent'] > 0) {
            $parent_data = $this->base_model->select(
                '*',
                'posts',
                array(
                    // các kiểu điều kiện where
                    'ID' => $data['post_parent'],
                    'post_status' => PostType::PUBLICITY
                ),
                array(
                    // hiển thị mã SQL để check
                    //'show_query' => 1,
                    // trả về câu query để sử dụng cho mục đích khác
                    //'get_query' => 1,
                    //'offset' => 2,
                    'limit' => 1
                )
            );
            //print_r( $parent_data );
            $this->create_breadcrumb($parent_data['post_title'], $this->post_model->get_full_permalink($parent_data));
        }

        // nếu có lệnh redirect do sai URL
        if (isset($_GET['canonical'])) {
            //echo __CLASS__ . ':' . __LINE__;
            // xóa permalink để URL được update lại
            //$data['post_permalink'] = '';
            //$data['updated_permalink'] = 0;
            $full_link = $this->post_model->update_post_permalink($data, DYNAMIC_BASE_URL);
        } else {
            $full_link = $this->post_model->get_full_permalink($data);
        }
        //echo $full_link;

        //
        $this->create_breadcrumb($data['post_title'], $full_link);
        $seo = $this->base_model->post_seo($data, $full_link);

        //
        //$structured_data = $this->structuredData($data, 'Article.html', '', true);
        $structured_data = $this->structuredGetData($data);
        //print_r($structured_data);
        $structured_data = $this->post_model->structuredArticleData($data, $structured_data);
        if (!isset($seo['dynamic_schema'])) {
            $seo['dynamic_schema'] = '';
        }
        $seo['dynamic_schema'] .= $structured_data;

        // -> views
        $this->teamplate['breadcrumb'] = view(
            'breadcrumb_view',
            array(
                'breadcrumb' => $this->breadcrumb
            )
        );

        // tạo dữ liệu danh mục của bài viết mục đích dùng để tạo menu
        $contentAction = $data['post_content'];
        $resultCategory = $this->createCategoryArray($contentAction);
        $data['post_content'] = $resultCategory['post_content'];
        // dùng để foreah ra danh mục của bài viết
        $data['contentCategory'] = $resultCategory['category_array'];
        // đổi nội dung bài viết = các key có sẵn
        foreach (REPLACE_CONTENT as $k => $v) {
            $data['post_content'] = str_replace($k, view($v), $data['post_content']);
        }



        $this->teamplate['main'] = view(
            $this->file_view,
            array(
                'taxonomy_slider' => $this->taxonomy_slider,
                'taxonomy_post_size' => $this->taxonomy_post_size,
                'same_cat_data' => $same_cat_data,
                'seo' => $seo,
                'data' => $data,
            )
        );

        // nếu có flash session -> trả về view luôn
        if ($this->hasFlashSession() === true) {
            return view('layout_view', $this->teamplate);
        }
        // còn không sẽ tiến hành lưu cache
        $cache_value = view('layout_view', $this->teamplate);

        $cache_save = $this->MY_cache($this->cache_key, $cache_value . '<!-- Served from: ' . __FUNCTION__ . ' -->');
        //var_dump( $cache_save );

        //
        return $cache_value;
    }
    /**
     * @param $postContent
     * @return array
     * hàm tạo mảng danh mục của bài viết
     * trả về mảng + nội dung đã add id
     */
    public function createCategoryArray($postContent)
    {
        $category_array = array();
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($postContent, 'HTML-ENTITIES', 'UTF-8'));
        $h2_list = $dom->getElementsByTagName('h2');
        foreach ($h2_list as $index => $h2) {
            $h2_id = $this->convert_vi_to_en_slug($h2->nodeValue, true);
            $h2->setAttribute('id', $h2_id);
            $category_array[$h2_id] = array(
                'id' => $h2_id,
                'name' => $h2->nodeValue,
                'children' => array(),
            );
            $next_node = $h2->nextSibling;
            while ($next_node) {
                if ($next_node->nodeName == 'h3') {
                    $h3_id = $this->convert_vi_to_en_slug($next_node->nodeValue, true);
                    $next_node->setAttribute('id', $h3_id);
                    $category_array[$h2_id]['children'][$h3_id] = array(
                        'id' => $h3_id,
                        'name' => $next_node->nodeValue,
                    );
                } elseif ($next_node->nodeName == 'h2') {
                    break;
                }
                $next_node = $next_node->nextSibling;
            }
            $postContent = $dom->saveHTML();
        }
        return array('category_array' => $category_array, 'post_content' => $postContent);
    }
    public function convert_vi_to_en_slug($str,$number=false) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        if ($number== true){
            $first_char = substr($str, 0, 1);
            if (is_numeric($first_char)) {
                $str = "_" . $str;
            }
        }
        $str = str_replace("?", "-", str_replace("&*#39;","",$str));
        $str = preg_replace("/[.,?!]/", "-", $str);
        $str = strtolower($str);
        return $str;
    }
}
