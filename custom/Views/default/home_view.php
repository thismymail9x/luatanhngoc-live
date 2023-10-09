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
$base_model->add_js('themes/' . THEMENAME . '/js/home.js', [
    'cdn' => CDN_BASE_URL,
], [
    'defer'
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

                        <a href="<?= base_url('/' . $v['post_permalink'] ); ?>" >
                            <div class="item">
                                <div class="item__carousel">
                                    <p class="title__post limit-text-3"><?= $v['post_title']; ?></p>
                                    <div class="background__gradient">
                                    </div>
                                    <?php
                                    $attachments = [$v['post_meta']['image_medium'],$v['post_meta']['image_medium'],$v['post_meta']['image']];
                                    $width = ['700w', '1024w', '1w']; ?>
                                    <img alt="<?php echo implode(" ", array_slice(explode(" ", $v['post_title']), 0, 5)); ?>" title="<?= $v['post_title']; ?>"
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
                    <a href="<?= base_url('/' . $v['post_permalink'] ); ?>" >
                        <div class="item__home-big">
                            <?php
                            $attachments = [$v['post_meta']['image_thumbnail'],$v['post_meta']['image_thumbnail'],$v['post_meta']['image']];
                            $width = ['700w', '1024w', '1w']; ?>
                            <img class="item__home-big-img" alt="<?php echo implode(" ", array_slice(explode(" ", $v['post_title']), 0, 5)); ?>"
                                 title="<?= $v['post_title']; ?>"
                                 src="<?php echo $attachments[2] ?>"
                                 srcset="<?php foreach ($attachments as $key => $value) {
                                     echo $value . ' ' . $width[$key] . ',';} ?>">
                            <div class="content__item-big">
                                <i class="text__time"><?= $v['post_date']; ?></i>
                                <p class="text__title limit-text-2"
                                   title="<?= $v['post_title']; ?>"><?= $v['post_title']; ?></p>
                                <span class="eye-star">
                                        <span title="Tác giả">
                                             <i style="color: #ffff00" class="fa fa-star"></i>
                                            <?= $v['user_nicename']?>

                                        </span>
                                        <span title="Lượt xem">
                                            <i class="ml-1 fa fa-eye"></i> <?=$v['post_viewed']?>
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
                    <a href="<?= base_url('/' . $v['post_permalink'] ); ?>" >
                        <div class="item__home-small">
                            <?php
                            $attachments = [$v['post_meta']['image_thumbnail'],$v['post_meta']['image_thumbnail'],$v['post_meta']['image']];
                            $width = ['700w', '1024w', '1w']; ?>
                            <img class="item__home-small-img" alt="<?php echo implode(" ", array_slice(explode(" ", $v['post_title']), 0, 5)); ?>"
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
                                        <span  title="Tác giả">
                                             <i style="color: #ffff00" class="fa fa-star"></i>
                                            <?= $v['user_nicename']?>
                                        </span>
                                        <span title="Lượt xem">
                                           <i class="ml-1 fa fa-eye"></i> <?=$v['post_viewed']?>
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
        <h1 class="title__company"><?=$getconfig->company_name;?></h1>
        <div class="line"></div>
        <h2 class="text-slogan"><?=$getconfig->solugan;?></h2>
        <p class="text introduce_company">
            Công ty Luật Ánh Ngọc J&T là một đơn vị chuyên cung cấp các dịch vụ pháp lý uy tín và chất lượng tại Việt Nam. Với kinh nghiệm nhiều năm trong lĩnh vực pháp luật, chúng tôi tự hào là một trong những Công ty luật hàng đầu, chuyên
            <a title="tư vấn pháp luật" href="<?= base_url()?>category/tu-van-luat-dan-su">tư vấn pháp luật</a> và cung cấp <a title="dịch vụ pháp lý" href="<?= base_url()?>category/dich-vu-phap-ly-doanh-nghiep">dịch vụ pháp lý</a> đa dạng. <br>
            Chúng tôi cam kết mang đến cho khách hàng những giải pháp pháp lý toàn diện, bao gồm <a title="dịch vụ đăng ký sở hữu trí tuệ" href="<?= base_url()?>category/tu-van-luat-so-huu-tri-tue">dịch vụ đăng ký sở hữu trí tuệ</a>,
            <a href="<?= base_url()?>category/dich-vu-phap-ly-doanh-nghiep">dịch vụ đăng ký thành lập công ty</a>, và hỗ trợ thủ tục <a href="<?= base_url()?>category/dich-vu-phap-ly-doanh-nghiep">làm giấy phép quảng cáo</a>. <br>Với đội ngũ luật sư có chuyên môn cao và am hiểu sâu về lĩnh vực này, chúng tôi cam kết luôn đồng hành và tư vấn một cách tận tâm để giúp khách hàng giải quyết mọi vấn đề pháp lý một cách hiệu quả và nhanh chóng.
            <br>
            Hãy để <a href="<?= base_url()?>pages/ve-cong-ty-luat">Công ty Luật</a> Ánh Ngọc J&T trở thành đối tác đáng tin cậy của bạn trong mọi vấn đề liên quan đến pháp luật. Chúng tôi sẽ luôn sẵn sàng hỗ trợ bạn, đồng hành cùng bạn trên con đường phát triển kinh doanh và bảo vệ quyền lợi của bạn một cách tốt nhất.
        </p>
    </div>
    <div class="bottom row">
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/dich-vu-phap-ly-doanh-nghiep"> <span class="circle"><i class="fa fa-building"></i></span> <span class="pElement">Tư vấn Doanh nghiệp</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/tu-van-hon-nhan-gia-dinh"><span class="circle"><i class="fa fa-heartbeat"></i></span> <span class="pElement">H&ocirc;n nh&acirc;n gia đ&igrave;nh</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/tu-van-luat-so-huu-tri-tue"><span class="circle"><i class="fa fa-deaf"></i></span> <span class="pElement">Tư vấn Sở hữu tr&iacute; tuệ</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/dich-vu-thu-tuc-hanh-chinh"><span class="circle"><i class="fa fa-university"></i></span><span class="pElement">Thủ thục h&agrave;nh ch&iacute;nh</span></a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/tu-van-luat-lao-dong"><span class="circle"><i class="fa fa-blind"></i></span> <span class="pElement ">Tư vấn Luật lao động</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/tu-van-luat-hinh-su"><span class="circle"><i class="fa fa-user-secret"></i></span> <span class="pElement ">Tư vấn Luật h&igrave;nh sự</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/tu-van-luat-dan-su"><span class="circle"><i class="fa fa-male"></i></span> <span class="pElement ">Tư vấn Luật d&acirc;n sự</span> </a></div>
        <div class="col-6 col-md-3 col-xl-3 item"><a href="<?= base_url()?>category/tu-van-luat-dat-dai"> <span class="circle"><i class="fa fa-globe"></i></span> <span class="pElement">Tư vấn luật đất đai</span> </a></div>
    </div>
</section>

<!--main row-->
<div class="row">
    <div class="col medium-12 small-12 large-4 hide__if-mobile">
        <div class="col-inner">
            <div class="left_under cf">
                <?php
                // 5 bài tiếp theo
                $t = 0;
                foreach (@$data as $k => $v) {
                    if ($v === NULL) {
                        continue;
                    }
                    $t++;
                    if ($t > 4) {
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
    <div class="col medium-12 small-12 large-8">
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

            $term_new = $base_model->select('*', WGR_TERM_VIEW, [
                'taxonomy' => TaxonomyType::POSTS,
                'slug' => 'tu-van-luat-dat-dai',
            ], [

                // hiển thị mã SQL để check
                //'show_query' => 1,
                // trả về câu query để sử dụng cho mục đích khác
                //'get_query' => 1,
                //'offset' => 0,
                'limit' => 1,
            ]);
            $in_cache_child_new = $term_model->key_cache('in_cache_child_new');
            $post_child_new = $base_model->scache($in_cache_child_new);
            if (empty($post_child_new)) {
                $post_child_new = $post_model->get_posts_by($term_new, [
                    'limit' => 5,
                ]);
                //
                $base_model->scache($in_cache_child_new, $post_child_new, 300);
            }
            ?>
                <div class="category_group">
                    <h3 class="title-category">
                        <a href="<?php $term_model->the_term_permalink($term_new); ?>"
                           class="parent_name"><?= $term_new['name'] ?></a>
                    </h3>
                    <div class="row posts-list cf">
                        <div class="col medium-12 small-12 large-8 border__element pb-0">
                            <div class="col-inner">
                                <div class="posts-home-middle row posts-list posts-list100 cf">
                                    <?php
                                    foreach ($post_child_new as $k => $v) {
                                        $post_model->the_node($v, [
                                            //'taxonomy_post_size' => $taxonomy_post_size,
                                        ]);
                                        // lấy xog hủy data đi
                                        $post_child_new[$k] = NULL;
                                        // lấy 1 tin chỗ này thôi
                                        break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col medium-12 small-12 large-4 pb-0">
                            <div class="col-inner">
                                <div class="hidden__img posts-home-middle-right row posts-list posts-list100 cf anhtren_chuduoi">
                                    <?php
                                    // lấy tiếp bài nữa
                                    foreach ($post_child_new as $k => $v) {
                                        if ($v === NULL) {
                                            continue;
                                        }
                                        $post_model->the_node($v, [
                                            //'taxonomy_post_size' => $taxonomy_post_size,
                                        ]);
                                        // lấy xog hủy data đi
                                        $post_child_new[$k] = NULL;
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
                        foreach ($post_child_new as $k => $v) {
                            if ($v === NULL) {
                                continue;
                            } ?>
                            <?php $post_model->the_node($v, [
                                //'taxonomy_post_size' => $taxonomy_post_size,
                            ]);
                            // lấy xog hủy data đi
                            $post_child_new[$k] = NULL;
                            ?>

                        <?php } ?>
                    </div>
                </div>
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
                            <a title="<?= $top['post_title']; ?>" href="<?=  $top['post_permalink']?>"><?= $top['post_title']; ?></a>
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
                   href="<?php $term_model->the_term_permalink($tag); ?>"># <?php echo $tag['name'] ?></a>
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
<!--    <div class="col medium-12 small-12 large-12">-->
        <?php
        $term_second = $base_model->select('*', WGR_TERM_VIEW, [
            'taxonomy' => TaxonomyType::POSTS,
            'slug' => 'tu-van-hon-nhan-gia-dinh',
        ], [

            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
            'limit' => 1,
        ]);


            $in_cache_child_second = $term_model->key_cache('in_cache_child_second');
            $post_child_second = $base_model->scache($in_cache_child_second);
            if (empty($post_child_second)) {
                $post_child_second = $post_model->get_posts_by($term_second, [
                    'limit' => 5,
                ]);
                //
                $base_model->scache($in_cache_child_second, $post_child_second, 300);
            }


            ?>
            <div class="category_group">
                <h3 class="title-category">
                    <a href="<?php $term_model->the_term_permalink($term_second); ?>"
                       class="parent_name"><?= $term_second['name'] ?></a>
                </h3>
                <div class="row posts-list cf line__top">
                    <div class="col medium-6 small-12 large-6 border__element pb-0">
                        <div class="col-inner">
                            <div class="posts-home-middle row posts-list posts-list100 cf">
                                <?php
                                foreach ($post_child_second as $k => $v) {
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $post_child_second[$k] = NULL;
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
                                foreach ($post_child_second as $k => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $post_child_second[$k] = NULL;
                                    break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row line__item-vertical row__margin-x-0 posts-list posts-list33 cf hidden__img anhtren_chuduoi">
                    <?php
                    // hiển thị 3 bài còn lại
                    foreach ($post_child_second as $k => $v) {
                        if ($v === NULL) {
                            continue;
                        } ?>
                        <?php $post_model->the_node($v, [
                            //'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                        // lấy xog hủy data đi
                        $post_child_second[$k] = NULL;
                        ?>

                    <?php } ?>
                </div>
            </div>

<!--    </div>-->
</div>
<!--ads row-->
<!--<div class="row">-->
<!--    <div class="col">-->
<!--        <div class="thirst__slider">-->
<!--            --><?php
//            // sau đó chèn 1 banner
//            $post_model->the_ads('quang-cao-2');
//            ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
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
        $term_three = $base_model->select('*', WGR_TERM_VIEW, [
            'taxonomy' => TaxonomyType::POSTS,
            'slug' => 'dich-vu-phap-ly-doanh-nghiep',
        ], [

            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
            'limit' => 1,
        ]);


        $in_cache_child_three = $term_model->key_cache('in_cache_child_three');
        $post_child_three = $base_model->scache($in_cache_child_three);
        if (empty($post_child_three)) {
            $post_child_three = $post_model->get_posts_by($term_three, [
                'limit' => 5,
            ]);
            //
            $base_model->scache($in_cache_child_three, $post_child_three, 300);
        }

        ?>
            <div class="category_group">
                <h3 class="title-category">
                    <a href="<?php $term_model->the_term_permalink($term_three); ?>"
                       class="parent_name"><?= $term_three['name'] ?></a>
                </h3>
                <div class="row posts-list cf">
                    <div class="col medium-12 small-12 large-8 border__element pb-0">
                        <div class="col-inner">
                            <div class="posts-home-middle row posts-list posts-list100 cf">
                                <?php
                                foreach ($post_child_three as $k => $v) {
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $post_child_three[$k] = NULL;
                                    // lấy 1 tin chỗ này thôi
                                    break;
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-12 small-12 large-4 pb-0">
                        <div class="col-inner">
                            <div class="hidden__img posts-home-middle-right row posts-list posts-list100 cf anhtren_chuduoi">
                                <?php
                                // lấy tiếp bài nữa
                                foreach ($post_child_three as $k => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $post_child_three[$k] = NULL;
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
                    foreach ($post_child_three as $k => $v) {
                        if ($v === NULL) {
                            continue;
                        } ?>
                        <?php $post_model->the_node($v, [
                            //'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                        // lấy xog hủy data đi
                        $post_child_three[$k] = NULL;
                        ?>

                    <?php } ?>
                </div>
            </div>
    </div>
</div>

<!--five category-->
<div class="row line__five">
    <div class="col medium-12 small-12 large-12">
        <?php
        $term_four = $base_model->select('*', WGR_TERM_VIEW, [
            'taxonomy' => TaxonomyType::POSTS,
            'slug' => 'tu-van-luat-lao-dong',
        ], [

            // hiển thị mã SQL để check
            //'show_query' => 1,
            // trả về câu query để sử dụng cho mục đích khác
            //'get_query' => 1,
            //'offset' => 0,
            'limit' => 1,
        ]);


        $in_cache_child_four = $term_model->key_cache('in_cache_child_four');
        $post_child_four = $base_model->scache($in_cache_child_four);
        if (empty($post_child_four)) {
            $post_child_four = $post_model->get_posts_by($term_four, [
                'limit' => 6,
            ]);
            //
            $base_model->scache($in_cache_child_four, $post_child_four, 300);
        }

        ?>
            <div class="category_group">
                <h3 class="title-category">
                    <a href="<?php $term_model->the_term_permalink($term_four); ?>"
                       class="parent_name"><?= $term_four['name'] ?></a>

                </h3>
                <div class="row posts-list cf">
                    <div class="col medium-12 small-12 large-6 border__element pb-0 element__1">
                        <div class="col-inner">
                            <div class="row posts-list posts-list100 cf anhtren_chuduoi">
                                <?php
                                foreach ($post_child_four as $kee => $v) {
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $post_child_four[$kee] = NULL;
                                    // lấy 1 tin chỗ này thôi
                                    break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-12 small-12 large-3 pb-0 element__2">
                        <div class="col-inner">
                            <div class="posts-list cf anhtren_chuduoi min-height251">
                                <?php
                                // hiển thị 2 bài tiep
                                $i = 0;
                                foreach ($post_child_four as $k => $v) {
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
                                    $post_child_four[$k] = NULL;
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col medium-12 small-12 large-3 pb-0 element__3">
                        <div class="col-inner">
                            <div class="row posts-list posts-list100 cf min-height117">
                                <?php
                                // hiển thị 4 bai con lai
                                foreach ($post_child_four as $keyy => $v) {
                                    if ($v === NULL) {
                                        continue;
                                    }
                                    $post_model->the_node($v, [
                                        //'taxonomy_post_size' => $taxonomy_post_size,
                                    ]);
                                    // lấy xog hủy data đi
                                    $post_child_four[$keyy] = NULL;
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="row hide__if-mobile">
    <div class="col">
        <hr>
    </div>
</div>
<div class="row">
    <div class="page__bottom">
       <div class="col">
           <img src="<?= base_url() ?>upload/2023/09/hinh-anh-lien-he-large.png" alt="lien-he">
           <div class="page__bottom-item">
               <p>Hãy gửi vấn đề của bạn cho chúng tôi để được hỗ trợ và tư vấn nhanh nhất</p>
               <a target="_blank" href="<?=base_url()?>pages/lien-he" title="Click để tạo liên hệ" role="button" id="button-92" class="button-92">Liên hệ</a>
           </div>
       </div>
    </div>
</div>
