<?php

// Libraries
//use App\Libraries\PostType;
use App\Libraries\TaxonomyType;


//
//$html_text_only = $base_model->get_html_tmp('posts_node_text_only');
//echo $html_text_only;


/*
 * lấy các bài viết mới nhất
 */

$in_cache = $term_model->key_cache('home-top10');

$data = $base_model->scache($in_cache);
if ($data === null) {
    $data = $post_model->get_posts_by([], [
        'limit' => 20,
        //'offset' => 0,
    ]);

    //
    $base_model->scache($in_cache, $data, 300);
}
//print_r($data);

?>
<!--first row-->
<div class="row home__view row__top-20">
    <div class="col medium-8 small-12 large-8">
        <div class="col-inner">
            <div class="posts-home-top row posts-list posts-list100 cf">
                <?php

                // lấy bài đầu tiên
                foreach ($data as $k => $v) {
                    //echo '<!-- ';
                    //print_r( $v );
                    //echo ' -->';

                    //
                    $post_model->the_node($v, [
                        //'taxonomy_post_size' => $taxonomy_post_size,
                    ]);

                    // lấy xog hủy data đi
                    $data[$k] = NULL;

                    // lấy 1 tin chỗ này thôi
                    break;
                }

                ?>
            </div>
            <div class="row posts-list posts-list33 cf anhtren_chuduoi text_only">
                <?php

                // 3 bài tiếp theo
                $i = 0;
                foreach ($data as $k => $v) {
                    if ($v === NULL) {
                        continue;
                    }
                    $i++;
                    if ($i > 3) {
                        break;
                    }

                    //
                    $post_model->the_node($v, [
                        //'taxonomy_post_size' => $taxonomy_post_size,
                    ]);

                    // lấy xog hủy data đi
                    $data[$k] = NULL;
                }

                ?>
            </div>
        </div>
    </div>
    <div class="col medium-4 small-12 large-4">
        <div class="col-inner">
            <!--            <h4 class="text-center top-menu-space10 s14 bold title__more">Top bài viết tuần</h4>-->
            <div class="right-home-top posts-list posts-list100 cf">
                <?php

                // 15 bài tiếp theo
                $i = 0;
                foreach ($data as $k => $v) {
                    if ($v === NULL) {
                        continue;
                    }
                    $i++;
                    if ($i > 6) {
                        break;
                    }
                    $post_model->the_node($v, [
                        //'taxonomy_post_size' => $taxonomy_post_size,
                    ]);
                    $data[$k] = NULL;
                }
                ?>

            </div>
        </div>
    </div>
</div>
<!--line row-->
<div class="row hide__if-mobile">
    <div class="col">
        <hr>
    </div>
