<?php 
$base_model->add_css('themes/' . THEMENAME . '/css/home.css', [ 
'cdn' => CDN_BASE_URL, 
]); 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->add_js('themes/' . THEMENAME . '/js/home.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
