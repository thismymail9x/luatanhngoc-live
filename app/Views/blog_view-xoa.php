<?php 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->add_js('themes/' . THEMENAME . '/js/blog_details.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