</div>
<!--main row-->
<div class="row">
    <div class="col medium-4 small-12 large-4 border__element hide__if-mobile">
        <div class="col-inner">
            <div class="left_under row posts-list posts-list100 cf">
                <?php
                // 5 bài tiếp theo
                $i = 0;
                foreach ($data as $k => $v) {
                    if ($v === NULL) {
                        continue;
                    }
                    $i++;
                    if ($i > 6) {
                        break;
                    }
                    //
//                    $custom_code_model->the_nodeV2($v, [
//                        //'taxonomy_post_size' => $taxonomy_post_size,
//                    ]);

                    // lấy xog hủy data đi
                    $data[$k] = NULL;
                }

                ?>

            </div>
            <div class="first__slider">
                <?php
                // sau đó chèn 1 banner
                $post_model->the_ads('home-left-center-slider');
                ?>
            </div>
            <!--            <div class="second__slider">-->
            <!--            --><?php
            //            // sau đó chèn 1 banner
            //            $post_model->the_ads('home-left-center-slider');
            //            ?>
            <!--            </div>-->

        </div>
    </div>
    <div class="col medium-8 small-12 large-8">
        <div class="col-inner">
            <div class="second__slider">
                <?php
                // sau đó chèn 1 banner
                $post_model->the_ads('home-left-center-slider');
                ?>
            </div>
            <?php
            /*
             * lấy danh mục và các bài viết của nó
             */

            $term_data = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::POSTS,
                'child_count >' => 0,
            ], [

                // hiển thị mã SQL để check
                //'show_query' => 1,
                // trả về câu query để sử dụng cho mục đích khác
                //'get_query' => 1,
                //'offset' => 0,
                'limit' => 9,
                'order_by' => [
                    'term_order' => 'DESC'
                ]
            ]);
            $i = 0;
            // hiển thị danh sách danh mục
            foreach ($term_data as $keyy => $val) {
                if ($val === NULL) {
                    continue;
                }
                $i++;
                if ($i > 2) {
                    break;
                }
                $child_term = $base_model->select('*', WGR_TERM_VIEW, [
                    'taxonomy' => TaxonomyType::POSTS,
                    'parent' => $val['term_id']
                ], [
                    'limit' => 6
                ]);
                $child_data = $post_model->get_posts_by($val, [
                    'limit' => 5,
                ]);
                if (empty($child_data)) {
                    continue;
                }
                // lấy xog hủy data đi
                $term_data[$keyy] = NULL;
                ?>
                <div class="category_group">
                    <h3 class="title-category">
                        <a href="<?php $term_model->the_term_permalink($val); ?>"
                           class="parent_name"><?= $val['name'] ?></a>
                        <?php foreach ($child_term as $ke => $child) { ?>
                            <a href="<?php $term_model->the_term_permalink($child); ?>"
                               class="child_name"><?= $child['name'] ?></a>
                        <?php } ?>
                    </h3>
                    <div class="row posts-list cf">
                        <div class="col medium-8 small-12 large-8 border__element pb-0">
                            <div class="col-inner">
                                <div class="posts-home-middle row posts-list posts-list100 cf">
                                    <?php
                                    foreach ($child_data as $k => $v) {
                                        $post_model->the_node($v, [
                                            //'taxonomy_post_size' => $taxonomy_post_size,
                                        ]);
                                        // lấy xog hủy data đi
                                        $child_data[$k] = NULL;
                                        // lấy 1 tin chỗ này thôi
                                        break;
                                    }


                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col medium-4 small-12 large-4 pb-0">
                            <div class="col-inner">
                                <div class="hidden__img posts-home-middle-right row posts-list posts-list100 cf anhtren_chuduoi">
                                    <?php
                                    // lấy tiếp bài nữa
                                    foreach ($child_data as $k => $v) {
                                        if ($v === NULL) {
                                            continue;
                                        }
                                        $post_model->the_node($v, [
                                            //'taxonomy_post_size' => $taxonomy_post_size,
                                        ]);
                                        // lấy xog hủy data đi
                                        $child_data[$k] = NULL;
                                        break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row__li-item row__margin-x-0 posts-list posts-list33 cf hidden__img hidden__description anhtren_chuduoi">
                        <?php
                        // hiển thị 3 bài còn lại
                        foreach ($child_data as $k => $v) {
                            if ($v === NULL) {
                                continue;
                            } ?>
                            <?php $post_model->the_node($v, [
                                //'taxonomy_post_size' => $taxonomy_post_size,
                            ]);
                            // lấy xog hủy data đi
                            $child_data[$k] = NULL;
                            ?>

                        <?php } ?>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
        <div class="top-8 box-xemnhieu">
            <hgroup class="width_common title-box-category">
                <h3 class="parent-cate">
                    <span>Xem nhiều</span>
                </h3>
            </hgroup>
            <div class="list-top-view">
                <?php
                $in_cacheTop = $term_model->key_cache('home-top8');
                $dataTop = $base_model->scache($in_cacheTop);
                if ($dataTop === null) {
                    $dataTop = $post_model->get_posts_by([], [
                        'limit' => 8,
                        'order_by' => [
                            'post_viewed' => 'DESC'
                        ]
                        //'offset' => 0,
                    ]);

                    //
                    $base_model->scache($in_cacheTop, $dataTop, 300);
                }
                foreach ($dataTop as $key => $top) {
                    ?>
                    <article class="item-news">
                        <span class="number-top-view"><?php echo ++$key; ?></span>
                        <h4 class="title-news">
                            <a href=""><?php echo $top['post_title']; ?></a>
                            <span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $top['post_viewed']; ?></span>
                        </h4>
                    </article>
                <?php } ?>
            </div>
        </div>
        <div class="tag_element">
            <i class="fa fa-tags" aria-hidden="true"></i>
            <?php $tags = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::TAGS,
            ], [

                // hiển thị mã SQL để check
                //'show_query' => 1,
                // trả về câu query để sử dụng cho mục đích khác
                //'get_query' => 1,
                //'offset' => 0,
                'limit' => 8
            ]);

            foreach ($tags as $key => $tag) { ?>
                <a title="Danh sách bài viết của thẻ gán" class="badge bg-info"
                   href="<?php $term_model->the_term_permalink($tag); ?>"> <?php echo $tag['name'] ?></a>
                <?php
            } ?>
        </div>
    </div>
