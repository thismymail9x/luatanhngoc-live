<?php 
 
if ($debug_enable === true) { 
echo '<div class="wgr-view-path bold">' . str_replace(PUBLIC_HTML_PATH, '', $theme_private_view) . '</div>'; 
} 
include $theme_private_view;
