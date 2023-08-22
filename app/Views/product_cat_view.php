<?php 
 
$post_per_page = $base_model->get_config($getconfig, 'eb_products_per_page', 20); 
include __DIR__ . '/term_data_view.php'; 
 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->adds_js([ 
'javascript/taxonomy.js', 
'themes/' . THEMENAME . '/js/taxonomy.js', 
'themes/' . THEMENAME . '/js/' . $taxonomy . '_taxonomy.js', 
], [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
