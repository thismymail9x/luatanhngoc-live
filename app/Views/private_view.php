<?php 
 
$theme_private_view = str_replace(VIEWS_PATH, VIEWS_CUSTOM_PATH, $theme_default_view); 
if (file_exists($theme_private_view)) { 
include __DIR__ . '/private_include_view.php'; 
} 
else { 
if ($debug_enable === true) { 
echo '<div class="wgr-view-path">' . str_replace(PUBLIC_HTML_PATH, '', $theme_default_view) . '</div>'; 
} 
include $theme_default_view; 
}
