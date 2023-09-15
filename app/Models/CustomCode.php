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
        $getconfig = (object)$getconfig;
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

    /* hàm tính kpi cho bài viết*/
    public function getSalaryType($content, $description = '')
    {
        // type = 0 là ko tính tiền, type = 10 thì là 20k, type = 20 thì 30k, type = 30 thì là 40k
        // các mốc type Số lượng từ	Thù lao (VND)
        //1.600 -2.200 từ + 2 hình ảnh	20.000/1 bài viết
        //2.200 -3000 từ + 3 hình ảnh	30.000/1 bài viết
        //Trên 3.000 từ + 3 hình ảnh	40.000/1 bài viết
        $type = SALARY_TYPE_0;
        $wordCount = 0;
        if ($content != '') {
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
        }
        // check thêm đếm cả số lượng từ của phần mô tả
        if ($description != '') {
            // lấy số lượng từ
            $textDescription = strip_tags($description);
            $textDescription = preg_replace('/\s+/', ' ', $textDescription); // Loại bỏ các khoảng trắng thừa và thay thế bằng một khoảng trắng duy nhất
            $textDescription = trim($textDescription); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
            $wordsDescription = explode(' ', $textDescription);
            $wordCountDescription = count($wordsDescription);
            $wordCount += $wordCountDescription;
        }

        // nếu chỉ có 2 hình ảnh thì chỉ check số từ, đủ điều kiện thì cho type = 2
        if ($numberImg == 2) {
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
            } elseif ($wordCount >= 3000) {
                $type = SALARY_TYPE_3;
            }
        }
        return $type;
    }

    // hàm tạo thẻ h2 h3 là danh mục cho bài viết
    public function createCategoryArray($content)
    {
        $category_array = array();
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
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
            $content = $dom->saveHTML();
        }
        return array('category_array' => $category_array, 'post_content' => $content);
    }

    /*hàm lấy 3 thẻ p đầu tiên*/
    public function getPElement($content)
    {
        // Tạo một đối tượng DOMDocument
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

        // Lấy thẻ <p> đầu tiên
        $paragraph = $dom->getElementsByTagName('p')->item(0);

        // Khai báo một biến để lưu trữ giá trị của chuỗi con
        $paragraphValue = '';

        // Nếu có thẻ <p> đầu tiên
        if ($paragraph !== null) {
            // Lấy giá trị của thẻ <p>
            $paragraphValue = $paragraph->nodeValue;

            // Xóa thẻ <p> khỏi cây DOM
            $paragraph->parentNode->removeChild($paragraph);
        }

        // Chuyển cây DOM thành chuỗi
        $modifiedHtml = $dom->saveHTML();

        return [
            'content' => $modifiedHtml,
            'pElement' => $paragraphValue,
        ];

    }

    /* hàm chuyển tiếng việt sang slug*/
    public function convert_vi_to_en_slug($str, $number = false)
    {
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
        $str = str_replace(" ", "-", str_replace("&*#39;", "", $str));
        if ($number == true) {
            $first_char = substr($str, 0, 1);
            if (is_numeric($first_char)) {
                $str = "_" . $str;
            }
        }
        $str = str_replace("?", "-", str_replace("&*#39;", "", $str));
        $str = preg_replace("/[.,?!]/", "-", $str);
        $str = strtolower($str);
        return $str;
    }

    // hàm làm cả 3 tác vu tạo thẻ h2 h3 là danh mục cho bài viết,lấy 1 thẻ p đầu tiên và xóa thẻ p đó khỏi content
    // chỉ áp dụng cho danh mục bài viết
    public function processContent($content)
    {
        // Tạo một đối tượng DOMDocument
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

        // Xử lý tạo mảng danh mục
        $category_array = array();
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
        }

        // Xử lý lấy thẻ <p> đầu tiên
        $paragraph = $dom->getElementsByTagName('p')->item(0);
        $paragraphValue = '';

        if ($paragraph !== null) {
            $paragraphValue = $paragraph->nodeValue;
            $paragraph->parentNode->removeChild($paragraph);
        }

        // Chuyển cây DOM thành chuỗi
        $modifiedHtml = $dom->saveHTML();

        return [
            'category_array' => $category_array,
            'content' => $modifiedHtml,
            'pElement' => $paragraphValue,
        ];
    }

    // hàm random giá trị
    public function getRandomValue($value = [], $type = '')
    {

    }

    public function getDataChart($where)
    {
       return $this->base_model->select("user_nicename, 
        SUM(CASE WHEN (post_status != 'publish' AND post_status != 'trash') THEN 1 ELSE 0 END) AS non_public,
        SUM(CASE WHEN post_status = 'publish' THEN 1 ELSE 0 END) AS public,
        SUM(CASE WHEN post_status = 'publish' AND salary_type = ".SALARY_TYPE_0." THEN 1 ELSE 0 END) AS type0,
        SUM(CASE WHEN post_status = 'publish' AND salary_type = ".SALARY_TYPE_1." THEN 1 ELSE 0 END) AS type1,
        SUM(CASE WHEN post_status = 'publish' AND salary_type = ".SALARY_TYPE_2." THEN 1 ELSE 0 END) AS type2,
        SUM(CASE WHEN post_status = 'publish' AND salary_type = ".SALARY_TYPE_3." THEN 1 ELSE 0 END) AS type3
        ",WGR_POST_VIEW,$where,[
            'group_by'=>['post_author'],
        ]);
    }
}
