<?php 
include VIEWS_PATH . 'includes/user_menu.php';
if ($session_data['member_type'] != \App\Libraries\UsersType::GUEST) {
    $menu_model->the_menu( 'user-profile-menu' );
}
