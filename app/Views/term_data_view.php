<?php 
if ($debug_enable === true) { 
echo '<div class="wgr-view-path">' . str_replace(PUBLIC_HTML_PATH, '', __FILE__) . '</div>'; 
} 
$totalThread = $data['count'];
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
 
$in_cache = 'view-' . $post_type . '-' . $offset . '-' . $post_per_page; 
$child_data = $term_model->the_cache($data['term_id'], $in_cache); 
$child_data = NULL; 
if ($child_data === NULL) { 
$child_data = $post_model->post_category($post_type, $data, [ 
'offset' => $offset, 
'limit' => $post_per_page 
]);

if (empty($child_data)) { 
$totalThread = $post_model->fix_term_count($data, $post_type); 
} 
else { 
 
$term_model->the_cache($data['term_id'], $in_cache, $child_data); 
} 
} 
} else { 
$public_part_page = ''; 
$child_data = []; 
}
