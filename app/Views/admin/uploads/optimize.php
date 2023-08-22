<?php 
use App\Libraries\PostType; 
use App\Libraries\MyImage; 
$max_quality_img = 250000; 
$max_size_img = 0; 
?> 
<ul class="admin-breadcrumb"> 
<li>Danh sách Tối ưu hóa hình ảnh ( 
<?php echo $totalThread; ?>) 
</li> 
</ul> 
<p class="medium">Chức năng tối ưu hóa hình ảnh vượt quá <strong> 
<?php echo ($max_quality_img / 1000); ?> 
</strong>kb</p> 
<div class="public-part-page"> 
<?php echo $pagination; ?> Trên tổng số 
<?php echo $totalThread; ?> bản ghi 
( 
<?php echo $totalPage; ?> trang). 
</div> 
<?php 
if (class_exists('Imagick')) { 
?> 
<p class="medium grrencolor"><strong>Imagick</strong> enable</p> 
<?php 
} 
foreach ($data as $k => $v) { 
$attachment_metadata = unserialize($v['post_meta']['_wp_attachment_metadata']); 
if ($v['post_type'] == PostType::WP_MEDIA) { 
$uri = PostType::WP_MEDIA_URI; 
} else { 
$uri = PostType::MEDIA_URI; 
} 
$file_path = PUBLIC_PUBLIC_PATH . $uri . $attachment_metadata['file']; 
$file_size = filesize($file_path); 
if ($file_size < $max_quality_img) { 
echo $file_path . ' (' . ceil($file_size / 1000) . ')<br>' . PHP_EOL; 
$img_src = str_replace(PUBLIC_PUBLIC_PATH, '', $file_path); 
echo '<a href="' . $img_src . '" target="_blank" class="bluecolor">' . $img_src . ' (' . ceil($file_size / 1000) . ')</a> <br>' . PHP_EOL; 
continue; 
} 
$attachment_metadata['file_size'] = $file_size; 
$get_file_info = getimagesize($file_path); 
if ($max_size_img > 0 && $get_file_info[0] > $max_size_img && $get_file_info[1] > $max_size_img) { 
if ($get_file_info[0] > $max_size_img) { 
MyImage::resize($file_path, '', $max_size_img); 
} 
else if ($get_file_info[1] > $max_size_img) { 
MyImage::resize($file_path, '', 0, $max_size_img); 
} 
} 
$dir_path = dirname($file_path) . '/'; 
$dst_file = $file_path; 
echo $dst_file . ' (' . ceil($file_size / 1000) . ')<br>' . PHP_EOL; 
MyImage::quality($file_path, $dst_file, $attachment_metadata['width'], $attachment_metadata['height']); 
$img_src = str_replace(PUBLIC_PUBLIC_PATH, '', $dst_file); 
clearstatcache(); 
echo '<a href="' . $img_src . '" target="_blank" class="greencolor">' . $img_src . ' (' . ceil(filesize($dst_file) / 1000) . ')</a> <br>' . PHP_EOL; 
foreach ($attachment_metadata['sizes'] as $k2 => $v2) { 
if ($v2['width'] < $attachment_metadata['width']) { 
continue; 
} 
$file2_path = $dir_path . $v2['file']; 
$file2_size = filesize($file2_path); 
if ($file2_size < $max_quality_img) { 
continue; 
} 
$dst_file = $file2_path; 
echo $dst_file . ' (' . ceil($file2_size / 1000) . ')<br>' . PHP_EOL; 
MyImage::quality($file2_path, $dst_file, $v2['width'], $v2['height']); 
$img_src = str_replace(PUBLIC_PUBLIC_PATH, '', $dst_file); 
clearstatcache(); 
echo '<a href="' . $img_src . '" target="_blank" class="greencolor">' . $img_src . ' (' . ceil(filesize($dst_file) / 1000) . ')</a> <br>' . PHP_EOL; 
} 
} 
$base_model->JSON_echo( 
[ 
'totalPage' => $totalPage, 
], 
[ 
] 
); 
$base_model->add_js('admin/js/optimize.js');
