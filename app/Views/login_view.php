<?php 
$base_model->adds_css([ 
'public/css/login.css', 
'themes/' . THEMENAME . '/css/login.css', 
], [ 
'cdn' => CDN_BASE_URL, 
]); 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->JSON_echo([ 
], [ 
'set_login' => $set_login, 
]); 
$base_model->adds_js([ 
'javascript/login.js', 
'themes/' . THEMENAME . '/js/login.js', 
], [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
