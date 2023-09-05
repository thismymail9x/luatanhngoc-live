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
    public static function getSalaryType($content)
    {
        // type = 0 là ko tính tiền, type = 10 thì là 20k, type = 20 thì 30k, type = 30 thì là 40k
        // các mốc type Số lượng từ	Thù lao (VND)
        //1.600 -2.200 từ + 2 hình ảnh	20.000/1 bài viết
        //2.200 -3000 từ + 3 hình ảnh	30.000/1 bài viết
        //Trên 3.000 từ + 3 hình ảnh	40.000/1 bài viết
        $type = SALARY_TYPE_0;
        // số lượng thẻ img
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        $numberImg = $dom->getElementsByTagName('img');
        $numberImg = count($numberImg);
        // lấy số lượng từ
        $text = strip_tags($content);
        $text = preg_replace('/\s+/', ' ', $text); // Loại bỏ các khoảng trắng thừa và thay thế bằng một khoảng trắng duy nhất
        $text = trim($text); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
        $words = explode(' ', $text);
        $wordCount = count($words);
        // nếu chỉ có 2 hình ảnh thì chỉ check số từ, đủ điều kiện thì cho type = 2

        if ($numberImg == 2 ) {
            if ($wordCount >= 1600) {
                $type = SALARY_TYPE_1;
            }
        }
        // nếu có 3 hình ảnh thì sẽ check content tương ứng
        if ($numberImg >= 3) {
            if ($wordCount >= 1600 && $wordCount < 2200) {
                $type = SALARY_TYPE_1;
            } elseif ($wordCount >= 2200 && $wordCount < 3000) {
                $type = SALARY_TYPE_2;
            } elseif ($wordCount >= 3000 ) {
                $type = SALARY_TYPE_3;
            }
        }
        return $type;
    }

}
