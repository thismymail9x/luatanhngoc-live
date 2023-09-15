<?php


$post_per_page = $base_model->get_config($getconfig, 'eb_posts_per_page', 20);
include __DIR__ . '/term_data_view.php'; 
$term_template = '';

if (isset($data['term_meta']['term_template']) && $data['term_meta']['term_template'] != '') { 
$term_template = $data['term_meta']['term_template']; 
} 
$term_col_templates = ''; 
if (isset($data['term_meta']['term_col_templates']) && $data['term_meta']['term_col_templates'] != '') { 
$term_col_templates = file_get_contents(THEMEPATH . 'term-col-templates/' . $data['term_meta']['term_col_templates'], 1); 
} 
if ($term_template != '') { 
$base_model->add_css(THEMEPATH . 'term-templates/' . $term_template . '.css', [ 
'cdn' => CDN_BASE_URL, 
]); 
$theme_private_view = THEMEPATH . 'term-templates/' . $term_template . '.php'; 
include VIEWS_PATH . 'private_include_view.php'; 
$base_model->add_js(THEMEPATH . 'term-templates/' . $term_template . '.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]); 
} else {

$theme_default_view = VIEWS_PATH . 'default/' . $taxonomy . '_view.php'; 
include VIEWS_PATH . 'private_view.php'; 
} 
$base_model->adds_js([ 
'javascript/taxonomy.js', 
'themes/' . THEMENAME . '/js/taxonomy.js', 
'themes/' . THEMENAME . '/js/' . $taxonomy . '_taxonomy.js', 
], [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
