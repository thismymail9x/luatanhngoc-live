<?php

namespace App\Controllers;

// Libraries
use App\Controllers\Home;
use App\Libraries\CommentType;
use App\Libraries\DeletedStatus;
use App\Libraries\TaxonomyType;
use App\Libraries\PostType;
use App\Models\CustomCode;
use App\Models\CustomComment;
use App\Models\User;
use App\Libraries\LanguageCost;

//
class Tacgia extends Home
{
    protected $controller_name = 'Nhân sự';
    // số bản ghi trên mỗi trang
    protected $post_per_page = 50;
    protected $table = 'posts';
    protected $metaTable = 'postmeta';
    protected $post_arr_status = [];
    protected $default_post_data = [];
    protected $timestamp_post_data = [];
    protected $controller_slug = 'author';
    protected $main_category_key = 'post_category';
    protected $taxonomy = TaxonomyType::POSTS;
    protected $tags = TaxonomyType::TAGS;
    protected $post_type = '';
    protected $name_type = '';

    public function __construct()
    {
        parent::__construct();
        // hỗ trợ lấy theo params truyền vào từ url
        if ($this->post_type == '') {
            $this->post_type = $this->MY_get('post_type', PostType::POST);
        }
        $this->name_type = PostType::typeList($this->post_type);
        $this->breadcrumb[] = '<li><a href="tacgia/list">' . $this->controller_name . '</a></li>';
        $this->post_arr_status = PostType::arrStatus();
        // chỉnh lại bảng select của model
        $this->post_model->table = $this->table;
        $this->post_model->metaTable = $this->metaTable;
        $this->customModel = new CustomCode();
        $this->userModel = new User();
    }

