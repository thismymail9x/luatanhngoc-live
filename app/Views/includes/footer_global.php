<div id="oi_scroll_top" class="default-bg"><i class="fa fa-chevron-up"></i></div> 
<?php 
$base_model->adds_js([ 
'javascript/functions_footer.js', 
'thirdparty/bootstrap/js/bootstrap.min.js', 
'javascript/footer.js', 
'javascript/footer_audio.js', 
'javascript/pagination.js', 
'themes/' . THEMENAME . '/js/d.js' 
], [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]); 
if ($current_user_id > 0 && isset($session_data['userLevel']) && $session_data['userLevel'] > 0 && $session_data['member_type'] == \App\Libraries\UsersType::ADMIN) {
$base_model->add_css('admin/css/show-debug-bar.css', [ 
'cdn' => CDN_BASE_URL, 
]); 
$base_model->add_js('admin/js/show-edit-btn.js', [ 
'cdn' => CDN_BASE_URL, 
], [ 
'defer' 
]); 
} 
$theme_private_view = VIEWS_CUSTOM_PATH . 'get_footer.php'; 
include VIEWS_PATH . 'private_require_view.php'; 
 
if ($getconfig->enable_device_protection == 'on') { 
include_once __DIR__ . '/device_protection.php'; 
} 
echo $getconfig->html_body;
