<?php

echo $taxonomy_slider; 
 
if ( 
$getconfig->show_child_category == 'on' && 
isset($data['child_term']) && 
!empty($data['child_term']) 
) { 
 
$theme_default_view = VIEWS_PATH . 'default/category_child_view.php'; 
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

}
else { 
if ($debug_enable === true) { 
echo '<div class="wgr-view-path">' . str_replace(PUBLIC_HTML_PATH, '', __DIR__ . '/term_view.php') . '</div>'; 
} 
include __DIR__ . '/term_view.php'; 
}