</div>
<!--line row-->
<div class="row hide__if-mobile">
    <div class="col">
        <hr>
    </div>

</div>
<!--three category-->
<div class="row line__three">
    <div class="col medium-12 small-12 large-12">
        <?php
        foreach ($term_data as $k => $val) {
            if ($val === NULL) {
                continue;
            }

            $child_term = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::POSTS,
                'parent' => $val['term_id']
            ], [
                'limit' => 6
            ]);
            $child_data = $post_model->get_posts_by($val, [
                'limit' => 5,
            ]);
            if (empty($child_data)) {
                continue;
            }
            // lấy xog hủy data đi
            $term_data[$k] = NULL;
            ?>
            <div class="category_group">
                <h3 class="title-category">
                    <a href="<?php $term_model->the_term_permalink($val); ?>"
                       class="parent_name"><?= $val['name'] ?></a>
                    <?php foreach ($child_term as $ke => $child) { ?>
                        <a href="<?php $term_model->the_term_permalink($child); ?>"
                           class="child_name"><?= $child['name'] ?></a>
                    <?php } ?>
                </h3>
                <div class="row posts-list cf line__top">
                    <div class="col medium-6 small-12 large-6 border__element pb-0">
                        <div class="col-inner">
                            <div class="posts-home-middle row posts-list posts-list100 cf">
                                <?php
                                foreach ($child_data as $k => $v) {
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$k] = NULL;
                                    // lấy 1 tin chỗ này thôi
                                    break;
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-6 small-12 large-6 pb-0">
                        <div class="col-inner">
                            <div class="posts-home-middle row posts-list posts-list100 cf ">
                                <?php
                                // lấy tiếp bài nữa
                                foreach ($child_data as $k => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$k] = NULL;
                                    break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row line__item row__margin-x-0 posts-list posts-list33 cf hidden__img anhtren_chuduoi">
                    <?php
                    // hiển thị 3 bài còn lại
                    foreach ($child_data as $k => $v) {
                        if ($v === NULL) {
                            continue;
                        } ?>
                        <?php $post_model->the_node($v, [
                            //'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                        // lấy xog hủy data đi
                        $child_data[$k] = NULL;
                        ?>

                    <?php } ?>
                </div>
            </div>
            <?php
            break;
        } ?>
    </div>
</div>
<!--ads row-->
<div class="row">
    <div class="col">
        <div class="thirst__slider">
            <?php
            // sau đó chèn 1 banner
            $post_model->the_ads('quang-cao-2');
            ?>
        </div>
    </div>
</div>
<!--line row-->
<div class="row hide__if-mobile">
    <div class="col">
        <hr>
    </div>

</div>
<!--four category-->
<div class="row">
    <div class="col medium-12 small-12 large-12">
        <?php
        foreach ($term_data as $key => $val) {
            if ($val === NULL) {
                continue;
            }

            $child_term = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::POSTS,
                'parent' => $val['term_id']
            ], [
                'limit' => 6
            ]);
            $child_data = $post_model->get_posts_by($val, [
                'limit' => 5,
            ]);
            if (empty($child_data)) {
                continue;
            }
            // lấy xog hủy data đi
            $term_data[$key] = NULL;
            ?>
            <div class="category_group">
                <h3 class="title-category">
                    <a href="<?php $term_model->the_term_permalink($val); ?>"
                       class="parent_name"><?= $val['name'] ?></a>
                    <?php foreach ($child_term as $ke => $child) { ?>
                        <a href="<?php $term_model->the_term_permalink($child); ?>"
                           class="child_name"><?= $child['name'] ?></a>
                    <?php } ?>
                </h3>
                <div class="row posts-list cf">
                    <div class="col medium-8 small-12 large-8 border__element pb-0">
                        <div class="col-inner">
                            <div class="posts-home-middle row posts-list posts-list100 cf">
                                <?php
                                foreach ($child_data as $k => $v) {
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$k] = NULL;
                                    // lấy 1 tin chỗ này thôi
                                    break;
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-4 small-12 large-4 pb-0">
                        <div class="col-inner">
                            <div class="hidden__img posts-home-middle-right row posts-list posts-list100 cf anhtren_chuduoi">
                                <?php
                                // lấy tiếp bài nữa
                                foreach ($child_data as $k => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$k] = NULL;
                                    break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row__li-item row__margin-x-0 posts-list posts-list33 cf hidden__img hidden__description anhtren_chuduoi">
                    <?php
                    // hiển thị 3 bài còn lại
                    foreach ($child_data as $k => $v) {
                        if ($v === NULL) {
                            continue;
                        } ?>
                        <?php $post_model->the_node($v, [
                            //'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                        // lấy xog hủy data đi
                        $child_data[$k] = NULL;
                        ?>

                    <?php } ?>
                </div>
            </div>

            <?php
            break;
        } ?>
    </div>
</div>

<!--five category-->
<div class="row line__five">
    <div class="col medium-12 small-12 large-12">
        <?php
        foreach ($term_data as $k => $val) {
            if ($val === NULL) {
                continue;
            }

            $child_term = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::POSTS,
                'parent' => $val['term_id']
            ], [
                'limit' => 6
            ]);
            $child_data = $post_model->get_posts_by($val, [
                'limit' => 7,
            ]);
            if (empty($child_data)) {
                continue;
            }
            // lấy xog hủy data đi
            $term_data[$k] = NULL;
            ?>
            <div class="category_group">
                <h3 class="title-category">
                    <a href="<?php $term_model->the_term_permalink($val); ?>"
                       class="parent_name"><?= $val['name'] ?></a>
                    <?php foreach ($child_term as $ke => $child) { ?>
                        <a href="<?php $term_model->the_term_permalink($child); ?>"
                           class="child_name"><?= $child['name'] ?></a>
                    <?php } ?>
                </h3>
                <div class="row posts-list cf">
                    <div class="col medium-6 small-12 large-6 border__element pb-0 element__1">
                        <div class="col-inner">
                            <div class="row posts-list posts-list100 cf anhtren_chuduoi">
                                <?php
                                foreach ($child_data as $kee => $v) {
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$kee] = NULL;
                                    // lấy 1 tin chỗ này thôi
                                    break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-3 small-12 large-3 pb-0 element__2">
                        <div class="col-inner">
                            <div class="row posts-list posts-list100 cf anhtren_chuduoi">
                                <?php
                                // hiển thị 2 bài tiep
                                $i = 0;
                                foreach ($child_data as $k => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $i++;
                                    if ($i > 2) {
                                        break;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$k] = NULL;
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-3 small-12 large-3 pb-0 element__3">
                        <div class="col-inner">
                            <div class="row posts-list posts-list100 cf ">
                                <?php
                                // hiển thị 4 bai con lai
                                foreach ($child_data as $keyy => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $child_data[$keyy] = NULL;
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            break;
        } ?>
    </div>
</div>

