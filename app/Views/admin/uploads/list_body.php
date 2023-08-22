<?php 
use App\Libraries\PostType; 
foreach ($data as $k => $v) { 
$all_src = []; 
$data_srcset = []; 
$data_width = ''; 
$data_height = ''; 
$src = $upload_model->get_thumbnail($v); 
if (strtolower(explode('/', $v['post_mime_type'])[0]) != 'image') { 
$background_image = ''; 
$attachment_metadata = [ 
'width' => 0, 
]; 
} 
else { 
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
