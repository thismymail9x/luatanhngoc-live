<?php 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->JSON_echo([ 
'post_id' => $data['ID'], 
'post_author' => $data['post_author'], 
]); 
$base_model->adds_js([ 
'javascript/posts_functions.js', 
'themes/' . THEMENAME . '/js/product.js' 
], [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
