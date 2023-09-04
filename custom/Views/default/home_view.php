<?php

// Libraries
//use App\Libraries\PostType;
use App\Libraries\TaxonomyType;

//
//$html_text_only = $base_model->get_html_tmp('posts_node_text_only');
//echo $html_text_only;

$base_model->add_css('themes/' . THEMENAME . '/css/home.css', [
    'cdn' => CDN_BASE_URL,
]);
/*
 * lấy các bài viết mới nhất
 */

$in_cache = $term_model->key_cache('home-top10');
$custom_code_model = new \App\Models\CustomCode();
$data = $base_model->scache($in_cache);
if (empty($data)) {
    $data = $post_model->get_posts_by([], [
        'limit' => 25,
        //'offset' => 0,
    ]);
    //
    $base_model->scache($in_cache, $data, 300);
}
//print_r($data);

?>
<?php //print_r($data);die('ccc'); ?>

<section class="list__post">
    <div class="row">
        <div class="col-md-6">
            <div class="owl-carousel owl-theme" id="owl-carousel-post">
                <?php
                $i = 0;
                foreach (@$data as $k => $v) {
                    if ($v === NULL) {
                        continue;
                    }
                    $i++;
                    if ($i >= 14) {
                        break;
                    }
                    ?>


                        <a href="<?= base_url('/' . $v['post_permalink'] ); ?>" target="_blank">
                            <div class="item">
                                <div class="item__carousel">
                                    <p class="title__post limit-text-3"><?= $v['post_title']; ?></p>
                                    <div class="background__gradient">
                                    </div>
                                    <?php
                                    $attachments = [$v['post_meta']['image_medium'],$v['post_meta']['image_large'],$v['post_meta']['image']];
                                    $width = ['700w', '1024w', '1w']; ?>
                                    <img alt="<?= $v['post_title']; ?>" title="<?= $v['post_title']; ?>"
                                         src="<?php echo $attachments[2] ?>"
                                         srcset="<?php foreach ($attachments as $key => $value) {
                                             echo $value . ' ' . $width[$key] . ',';} ?>">
                                </div>
                            </div>
                        </a>
                    <?php $data[$k] = NULL;} ?>
            </div>
        </div>
        <?php $h = 0;
        foreach (@$data as $k => $v) {
            if ($v === NULL) {
                continue;
            }
            $h ++;
            if ($h > 5) {
                break;
            }
            ?>
                <div class="col-md-3">
                    <a href="<?= base_url('/' . $v['post_permalink'] ); ?>" target="_blank">
                        <div class="item__home-big">
                            <?php
                            $attachments = [$v['post_meta']['image_medium'],$v['post_meta']['image_large'],$v['post_meta']['image']];
                            $width = ['700w', '1024w', '1w']; ?>
                            <img class="item__home-big-img" alt="<?= $v['post_title']; ?>"
                                 title="<?= $v['post_title']; ?>"
                                 src="<?php echo $attachments[2] ?>"
                                 srcset="<?php foreach ($attachments as $key => $value) {
                                     echo $value . ' ' . $width[$key] . ',';} ?>">
                            <div class="content__item-big">
                                <i class="text__time"><?= $v['post_date']; ?></i>
                                <p class="text__title limit-text-2"
                                   title="<?= $v['post_title']; ?>"><?= $v['post_title']; ?></p>
                                <span class="eye-star">
                                        <span title="Đánh giá">
                                            <?= $v['post_status']?>
                                            <i style="color: #ffff00" class="fa fa-star"></i>
                                        </span>
                                        <span title="Lượt xem">
                                            <?=$v['post_viewed']?> <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                            </div>

                        </div>
                    </a>
                </div>
            <?php  $data[$k] = NULL; } ?>

        <div class="col-md-3">
            <?php $m = 0; foreach (@$data as $k => $v) {
                if ($v === NULL) {
                    continue;
                }
                $m ++;
                if ($m > 2) {
                    break;
                }
                ?>
                    <a href="<?= base_url('/' . $v['post_permalink'] ); ?>" target="_blank">
                        <div class="item__home-small">
                            <?php
                            $attachments = [$v['post_meta']['image_medium'],$v['post_meta']['image_large'],$v['post_meta']['image']];
                            $width = ['700w', '1024w', '1w']; ?>
                            <img class="item__home-small-img" alt="<?= $v['post_title']; ?>"
                                 title="<?= $v['post_title']; ?>"
                                 src="<?php echo $attachments[2] ?>"
                                 srcset="<?php foreach ($attachments as $key => $value) {
                                     echo $value . ' ' . $width[$key] . ',';} ?>">
                            <div class="content__item-small">
                                <i class="text__time"><?= $v['post_date']; ?></i>
                                <p class="text__title limit-text-2"
                                   title="<?= $v['post_title']; ?>"><?= $v['post_title']; ?></p>

                            </div>
                            <span class="eye-star">
                                        <span title="Đánh giá">
                                           <?= $v['post_status']?>
                                            <i style="color: #ffff00" class="fa fa-star"></i>
                                        </span>
                                        <span title="Lượt xem">
                                            <?=$v['post_viewed']?> <i class="fa fa-eye"></i>
                                        </span>
                                    </span>
                        </div>

                    </a>
                <?php $data[$k] = NULL;
            } ?>
        </div>
    </div>