    /**
     * @return mixed
     * danh sách tác giả của bài viết
     */
    public function list()
    {
        // lấy danh sách tác giả có bài viết
        $for_action = ''; // dùng để lưu lại param của action ( ví dụ search theo status .v.v.
        $urlPartPage = 'tacgia/list';

        $where = [
            'users.is_deleted' => 0,
            'posts.post_status' => PostType::PUBLICITY,
            'posts.post_type' => PostType::POST
        ]; // lấy theo điều kiện
        $filter = [
            'join' => [
                'posts' => 'posts.post_author = users.ID'
            ],
        ];
        $totalThread = $this->base_model->select('COUNT(DISTINCT wp_users.ID) AS c', 'users', $where, $filter);
        $totalThread = $totalThread[0]['c'];

        if ($totalThread > 0) {
            $totalPage = ceil($totalThread / $this->post_per_page);
            if ($totalPage < 1) {
                $totalPage = 1;
            }
            $page_num = $this->MY_get('page_num', 1);
            //echo $totalPage . '<br>' . PHP_EOL;
            if ($page_num > $totalPage) {
                $page_num = $totalPage;
            } else if ($page_num < 1) {
                $page_num = 1;
            }
            $for_action .= $page_num > 1 ? '&page_num=' . $page_num : '';
            //echo $totalThread . '<br>' . PHP_EOL;
            //echo $totalPage . '<br>' . PHP_EOL;
            $offset = ($page_num - 1) * $this->post_per_page;

            //
            $pagination = $this->base_model->EBE_pagination($page_num, $totalPage, $urlPartPage, '&page_num=');


            // select dữ liệu từ 1 bảng bất kỳ
            $filter['offset'] = $offset;
            $filter['limit'] = $this->post_per_page;
            $filter['group_by'] = ['users.ID'];
            $data = $this->base_model->select('users.*', 'users', $where, $filter);
        } else {
            $data = [];
            $pagination = '';
        }

        // -> views
        $this->teamplate['breadcrumb'] = view(
            'breadcrumb_view',
            array(
                'breadcrumb' => $this->breadcrumb
            )
        );

        //
        //echo $file_view . '<br>' . PHP_EOL;
        $this->teamplate['main'] = view(
            'custom/author_list',
            array(
                'seo' => $this->base_model->default_seo('Danh sách nhân sự', $this->getClassName(__CLASS__) . '/' . __FUNCTION__),
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
     * @param $id
     * @return mixed
     * hiểm thì chi tiết tác giả
     */
    public function author($id)
    {
        $data = $this->base_model->select(
            '*',
            'users',
            [
                'ID' => $id
            ],
            array(
                // hiển thị mã SQL để check
                //'show_query' => 1,
                // trả về câu query để sử dụng cho mục đích khác
                //'get_query' => 1,
                //'offset' => 2,
                'limit' => 1
            )
        );
        $metaDescription = $this->userModel->get_user_meta($id, 'description');
        // lấy dữ liệu meta description của user
        $data['description'] = '';
        if (!empty($metaDescription)) {
            $data['description'] = $metaDescription['meta_value'];
        }

        if (empty($data)) {
            return $this->page404('ERROR ' . strtolower(__FUNCTION__) . ':' . __LINE__ . '! Không xác định được thông tin thành viên...');
        }
        // -> views
        $this->teamplate['breadcrumb'] = view(
            'breadcrumb_view',
            array(
                'breadcrumb' => $this->breadcrumb
            )
        );

        $topAuthor = $this->customModel->getTopOfAuthor();
        // lấy tổng số bài viết của tác giả được public
        $countPost = $this->customModel->getCountPostOfUser($id);
        //echo $file_view . '<br>' . PHP_EOL;
        $this->teamplate['main'] = view(
            'custom/author_view',
            array(
                'seo' => $this->base_model->default_seo('Thông tin nhân sự', $this->getClassName(__CLASS__) . '/' . __FUNCTION__),
                'data' => $data,
                'topAuthor' => $topAuthor,
                'countPost' => $countPost['count']
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

    public function posts()
    {
        //
        $post_per_page = 20;
        // URL cho các action dùng chung
        $for_action = '';
        // URL cho phân trang
        $urlPartPage = 'author/posts?part_type=' . $this->post_type;

        //
        $by_keyword = $this->MY_get('s');
        $post_status = $this->MY_get('post_status');
        $by_term_id = $this->MY_get('term_id', 0);
        // params truyền riêng để tìm kiếm phần kpi
        $start_date = $this->MY_get('start_date', '');
        $end_date = $this->MY_get('end_date', '');
        $salary_type = $this->MY_get('salary_type', '');
        // các kiểu điều kiện where
        if (!isset($ops['where'])) {
            $where = [];
        }
        //$where[ $this->table . '.post_status !=' ] = PostType::DELETED;
        $where[$this->table . '.post_type'] = $this->post_type;
        $where[$this->table . '.lang_key'] = $this->lang_key;

        // tìm kiếm theo từ khóa nhập vào
        $where_or_like = [];
        $where_in = [];
        $or = [];
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

        // tìm kiếm kiểu KPI
        if ($salary_type != '') {
            $where[$this->table . '.salary_type'] = $salary_type;
        }
        // tìm kiếm theo thời gian duyệt bài

        if ($start_date != '') {
            $where[$this->table . '.post_success >='] = date('Y-m-d', strtotime($start_date));
        }
        if ($end_date != '') {
            $where[$this->table . '.post_success <='] = date('Y-m-d', strtotime($end_date));
        }

        $where_in[$this->table . '.post_status'] = $by_post_status;

        // mặc định sẽ hiển thị bài viết của người ấy tạo hoặc bài viết chưa được phân (để nhận bài)
        $where[$this->table . '.post_author'] = $this->session_data['ID'];
        // khi các ko search theo các điều kiện bên dưới thì mới lấy ra kết quả các bài nháp để nhận
        if ($post_status == '' && $by_keyword == '' && $by_term_id == 0 && $start_date == '' && $end_date == '' && $salary_type == '') {
            $or[$this->table . '.post_status'] = PostType::DRAFT;
        }
        // tổng kết filter
        $filter = [
            'join' => [
                'users' => 'users.ID = ' . $this->table . '.post_author',
            ],
            'where_in' => $where_in,
            'or_like' => $where_or_like,
            'or' => $or,
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

            $filter['join'] = array_merge([
                'term_relationships' => 'term_relationships.object_id = ' . $this->table . '.ID',
                'term_taxonomy' => 'term_relationships.term_taxonomy_id = term_taxonomy.term_taxonomy_id',
            ], $filter['join']);
        }

        //
        if (isset($ops['add_filter'])) {
            foreach ($ops['add_filter'] as $k => $v) {
                $filter[$k] = $v;
            }
        }

        /*
         * phân trang
         */
        $totalThread = $this->base_model->select('COUNT(wp_posts.ID) AS c', $this->table, $where, $filter);
        //print_r( $totalThread );
        $totalThread = $totalThread[0]['c'];
        //print_r( $totalThread );

        //
        $page_num = $this->MY_get('page_num', 1);
        if ($totalThread > 0) {
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
            } // mặc định sắp xếp theo stt và thời gian tạo
            else {
                $order_by = [
                    $this->table . '.menu_order' => 'DESC',
                    $this->table . '.time_order' => 'DESC',
                    $this->table . '.ID' => 'DESC',
                ];
            }
            $filter['order_by'] = $order_by;
            $data = $this->base_model->select('posts.*,users.user_nicename', $this->table, $where, $filter);

            //
            $data = $this->post_model->list_meta_post($data);

            // xử lý dữ liệu cho angularjs
            foreach ($data as $k => $v) {
                // lấy comment cuối cùng của bài viết
                $comment = $this->base_model->select('comment_author', 'comments', ['comment_post_ID' => $v['ID'], 'comment_type' => CommentType::COMMENT], ['order_by' => ['comment_date' => 'DESC'], 'limit' => 1]);
                if (!empty($comment)) {
                    $v['last_comment'] = $comment['comment_author'];
                } else {
                    $v['last_comment'] = 0;
                }
                // không cần hiển thị nội dung
                $v['post_content'] = '';
                $v['post_excerpt'] = '';
                //print_r($v);
                //continue;

                // lấy 1 số dữ liệu khác gán vào, để angularjs chỉ việc hiển thị
                $v['admin_permalink'] = $this->get_user_permalink($v['ID']);
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
//
        $this->teamplate['main'] = view(
            'cus/post_list',
            array(
                'seo' => $this->base_model->default_seo('Thông tin tài khoản', $this->getClassName(__CLASS__) . '/' . __FUNCTION__),
                'for_action' => $for_action,
                'by_post_status' => $by_post_status,
                'post_status' => $post_status,
                'currentPage' => $page_num,
                'post_per_page' => $post_per_page,
                'salary_type' => $salary_type,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'by_keyword' => $by_keyword,
                'by_term_id' => $by_term_id,
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

    public function likeTopOfPost()
    {
        $id = $this->MY_post('id');
        $type = $this->MY_post('type');
        $comment = $this->customCommentModel->select_comment($id, []);
        if (empty($comment)) {
            $this->result_json_type([
                'error' => 'Top không tồn tại',
                'data' => $_POST
            ]);
        } else {
            if ($type == 'minus') {
                $this->customCommentModel->update_comment_of_post($id, [
                    'comment_karma' => $comment['comment_karma'] - 1,
                ], [
                ]);
            } else {
                $this->customCommentModel->update_comment_of_post($id, [
                    'comment_karma' => $comment['comment_karma'] + 1,
                ], [
                ]);
            }

            $this->result_json_type([
                'ok' => __LINE__,
                'data' => $_POST
            ]);
        }
    }

    /**
     * @return void
     * ajax lưu bình luận
     */
    public function saveCommentOfPost()
    {
        $post_id = $this->MY_post('post_id');
        $post_title = $this->MY_post('post_title');
        $user_name = $this->MY_post('user_name');
        $value = $this->MY_post('value'); // giá trị comment
        $parent_id = $this->MY_post('parent_id'); // id comment cha
//        $value = $this->customModel->sanitizeInput($value); // mã hõa các thẻ tránh XSS

        $data = [
            'comment_content' => $value,
            'comment_post_ID' => $post_id,
            'comment_title' => $user_name . '* bình luận bài viết: ' . $post_title,
            'comment_author' => isset($this->session_data['ID']) ? $this->session_data['ID'] : 0,
            'comment_approved' => 0,
            'comment_parent' => $parent_id > 0 ? $parent_id : 0 // nếu la binh luan con thi sẽ lưu parent
        ];
        if (trim($value) == '' || trim($user_name) == '') {
            $this->result_json_type([
                'error' => 'Gửi bình luận không thành công',
                'data' => $_POST
            ]);
        } else {
            $this->customCommentModel->insert_comment_of_post($data);
            $this->result_json_type([
                'ok' => __LINE__,
                'data' => $_POST
            ]);
        }
    }
}
