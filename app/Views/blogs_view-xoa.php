<?php 
echo $taxonomy_slider; 
 
 
$post_per_page = $base_model->get_config($getconfig, 'eb_blogs_per_page', 10); 
$totalThread = $post_model->count_blogs_by($data); 
if ($totalThread > 0) { 
$totalPage = ceil($totalThread / $post_per_page); 
if ($totalPage < 1) { 
$totalPage = 1; 
} 
if ($ops['page_num'] > $totalPage) { 
$ops['page_num'] = $totalPage; 
} else if ($ops['page_num'] < 1) { 
$ops['page_num'] = 1; 
} 
$offset = ($ops['page_num'] - 1) * $post_per_page; 
$public_part_page = $base_model->EBE_pagination($ops['page_num'], $totalPage, $term_model->get_term_permalink($data)); 
} else { 
$public_part_page = ''; 
} 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->add_js('themes/' . THEMENAME . '/js/blogs_list.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
