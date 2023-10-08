<?php

namespace App\Controllers\Admin;

//
use App\Libraries\PostType;
use App\Libraries\UsersType;
use App\Models\CustomCode;
use App\Models\Post;
use App\Models\User;

class Statisticals extends Admin
{
    protected $list_view_path = 'statisticals';
    protected $controller_slug = 'statisticals';
    protected $postModel = '';
    protected $userModel = '';
    protected $customModel = '';

    public function __construct()
    {
        parent::__construct();

        // kiểm tra quyền truy cập của tài khoản hiện tại
        $this->check_permision(__CLASS__);
        $this->customModel = new CustomCode();
        $this->userModel = new User();
    }

    public function index()
    {
        return $this->lists();
    }

    public function lists()
    {
        $author_id = $this->MY_get('author_id');
        $start_date = $this->MY_get('start_date');
        $end_date = $this->MY_get('end_date');
        // các kiểu điều kiện where
        // theo ngày bắt đầu duyệt bài
        if (!isset($start_date) || $start_date == '') {
            $where['post_success >='] = date('Y-m-01');
            $start_date = date('Y-m-01');
        } else {
            $where['post_success >='] = date('Y-m-d', strtotime($start_date));
        }
        // theo ngày kết thúc duyệt bài
        if (!isset($end_date) || $end_date == '') {
            $where['post_success <='] = date('Y-m-t 23:59:00');
            $end_date = date('Y-m-t');
        } else {
            $where['post_success <='] = date('Y-m-d 23:59:00', strtotime($end_date));
        }
        // tìm theo người
        if (!isset($author_id) || $author_id != '') {
            $where['post_author'] = $author_id;
        }
        // check nếu ko là admin thì chỉ lấy dữ liệu của chính author đấy
        if ($this->session_data['member_type'] != UsersType::ADMIN) {
            $where['post_author'] = $this->session_data['ID'];
        }
        // user bị xóa sẽ không lấy nữa
        $where['user_deleted'] = 0;
        $where['post_type'] = PostType::POST;
        // ko lấy dữ liệu của admin
        // $where['member_type'] = UsersType::ADMIN;
        $dataPosts = $this->customModel->getDataChart($where);
        if ($this->session_data['member_type'] != UsersType::ADMIN) {
            $authors = $this->base_model->select('*', 'users', ['is_deleted' => 0,'ID'=>$this->session_data['ID']]);
        } else {
            $authors = $this->base_model->select('*', 'users', ['is_deleted' => 0]);
        }
        $totalPost = 0;
        $public = 0;
        $nonPublic = 0;
        $type0 = 0;
        $type1 = 0;
        $type2 = 0;
        $type3 = 0;
        if (!empty($dataPosts)) {
            foreach ($dataPosts as $k => $v) {
                $totalPost += $v['non_public'] + $v['public'];
                $public += $v['public'];
                $nonPublic += $v['non_public'];
                $type0 += $v['type0'];
                $type1 += $v['type1'];
                $type2 += $v['type2'];
                $type3 += $v['type3'];
            }
        }

        $salary0 = $type0 * SALARY_TYPE[SALARY_TYPE_0];
        $salary1 = $type1 * SALARY_TYPE[SALARY_TYPE_1];
        $salary2 = $type2 * SALARY_TYPE[SALARY_TYPE_2];
        $salary3 = $type3 * SALARY_TYPE[SALARY_TYPE_3];
        $salary = $salary0 + $salary1 + $salary2 + $salary3;

        $this->teamplate_admin['content'] = view('admin/' . $this->list_view_path . '/kpi', array(
            'list_view_path' => $this->list_view_path,
            'controller_slug' => $this->controller_slug,
            'session_data' => $this->session_data,
            'author' => $authors,
            'dataPosts' => $dataPosts,
            'totalPost' => $totalPost,
            'public' => $public,
            'nonPublic' => $nonPublic,
            'type0' => $type0,
            'type1' => $type1,
            'type2' => $type2,
            'type3' => $type3,
            'salary0' => $salary0,
            'salary1' => $salary1,
            'salary2' => $salary2,
            'salary3' => $salary3,
            'salary' => $salary,
            'dataSearch' => [
                'author_id' => $author_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ],
        ));
        return view('admin/admin_teamplate', $this->teamplate_admin);
    }

    // hiển thị chi tiết 1 comment/ liên hệ
    protected function details($comment_id)
    {
        //echo $comment_id . '<br>' . PHP_EOL;

        //
        $data = $this->base_model->select('*', 'comments', [
            //'is_deleted' => DeletedStatus::DEFAULT,
            'comment_ID' => $comment_id,
            'comment_type' => $this->comment_type,
            //'lang_key' => $this->lang_key
        ], [
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
            'limit' => 1
        ]);
        //print_r( $data );

        //
        if ($this->debug_enable === true) {
            echo '<!-- ';
            print_r($data);
            echo ' -->';
        }

        //
        $this->teamplate_admin['content'] = view('admin/' . $this->add_view_path . '/details', array(
            'data' => $data,
            'vue_data' => [
                'controller_slug' => $this->controller_slug,
                'comment_name' => $this->comment_name,
            ],
        ));
        return view('admin/admin_teamplate', $this->teamplate_admin);
    }

}
