<?php 
$base_model->add_css('themes/' . THEMENAME . '/css/page.css', [ 
'cdn' => CDN_BASE_URL, 
]); 
if ($page_template != '') { 
$base_model->add_css(THEMEPATH . 'page-templates/' . $page_template . '.css', [ 
'cdn' => CDN_BASE_URL, 
]); 
$theme_private_view = THEMEPATH . 'page-templates/' . $page_template . '.php'; 
include VIEWS_PATH . 'private_include_view.php'; 
$base_model->add_js(THEMEPATH . 'page-templates/' . $page_template . '.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]); 
} else { 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
} 
$base_model->add_js('themes/' . THEMENAME . '/js/page.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
