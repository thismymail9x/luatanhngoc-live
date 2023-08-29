<?php

namespace App\Models;

//
use App\Libraries\ConfigType;
use App\Helpers\HtmlTemplate;

//
class CustomCode extends Post
{
    public $option_prefix = 'lang_';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     * hàm lấy Thứ, + ngày hiện tại
     */
    public function get_current_day()
    {
        // Lấy thứ hiện tại (0: Chủ nhật, 1: Thứ hai, ..., 6: Thứ bảy)
        $dayOfWeek = date('N');
        // Lấy ngày, tháng, năm hiện tại
        $day = date('j');
        $month = date('n');
        $year = date('Y');

        // Mảng để chuyển đổi số thứ trong tuần sang chữ
        $daysOfWeekText = array(
            '', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy', 'Chủ nhật'
        );

        // Định dạng ngày tháng
        $formattedDate = $daysOfWeekText[$dayOfWeek] . ', ' . $day . '/' . $month . '/' . $year;
        return $formattedDate;
    }

    public function the_nodeV2($data, $ops = [], $default_arr = [])
    {
        echo $this->get_the_node($data, $ops, $default_arr);
    }
    // trả về khối HTML của từng bài viết trong danh mục
    public function get_the_node($data, $ops = [], $default_arr = [])
    {
        $option_model = new \App\Models\Option();
        $getconfig = $option_model->list_config();
        //print_r( $getconfig );
        $getconfig = (object) $getconfig;
        $getconfig->cf_posts_size = $this->base_model->get_config($getconfig, 'cf_posts_size', 1);
        // nếu không có col HTML riêng -> dùng col HTML mặc định
        if (!isset($ops['custom_html']) || $ops['custom_html'] == '') {
            $ops['custom_html'] = $this->base_model->get_html_tmp('posts_node_v2');
        }
        $data['dynamic_post_tag'] = 'h3';
        $data['show_post_content'] = '';
        $data['blog_link_option'] = '';
        $data['taxonomy_key'] = '';
        $data['url_video'] = '';
        if (isset($ops['taxonomy_post_size']) && $ops['taxonomy_post_size'] != '') {
            $data['cf_posts_size'] = $ops['taxonomy_post_size'];
        } else {
            $data['cf_posts_size'] = $getconfig->cf_posts_size;
        }
        //echo $data['cf_posts_size'];

        //
        return $this->build_the_node($data, $ops['custom_html'], $ops, $default_arr);
    }
}
