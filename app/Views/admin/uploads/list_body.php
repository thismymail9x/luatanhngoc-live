<?php

use App\Libraries\PostType;

foreach ($data as $k => $v) {
    $all_src = [];
    $data_srcset = [];
    $data_width = '';
    $data_height = '';
    $src = $upload_model->get_thumbnail($v);
    $mimeType = explode('/', $v['post_mime_type']);
//    print_r($mimeType);
//    die('cc');
    // nếu là tệp word thì đổ ra hình ảnh tệp word
    if (strtolower($mimeType[0]) == 'application' && strtolower($mimeType[1]) == 'msword') {
        $attachment_metadata = [
            'width' => 0,
        ];
        $src = base_url() . 'public/images/word.png';
        $background_image = 'background-image: url(\'' . $src . '\');';
    } // nếu là tệp excel thì đổ ra hình ảnh tệp excel
    elseif (strtolower($mimeType[0]) == 'application' && strtolower($mimeType[1]) == 'pdf') {
        $attachment_metadata = [
            'width' => 0,
        ];
        $src = base_url() . 'public/images/pdf.png';
        $background_image = 'background-image: url(\'' . $src . '\');';
    } // nếu là tệp pdf thì đổ ra hình ảnh tệp pdf
    elseif (strtolower($mimeType[0]) == 'application' && strtolower($mimeType[1]) == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        $attachment_metadata = [
            'width' => 0,
        ];
        $src = base_url() . 'public/images/excel.png';
        $background_image = 'background-image: url(\'' . $src . '\');';
    } elseif(strtolower($mimeType[0]) == 'image') {
        $background_image = 'background-image: url(\'' . $src . '\');';
        if ($str_insert_to != '') {
            $all_src = $upload_model->get_all_media($v);
        }
        if ($v['post_type'] == PostType::WP_MEDIA) {
            $short_uri = PostType::WP_MEDIA_URI;
        } else {
            $short_uri = PostType::MEDIA_URI;
        }
        if (isset($v['post_meta']) && isset($v['post_meta']['_wp_attachment_metadata'])) {
            $attachment_metadata = unserialize($v['post_meta']['_wp_attachment_metadata']);
            if ($attachment_metadata['width'] > 0) {
                $data_srcset = [
                    $short_uri . $attachment_metadata['file'] . ' ' . $attachment_metadata['width'] . 'w'
                ];
            }
            foreach ($attachment_metadata['sizes'] as $k_sizes => $sizes) {
                if (isset($sizes['width'])) {
                    if ($k_sizes == 'large') {
                        $data_width = $sizes['width'];
                        $data_height = $sizes['height'];
                    }
                    $data_srcset[] = $short_uri . $sizes['file'] . ' ' . $sizes['width'] . 'w';
                }
            }
        } else {
            $attachment_metadata['width'] = 0;
        }
    } else {
        $attachment_metadata = [
            'width' => 0,
        ];
        $src = base_url() . 'public/images/other.png';
        $background_image = 'background-image: url(\'' . $src . '\');';
    }
    $all_src['thumbnail'] = $src;
    ?>
    <li data-id="<?php echo $v['ID']; ?>">
        <?php
        include __DIR__ . '/' . $inc_style . '.php';
        ?>
    </li>
    <?php
}
