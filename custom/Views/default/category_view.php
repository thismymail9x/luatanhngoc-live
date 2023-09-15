<!--<h1 data-type="--><?php //echo $data['taxonomy']; ?><!--" data-id="--><?php //echo $data['term_id']; ?><!--"-->
<!--    class="--><?php //echo $data['taxonomy']; ?><!---taxonomy-title global-taxonomy-title global-module-title text-center">--><?php //echo $data['name']; ?><!--</h1>-->

<?php
//print_r($data);
//die('cc');
$base_model->add_css('themes/' . THEMENAME . '/css/post_node.css', [
    'cdn' => CDN_BASE_URL,
]);

$base_model->add_js('themes/' . THEMENAME . '/js/templates/post.js', [
    'cdn' => CDN_BASE_URL,
], [
    'defer'
]);

// top bài xem nhiều
$in_cache_dataTop = $term_model->key_cache('in_cache_dataTop');
$dataTop = $base_model->scache($in_cache_dataTop);
if (empty($dataTop)) {
    $dataTop = $post_model->get_posts_by([
        'term_id' => $data['term_id']
    ], [
        'limit' => 8,
        'order_by' => [
            'post_viewed' => 'DESC'
        ]
        //'offset' => 0,
    ]);
    //
    $base_model->scache($in_cache_dataTop, $dataTop, 300);
}
?>

<div class="row category__main">
    <div class="col medium-9 small-12 large-9">
        <div class="col-inner">
            <?php
            if (!empty($child_data)) {
                $child_data = $post_model->list_meta_post($child_data);
                ?>
                <div id="term_main"
                     class="posts-list main-posts-list <?php $option_model->posts_in_line($getconfig); ?>">
                    <?php
                    foreach ($child_data as $child_key => $child_val) {
                        if ($child_val === NULL) {
                            continue;
                        }
                        $child_data[$child_key] = NULL;
                        ?>

                        <div class="first__category">
                            <?php $post_model->the_node($child_val, [
                                'taxonomy_post_size' => $taxonomy_post_size,
                                'custom_html' => $term_col_templates,
                            ]); ?>
                        </div>
                        <?php break;
                    }
                    ?>

                    <?php
                    foreach ($child_data as $child_key => $child_val) {
                        if ($child_val === NULL) {
                            continue;
                        }
                        $post_model->the_node($child_val, [
                            'taxonomy_post_size' => $taxonomy_post_size,
                            'custom_html' => $term_col_templates,
                        ]);
                        ?>
                    <?php }
                    ?>

                </div>
                <br>
                <div class="public-part-page"><?php echo $public_part_page; ?></div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="col medium-3 small-12 large-3">
        <div class="col-inner ">
            <?php if (!empty($dataTop)) { ?>
                <h5 class="title__more hide__if-mobile">Bài viết xem nhiều</h5>
                <div class="right-home-top posts-list posts-list100 cf hide__if-mobile">
                    <?php
                    foreach ($dataTop as $k => $v) {
                        $post_model->the_node($v, [
                            //'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                        ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row blog__child">
    <div class="col medium-9 small-12 large-9">
        <div class="col-inner article__content">
            <div class="blog__content short">
                <h1>
                    <?= $data['name'] ?>
                </h1>
                <p>
                    <?= $data['pElement'] ?>
                </p>
                <div class="menuPost">
                    <div id="contentCategory" class="contentCategory collapsed">
                        <div class="item-top">
                            <i class="fa fa-list-ol" style="color: #ffff00;"></i>
                            <span>Mục lục bài viết</span>
                            <i class="fa fa-angle-down icon__rotate" style="color: #ffff00;font-size: 24px;"></i>
                        </div>
                        <div class="item-bottom">
                            <?php foreach (@$data['contentCategory'] as $key => $value) { ?>
                                <p class="parent"><a title="<?= $value['name'] ?>" href="#<?= $value['id'] ?>"><?= $value['name'] ?></a></p>
                                <?php foreach ($value['children'] as $k => $v) { ?>
                                    <p class="children"><a title="<?= $v['name'] ?>" href="#<?= $v['id'] ?>"><?= $v['name'] ?></a></p>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div id="contentPost" class="content">
                    <?= $data['description'] ?>
                </div>
            </div>

            <div class="bg-article"> <span class="btn-seemore">Xem thêm ⮇</span></div>

        </div>

    </div>
</div>

<div class="row">
    <?php
    if ($getconfig->eb_posts_sidebar != '') {
        ?>
        <div class="col-sidebar-content custom-width-global-sidebar custom-width-<?php echo $data['taxonomy']; ?>-sidebar fullsize-if-mobile">
            <div class="global-right-space <?php echo $data['taxonomy']; ?>-right-space">
                <?php
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>

