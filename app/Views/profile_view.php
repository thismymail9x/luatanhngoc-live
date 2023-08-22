<?php 
$base_model->add_css( 
'css/user-profile.css', 
[ 
'cdn' => CDN_BASE_URL, 
] 
); 
 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
$base_model->adds_js([ 
'javascript/uploads.js', 
'javascript/user-profile.js', 
'javascript/datetimepicker.js', 
], [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
