<?php

namespace App\Models;

//
//use App\Libraries\DeletedStatus;
use App\Libraries\UsersType;
//
class User extends UserMeta
{
    public function __construct()
    {
        parent::__construct();
    }

    private function sync_pass($data)
    {
        // nếu có pass -> tiến hành đồng bộ pass
        if (isset($data['ci_pass'])) {
            // đồng bộ về 1 định dạng pass
            if ($data['ci_pass'] != '') {
                // tạo mật khẩu cho wordpress
                $data['user_pass'] = md5($data['ci_pass']);
                // với 1 số website sẽ cho lưu pass dưới dạng có thể giải mã
                $data['ci_unpass'] = $this->base_model->wgr_encode($data['ci_pass']);

                // sử dụng hàm md5 tự viết
                //$data[ 'ci_pass' ] = md5( $data[ 'ci_pass' ] );
                $data['ci_pass'] = $this->base_model->mdnam($data['ci_pass']);
            }
            // hoặc bỏ qua việc cập nhật nếu không có dữ liệu
            else {
                unset($data['ci_pass']);
                if (isset($data['user_pass'])) {
                    unset($data['user_pass']);
                }
            }
        }
        if (isset($data['user_email'])) {
            $data['user_email'] = strtolower($data['user_email']);
            $data['user_email'] = str_replace('www.', '', $data['user_email']);
        }
        if (isset($data['user_phone'])) {
            $data['user_phone'] = str_replace(' ', '', $data['user_phone']);
            $data['user_phone'] = trim($data['user_phone']);
        }

        //
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = implode(',', $v);
            }
        }

        //
        return $data;
    }

    /*
     * check_exist: mặc định sẽ check 1 số dữ liệu xem đã được dùng rồi hay chưa
     */
    public function insert_member($data, $check_exist = true)
    {
        // các dữ liệu mặc định
        $default_data = [
            'user_registered' => date(EBE_DATETIME_FORMAT),
        ];
        $default_data['last_updated'] = $default_data['user_registered'];

        // kiểm tra email đã được sử dụng chưa
        if ($check_exist === true && $this->check_user_exist($data['user_email']) !== false) {
            return -1;
        }

        //
        if (!isset($data['user_login']) || $data['user_login'] == '') {
            //echo __CLASS__ . ':' . __LINE__ . '<br>' . PHP_EOL;
            //echo $data[ 'user_email' ] . '<br>' . PHP_EOL;
            $data['user_login'] = $this->generate_user_login($data['user_email']);
            //echo $data[ 'user_login' ] . '<br>' . PHP_EOL;
            // tự động tạo user login thì sẽ tiến hành thêm số vào sau
            $data['user_login'] = $this->check_user_login_exist($data['user_login']);
        } else {
            // còn gán cứng user login thì chỉ báo đã đc sử dụng
            $data['user_login'] = $this->check_user_login_exist($data['user_login'], false);
            if ($data['user_login'] === false) {
                return -1;
            }
        }
        // mã hóa mật khẩu
        $data = $this->sync_pass($data);

        //
        foreach ($default_data as $k => $v) {
            if (!isset($data[$k])) {
                $data[$k] = $v;
            }
        }

        // insert
        //print_r( $data );
        $result_id = $this->base_model->insert($this->table, $data, true);

        //
        return $result_id;
    }

    /*
     * check_exist: mặc định sẽ check 1 số dữ liệu xem đã được dùng rồi hay chưa
     */
    public function update_member($id, $data, $where = [], $check_exist = true)
    {
        if (isset($data['user_login'])) {
            if ($data['user_login'] == '') {
                if (isset($data['user_email']) && $data['user_email'] != '') {
                    $data['user_login'] = $this->generate_user_login($data['user_email']);
                    $data['user_login'] = $this->check_user_login_exist($data['user_login']);
                } else {
                    return 'User login is empty!';
                }
            } else {
                // kiểm tra email này đã có ai dùng chưa
                $check__exist = $this->check_another_user_by($id, 'user_login', $data['user_login']);

                if ($check__exist !== true) {
                    return $check__exist;
                }
            }
        }
        if (!isset($data['last_updated']) || $data['last_updated'] == '') {
            $data['last_updated'] = date(EBE_DATETIME_FORMAT);
        }

        // mã hóa mật khẩu
        $data = $this->sync_pass($data);

        // nếu có email
        if ($check_exist === true && isset($data['user_email'])) {
            // email không được để trống
            if ($data['user_email'] != '') {
                // kiểm tra email này đã có ai dùng chưa
                $check__exist = $this->check_another_user_by($id, 'user_email', $data['user_email']);

                if ($check__exist !== true) {
                    return $check__exist;
                }
            }
            // trống thì return luôn
            else {
                //print_r( $data );
                //die( __CLASS__ . ':' . __LINE__ );
                return 'User email is empty!';
            }
        }

        //
        $where['ID'] = $id;
        //print_r($data);
        //print_r( $where );
        //die(__CLASS__ . ':' . __LINE__);

        //
        $result_update = $this->base_model->update_multiple($this->table, $data, $where, [
            'debug_backtrace' => debug_backtrace()[1]['function'],
            // hiển thị mã SQL để check
            //'show_query' => 1,
        ]);

        //
        return $result_update;
    }
    /**
     * Trả về dữ liệu của 1 user dựa theo ID truyền vào
     **/
    public function get_user_by_id($id, $where = [], $add_filter = [])
    {
        $where['ID'] = $id;
        $filter = [
            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            // trả về COUNT(column_name) AS column_name
            //'selectCount' => 'ID',
            // trả về tổng số bản ghi -> tương tự mysql num row
            //'getNumRows' => 1,
            //'offset' => 0,
            'limit' => 1
        ];
        foreach ($add_filter as $k => $v) {
            $filter[$k] = $v;
        }

        //
        $data = $this->base_model->select(
            '*',
            'users',
            $where,
            $filter
        );
        //print_r($data);
        $data = $this->sync_login_data($data);
        //print_r($data);

        //
        return $data;
    }

    /**
     * đồng bộ dữ liệu login của thành viên về 1 định dạng chung
     **/
    public function sync_login_data($result)
    {
        $result['user_pass'] = '';
        $result['ci_pass'] = '';
        // hỗ trợ phiên bản code cũ -> tạo thêm dữ liệu tương ứng
        $result['userID'] = $result['ID'];
        $result['userName'] = $result['display_name'];
        $result['userEmail'] = $result['user_email'];
        // quyền admin
        $arr_admin_group = [
            UsersType::AUTHOR,
            UsersType::MOD,
            UsersType::ADMIN,
        ];
        if (in_array($result['member_type'], $arr_admin_group)) {
            $result['userLevel'] = UsersType::ADMIN_LEVEL;
        } else {
            $result['userLevel'] = UsersType::GUEST_LEVEL;
        }
        //print_r($result);
        //die(__CLASS__ . ':' . __LINE__);

        //
        return $result;
    }
}