</section>

<!--line row-->
<!--<div class="row hide__if-mobile">-->
<!--    <div class="col">-->
<!--        <hr>-->
<!--    </div>-->
<!--</div>-->


<section class="row home__category">
    <div class="top">
        <p class="title__company"><?=$getconfig->company_name;?></p>
        <div class="line"></div>
        <p class="text"><?=$getconfig->solugan;?></p>
        <p class="text introduce_company">
            Công ty Luật Ánh Ngọc là một đơn vị chuyên cung cấp các dịch vụ pháp lý uy tín và chất lượng tại Việt Nam. Với kinh nghiệm nhiều năm trong lĩnh vực pháp luật, chúng tôi tự hào là một trong những Công ty luật hàng đầu, chuyên
            <a href="">tư vấn pháp luật</a> và cung cấp <a href="">dịch vụ pháp lý</a> đa dạng. <br>
            Chúng tôi cam kết mang đến cho khách hàng những giải pháp pháp lý toàn diện, bao gồm <a href="">dịch vụ đăng ký sở hữu trí tuệ</a>,
            <a href="">dịch vụ đăng ký thành lập công ty</a>, và hỗ trợ thủ tục <a href="">làm giấy phép quảng cáo</a>. <br>Với đội ngũ
            <a href="">luật sư</a> có chuyên môn cao và am hiểu sâu về lĩnh vực này, chúng tôi cam kết luôn đồng hành và tư vấn một cách tận tâm để giúp khách hàng giải quyết mọi vấn đề pháp lý một cách hiệu quả và nhanh chóng.
            <br>
            Hãy để <a href="">Công ty Luật</a> Ánh Ngọc trở thành đối tác đáng tin cậy của bạn trong mọi vấn đề liên quan đến pháp luật. Chúng tôi sẽ luôn sẵn sàng hỗ trợ bạn, đồng hành cùng bạn trên con đường phát triển kinh doanh và bảo vệ quyền lợi của bạn một cách tốt nhất.
        </p>
    </div>
    <div class="bottom row">
<!--        --><?php //foreach (@$term_data as $key =>$val) { ?>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-phap-ly-doanh-nghiep"> <span class="circle"><i class="fa fa-building"></i></span> <span class="pElement">Tư vấn Ph&aacute;p l&yacute; doanh nghiệp</span> </a></div>
<!--        --><?php //} ?>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-luat-hon-nhan-gia-dinh"><span class="circle"><i class="fa fa-heartbeat"></i></span> <span class="pElement">Tư vấn Luật h&ocirc;n nh&acirc;n gia đ&igrave;nh</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-luat-so-huu-tri-tue"><span class="circle"><i class="fa fa-deaf"></i></span> <span class="pElement">Tư vấn luật Sở hữu tr&iacute; tuệ</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-cac-thu-tuc-hanh-chinh"><span class="circle"><i class="fa fa-university"></i></span><span class="pElement">Tư vấn thủ thục h&agrave;nh ch&iacute;nh</span></a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-luat-lao-dong"><span class="circle"><i class="fa fa-blind"></i></span> <span class="pElement ">Tư vấn Luật lao động</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-luat-hinh-su"><span class="circle"><i class="fa fa-user-secret"></i></span> <span class="pElement ">Tư vấn Luật h&igrave;nh sự</span> </a></div>
        <div class="col-6 col-md-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-luat-dan-su"><span class="circle"><i class="fa fa-male"></i></span> <span class="pElement ">Tư vấn Luật d&acirc;n sự</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="https://luatanhngoc.vn/vi/tu-van-luat-dat-dai"> <span class="circle"><i class="fa fa-globe"></i></span> <span class="pElement">Tư vấn luật đất đai</span> </a></div>
    </div>
</section>




<!--main row-->
<div class="row">
    <div class="col medium-4 small-12 large-4 border__element hide__if-mobile">
        <div class="col-inner">
            <div class="left_under row posts-list posts-list100 cf">
                <?php
                // 5 bài tiếp theo
                $t = 0;
                foreach (@$data as $k => $v) {
                    if ($v === NULL) {
                        continue;
                    }
                    $t++;
                    if ($t > 6) {
                        break;
                    }
                    //
                    $custom_code_model->the_nodeV2($v, [
                        //'taxonomy_post_size' => $taxonomy_post_size,
                    ]);

                    // lấy xog hủy data đi
                    $data[$k] = NULL;
                }

                ?>

            </div>
<!--            <div class="first__slider">-->
<!--                --><?php
//                // sau đó chèn 1 banner
//                $post_model->the_ads('home-left-center-slider');
//                ?>
<!--            </div>-->
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
<!--            <div class="second__slider">-->
<!--                --><?php
//                // sau đó chèn 1 banner
//                $post_model->the_ads('home-left-center-slider');
//                ?>
<!--            </div>-->
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
            // chỉ lấy danh mục của phần dịch vụ luật sư
            $term_child = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::POSTS,
                'parent' => $term_data[0]['term_id'],
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

