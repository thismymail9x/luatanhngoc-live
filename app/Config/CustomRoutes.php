<?php
/*
 * Bạn có thể tự viết thêm Routes vào đây (ghi đè Routes gốc)
 * Lưu ý: custom routes phải đứng trước routes của code gốc thì mới ghi đè được
 */
// ví dụ -> thay thế home
$routes->get('/c/lists', 'C::lists');
$routes->post('/c/receivePost', 'C::receivePost',['filter' => 'auth']);
$routes->post('/c/sendAccept', 'C::sendAccept',['filter' => 'auth']);
$routes->get('/c/statistic', 'C::statistic');
$routes->get('/c/user_add', 'C::user_add');
$routes->get('tacgia/list', 'Tacgia::list');
$routes->get('tacgia/join', 'Tacgia::join');
$routes->get('tacgia/trial', 'Tacgia::trial');// view tạo test

if (WGR_AUTHOR_PERMALINK != '%slug%') {
    $a = str_replace('%slug%', '(:segment)', WGR_AUTHOR_PERMALINK);
    $routes->get($a, 'Tacgia::author/$1');
    // $routes->get($a . '/page/(:num)', 'AuthorCustom::category_list/$1/page/$2');
}