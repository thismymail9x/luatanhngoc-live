<?php 
 
 
$theme_private_view = VIEWS_CUSTOM_PATH . 'default/' . $post_type . '-' . basename(__FILE__); 
if (file_exists($theme_private_view)) { 
include $theme_private_view; 
$base_model->add_js('themes/' . THEMENAME . '/js/search-' . $post_type . '.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]); 
} 
else { 
$search_type_view = __DIR__ . '/' . $post_type . '-' . basename(__FILE__); 
if (file_exists($search_type_view)) { 
include $search_type_view; 
$base_model->add_js('themes/' . THEMENAME . '/js/search-' . $post_type . '.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]); 
} 
else { 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
} 
} 
$base_model->add_js('themes/' . THEMENAME . '/js/search.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]);
