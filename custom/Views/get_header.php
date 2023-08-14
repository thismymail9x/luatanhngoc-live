<?php
/*
 * file header riêng của từng theme
 * giả lập tương tự như hàm get_header() của wordpress
 * nếu có file này trong theme -> nó sẽ được nạp vào cuối </head>
 */

//
use App\Libraries\TaxonomyType;

//
$base_model->JSON_echo([
    'arr_category_taxonomy' => $term_model->get_json_taxonomy(TaxonomyType::POSTS, 0, [
        'get_child' => 1,
    ],
        TaxonomyType::POSTS . '_get_child'),
]);

?>
<script>
var TaxonomyType_POSTS = '<?php echo TaxonomyType::POSTS; ?>';
var arr_all_taxonomy = {
    '<?php echo TaxonomyType::POSTS; ?>': arr_category_taxonomy,
};
</script>