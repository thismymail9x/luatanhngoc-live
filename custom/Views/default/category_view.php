<!--<h1 data-type="--><?php //echo $data['taxonomy']; ?><!--" data-id="--><?php //echo $data['term_id']; ?><!--"-->
<!--    class="--><?php //echo $data['taxonomy']; ?><!---taxonomy-title global-taxonomy-title global-module-title text-center">--><?php //echo $data['name']; ?><!--</h1>-->

<?php
if ($data['parent'] > 0) {
    $parent_term = $base_model->select('*', WGR_TERM_VIEW, [
        'taxonomy' => $data['taxonomy'],
        'term_id' => $data['parent']
    ], [
        'limit' => 1
    ]);
} else {
    $parent_term = $data;
}

// danh mục con của danh mục này
$child_term = $base_model->select('*', WGR_TERM_VIEW, [
    'taxonomy' => $parent_term['taxonomy'],
    'parent' => $data['parent'] > 0 ? $data['parent'] : $data['term_id']
], [
    'limit' => 6
]);
// chủ đề liên quan
$term_more = $base_model->select('*', WGR_TERM_VIEW, [
    'taxonomy' => $data['taxonomy'],
    'parent' => $data['parent'] > 0 ? $data['parent'] : $data['term_id'],
    'term_id <>' => $data['term_id']
], [
]);
// top bài xem nhiều
$dataTop = $post_model->get_posts_by([
    'term_id' => $data['term_id']
], [
    'limit' => 8,
    'order_by' => [
        'post_viewed' => 'DESC'
    ]
    //'offset' => 0,
]);
?>

<div class="row">
    <h3 class="title-category">
        <a href="<?php $term_model->the_term_permalink($parent_term); ?>"
           class="parent_name"><?= $parent_term['name'] ?></a>
        <?php foreach ($child_term as $ke => $child) { ?>
            <a href="<?php $term_model->the_term_permalink($child); ?>"
               class="child_name"><?= $child['name'] ?></a>
        <?php } ?>
    </h3>
</div>
<br>
<div class="row category__main">
    <div class="col medium-8 small-12 large-8">
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
    <div class="col medium-4 small-12 large-4">
        <div class="col-inner ">
            <?php if (!empty($term_more)) { ?>
                <h5 class="title__more">Chủ đề liên quan</h5>
                <?php
                foreach ($term_more as $key => $val) {
                    ?>
                    <a title="<?= $val['name'] ?>" class="item__more-category"
                       href="<?php $term_model->the_term_permalink($val); ?>"><i class="fa fa-ravelry"
                                                                                 aria-hidden="true"></i> <?= $val['name'] ?>
                        (<span><?= $val['count'] ?></span>)</a>
                    <?php
                }
                ?>
                <br>
                <br>
                <?php
            }
            ?>
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
<style>
    #breadcrumb-top1 {
        display: none;
    }
</style>