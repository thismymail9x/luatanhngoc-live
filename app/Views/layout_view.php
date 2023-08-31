<!doctype html> 
<html lang="<?php 
echo (($html_lang == 'vn' || $html_lang == '') ? 'vi' : $html_lang); 
?>" data-lang="<?php echo $html_lang; ?>" data-default-lang="<?php echo SITE_LANGUAGE_DEFAULT; ?>" class="no-js no-svg" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"> 
<head> 
<?php 
 
require __DIR__ . '/includes/head_global.php'; 
?> 
<script> 
redirect_to_canonical('<?php echo $seo['body_class']; ?>'); 
</script> 
<?php 
if ($seo['body_class'] == 'home') { 
$lang_model->the_text('home_schema', '<!-- -->'); 
} 
if (isset($seo['dynamic_schema'])) { 
echo $seo['dynamic_schema']; 
} 
?>

</head> 
<body data-session="<?php echo session_id(); ?>" class="page_dark <?php echo $seo['body_class']; ?> is-<?php echo $current_user_type . ' ' . $current_user_logged; ?>">
<?php 
echo $header; 
echo $breadcrumb; 
include __DIR__ . '/includes/msg_view.php'; 
?> 
<main id="main" role="main"> 
<?php 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
?> 
</main> 
<?php 
echo $footer; 
require __DIR__ . '/includes/footer_global.php'; 
?> 
</body> 
</html>
