<?php 
if (!isset($seo)) { 
$seo = $base_model->default_seo('Users', 'users/profile'); 
} 
if (!isset($breadcrumb)) { 
$breadcrumb = ''; 
} 
?> 
<!doctype html> 
<html lang="<?php 
echo (($html_lang == 'vn' || $html_lang == '') ? 'vi' : $html_lang); 
?>" class="no-js no-svg" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"> 
<head> 
<?php
require __DIR__ . '/includes/head_global.php';
$base_model->adds_css(
    [
        'css/users.css',
        'themes/' . THEMENAME . '/css/users.css',

    ],
[ 
'cdn' => CDN_BASE_URL, 
] 
);
?>
</head> 
<body class="page_dark <?php echo $seo['body_class']; ?> is-<?php echo $current_user_type; ?>">
<?php 
echo $header; 
echo $breadcrumb; 
 
include __DIR__ . '/includes/msg_view.php'; 
 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
echo $footer; 
 
require __DIR__ . '/includes/footer_global.php'; 
?>
<iframe id="target_eb_iframe" name="target_eb_iframe" title="EB iframe" src="about:blank" width="99%" height="550" frameborder="0">AJAX form</iframe>
</body> 
</html>
