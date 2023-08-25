<?php
/*
* ngôn ngữ hiển thị của website
*/
// các ngôn ngữ được hỗ trợ
/*
define(
    'SITE_LANGUAGE_SUPPORT',
    [
        [
            'value' => 'vn',
            'text' => 'Tiếng Việt',
            'css_class' => 'text-muted'
        ],
        // muốn chạy bao nhiêu ngôn ngữ thì thêm bằng đấy mảng vào đây
        [
            'value' => 'en',
            'text' => 'English',
            'css_class' => 'text-success'
        ],
    ]
);
*/


/*
// khi cần thay label cho trang /admin/translates để dễ hiểu hơn thì thêm các thông số vào đây
define( 'TRANS_TRANS_LABEL', [
    'custom_text0' => 'Bản dịch số 0',
    //'custom_textarea0' => 'Bản dịch số 0',
] );
*/

// khi cần thay label cho trang /admin/nummons để dễ hiểu hơn thì thêm các thông số vào đây
/*
define(
    'TRANS_NUMS_LABEL',
    [
        'custom_num_mon0' => 'Tùy chỉnh số 0',
    ]
);
*/

// khi cần thay label cho trang /admin/checkboxs để dễ hiểu hơn thì thêm các thông số vào đây
/*
define(
    'TRANS_CHECKBOXS_LABEL',
    [
        'custom_checkbox0' => 'Checkbox số 0',
    ]
);
*/

/*
 * Thêm menu cho admin
 * Ngoài các menu mặc định, với mỗi website có thể thêm các menu tùy chỉnh khác nhau vào đây theo công thức mẫu
 */

use App\Libraries\PostType;
use App\Libraries\TaxonomyType;
use App\Libraries\UsersType;
function register_admin_menu()
{
    return [
        CUSTOM_ADMIN_URI => [
            'role' => [ UsersType::ADMIN],
            'name' => 'Tổng quan',
            'icon' => 'fa fa-home',
            'arr' => []
        ],
        'admin/posts' => [
            'role' => [
                UsersType::AUTHOR,
                UsersType::MOD,
            ],
            'arr' => [
                'admin/posts/add' => [
                    'name' => PostType::typeList(PostType::POST),
                    'icon' => 'fa fa-plus',
                ],
                'admin/terms' => [
                    'name' => TaxonomyType::typeList(TaxonomyType::POSTS, true),
                    'icon' => 'fa fa-cubes',
                ],
                'admin/tags' => [
                    'name' => TaxonomyType::typeList(TaxonomyType::TAGS, true),
                    'icon' => 'fa fa-tag',
                ],
            ],
        ],
    ];
}


/*
 * đăng ký taxonomy riêng nếu muốn taxonomy này được public ra ngoài
 */
/*
register_taxonomy('custom_taxonomy', [
    'name' => 'Custom name',
    'set_parent' => true,
    'slug' => '',
    //'public' => 'off',
]);
*/

/*
 * đăng ký taxonomy riêng nếu muốn post type này được public ra ngoài
 */
/*
register_post_type('custom_post_type', [
    'name' => 'Custom name',
    //'public' => 'off',
]);
*/

// URL tùy chỉnh của từng tags hoặc custom taxonomy
//define('WGR_CUS_TAX_PERMALINK', []);