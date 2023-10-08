<?php
/*
 * Bạn có thể tự viết thêm Routes vào đây (ghi đè Routes gốc)
 * Lưu ý: custom routes phải đứng trước routes của code gốc thì mới ghi đè được
 */
// ví dụ -> thay thế home
$routes->get('/c/lists', 'C::lists',['filter' => 'auth']);
$routes->post('/c/receivePost', 'C::receivePost',['filter' => 'auth']);
$routes->post('/c/sendAccept', 'C::sendAccept',['filter' => 'auth']);
$routes->get('/c/statistic', 'C::statistic',['filter' => 'auth']);
$routes->get('/c/user_add', 'C::user_add',['filter' => 'auth']);
