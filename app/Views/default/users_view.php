<div class="row global-profile-main"> 
<?php 
if ( $isMobile == true ) { 
include __DIR__ . '/users_mobile_menu.php'; 
} else { 
?> 
<div class="col small-12 medium-3 large-3 global-profile-menu"> 
<?php 
include __DIR__ . '/users_menu.php'; 
?> 
</div> 
<?php 
} 
?> 
<div class="col small-12 medium-9 large-9 global-profile-content"> 
<?php 
echo $main; 
?> 
</div> 
</div>
