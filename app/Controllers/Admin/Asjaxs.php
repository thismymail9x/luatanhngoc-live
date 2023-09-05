<?php
/*
 * AJAX -> Asynchronous Javascript and XML
 * ajax trong admin thì thêm chữ s trong Asynchronous để phân biệt với ajax public
 */

namespace App\Controllers\Admin;

use App\Libraries\CommentType;
use App\Libraries\PostType;
use App\Models\Comment;
use App\Models\CustomCode;

class Asjaxs extends Admin
{
    // chức năng này không cần nạp header
    public $preload_admin_header = false;

    public function __construct()
    {
        parent::__construct();
    }

    // trả về URL hiện tại của website -> dùng để kiểm tra URL có https với www không
    protected function check_via_curl($test_url, $session_id = 'b822aeffbdeab9bbf59bd885bbd06e02')
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $test_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=' . $session_id
            ),
        ));
        $http_response = curl_exec($curl);
        curl_close($curl);

        //
        return $http_response;
    }

    public function check_ssl()
    {
        $test_url = DYNAMIC_BASE_URL . 'ajaxs/the_base_url';
        // bỏ https
        $test_url = str_replace('https://', 'http://', $test_url);
        // bỏ www.
        $test_url = str_replace('http://www.', 'http://', $test_url);
        //die( $test_url );

        // thêm lại www.
        $www_url = str_replace('http://', 'http://www.', $test_url);
        //die( $www_url );

        //
        //$client = \Config\Services::curlrequest();

        // rồi lấy url xem nó có tự redirect về url chuẩn mình mong muốn không
        $this->result_json_type([
            'http_url' => $test_url,
            'http_response' => $this->check_via_curl($test_url),
            'www_url' => $www_url,
            'www_response' => $this->check_via_curl($www_url),
            //'base_url' => file_get_contents( $test_url . 'admin/asjaxs/the_base_url', 1 ),
            /*
             'base_url' => $client->request( 'GET', $test_url, [
             'allow_redirects' => true,
             // Sets the following defaults:
             'max' => 5, // Maximum number of redirects to follow before stopping
             'strict' => true, // Ensure POST requests stay POST requests through redirects
             'protocols' => [ 'http', 'https' ] // Restrict redirects to one or more protocols
             ] ),
             */
        ]);
    }

    public function get_taxonomy_by_taxonomy()
    {
        header('Content-type: application/json; charset=utf-8');

        //
        $taxonomy = $this->MY_post('taxonomy', '');
        if (empty($taxonomy)) {
            die(json_encode([
                'code' => __LINE__,
                'error' => 'EMPTY taxonomy'
            ]));
        }

        //
        //die( json_encode( $_POST ) );
        die($this->term_model->json_taxonomy($taxonomy, 0, [
            'get_child' => 1,
            'lang_key' => $this->MY_post('lang_key', ''),
        ], $taxonomy . '_get_child'));
    }

    public function get_users_by_ids()
    {
        header('Content-type: application/json; charset=utf-8');

        //
        $ids = $this->MY_post('ids', '');
        if (empty($ids)) {
            die(json_encode([
                'code' => __LINE__,
                'error' => 'EMPTY ids'
            ]));
        }

        //
        //die( json_encode( $_POST ) );

        // SELECT dữ liệu từ 1 bảng bất kỳ
        $data = $this->base_model->select('ID, user_email', 'users', array(// các kiểu điều kiện where
        ), array(
            'where_in' => array(
                'ID' => explode(',', $ids)
            ),
            'group_by' => array(
                'ID',
            ),
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            // trả về COUNT(column_name) AS column_name
            //'selectCount' => 'ID',
            // trả về tổng số bản ghi -> tương tự mysql num row
            //'getNumRows' => 1,
            //'offset' => 0,
            'limit' => -1
        ));

        //
        die(json_encode($data));
    }

    public function update_term_order()
    {
        $term_id = $this->MY_post('id', 0);
        if ($term_id <= 0) {
            $this->result_json_type([
                'code' => __LINE__,
                'error' => 'term id is zero!'
            ]);
        }

        //
        $term_order = $this->MY_post('order', 0);

        // UPDATE
        $result_id = $this->base_model->update_multiple('terms', [
            // SET
            'term_order' => $term_order,
        ], [
            // WHERE
            'term_id' => $term_id,
        ], [
            'debug_backtrace' => debug_backtrace()[1]['function'],
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            // mặc định sẽ remove các field không có trong bảng, nếu muốn bỏ qua chức năng này thì kích hoạt no_remove_field
            //'no_remove_field' => 1
        ]);

        if ($result_id !== false) {
            $this->result_json_type([
                'ok' => __LINE__,
                'data' => $_POST
            ]);
        }

        //
        $this->result_json_type([
            'code' => __LINE__,
            'error' => 'Lỗi cập nhật số thứ tự cho danh mục!'
        ]);
    }

    public function update_menu_order()
    {
        $id = $this->MY_post('id', 0);
        if ($id <= 0) {
            $this->result_json_type([
                'code' => __LINE__,
                'error' => 'post id is zero!'
            ]);
        }

        //
        $menu_order = $this->MY_post('order', 0);

        // UPDATE
        $result_id = $this->base_model->update_multiple('posts', [
            // SET
            'menu_order' => $menu_order,
        ], [
            // WHERE
            'ID' => $id,
        ], [
            'debug_backtrace' => debug_backtrace()[1]['function'],
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            // mặc định sẽ remove các field không có trong bảng, nếu muốn bỏ qua chức năng này thì kích hoạt no_remove_field
            //'no_remove_field' => 1
        ]);

        if ($result_id !== false) {
            $this->result_json_type([
                'ok' => __LINE__,
                'data' => $_POST
            ]);
        }

        //
        $this->result_json_type([
            'code' => __LINE__,
            'error' => 'Lỗi cập nhật số thứ tự cho bài viết!'
        ]);
    }

    /* hàm thay đổi trạng thái bài viết*/
    public function change_post_status()
    {
        $customModel = new CustomCode();
        $id = $this->MY_post('id', 0);
        if ($id <= 0) {
            $this->result_json_type([
                'code' => __LINE__,
                'error' => 'post id is zero!'
            ]);
        }

        //
        $post_status = $this->MY_post('post_status', 0);

        $post = $this->post_model->select_post($id, [
            'post_type' => PostType::POST,
            //'lang_key' => $this->lang_key,
        ]);
        $salaryType = $customModel->getSalaryType($post['post_content']);
        // UPDATE
        $result_id = $this->base_model->update_multiple('posts', [
            // SET
            'post_status' => $post_status,
            'salary_type' => $salaryType
        ], [
            // WHERE
            'ID' => $id,
        ], [
            'debug_backtrace' => debug_backtrace()[1]['function'],
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            // mặc định sẽ remove các field không có trong bảng, nếu muốn bỏ qua chức năng này thì kích hoạt no_remove_field
            //'no_remove_field' => 1
        ]);

        if ($result_id !== false) {
            $this->result_json_type([
                'ok' => __LINE__,
                'data' => $_POST
            ]);
        }

        //
        $this->result_json_type([
            'code' => __LINE__,
            'error' => 'Lỗi cập nhật trạng thái cho bài viết!'
        ]);
    }

    /* hàm lấy danh sách comment của bài viết*/
    public function get_post_comments()
    {
        $id = $this->MY_post('id', 0);
        if ($id <= 0) {
            $this->result_json_type([
                'code' => __LINE__,
                'error' => 'post id is zero!'
            ]);
        }
        $data = $this->base_model->select('comments.comment_date,comments.comment_content,users.member_type,users.user_nicename', 'comments', [
            //'is_deleted' => DeletedStatus::DEFAULT,
            'comment_post_ID' => $id,
            'comment_type' => CommentType::COMMENT,
            //'lang_key' => $this->lang_key
        ], [
            'join'=>[
              'users'=>'users.ID = comments.comment_author'
            ],
            'order_by' => [
                'comments.comment_date' => 'DESC'
            ],
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
//            'limit' => 1
        ]);

        $this->result_json_type([
            'ok' => __LINE__,
            'data' => $data
        ]);

    }

    /* hàm lưu ghi chú cho bài viết*/
    public function save_post_comment()
    {
        $commentModel = new Comment();
        $id = $this->MY_post('id', 0);
        $content = $this->MY_post('content', 0);
        $dataInsert = [
            'comment_post_ID' => $id,
            'comment_content' => $content,
            'comment_author' => $this->session_data['ID']
        ];
        $result_id = $commentModel->insert_comments($dataInsert);
        if ($result_id <= 0) {
            $this->result_json_type([
                'code' => __LINE__,
                'error' => 'Lỗi ko tạo được ghi chú!'
            ]);
        }
        $data = $this->base_model->select('comments.comment_date,comments.comment_content,users.member_type,users.user_nicename', 'comments', [
            //'is_deleted' => DeletedStatus::DEFAULT,
            'comment_post_ID' => $id,
            'comment_type' => CommentType::COMMENT,
            //'lang_key' => $this->lang_key
        ], [
            'join'=>[
                'users'=>'users.ID = comments.comment_author'
            ],
            'order_by' => [
                'comments.comment_date' => 'DESC'
            ],
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
//            'limit' => 1
        ]);

        $this->result_json_type([
            'ok' => __LINE__,
            'data' => $data
        ]);

    }


}
