<?php

// Libraries
use App\Libraries\CommentType;
use App\Libraries\TaxonomyType;

//
$comment_model = new \App\Models\Comment();
$base_model->add_css('themes/' . THEMENAME . '/js/post_node.css', [
    'cdn' => CDN_BASE_URL,
]);
$base_model->add_css('themes/' . THEMENAME . '/js/posts_node.css', [
    'cdn' => CDN_BASE_URL,
]);
// update lượt xem
$post_model->update_views( $data[ 'ID' ] );

?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0" nonce="JpTGkc9y"></script>
<div class="row global-post-module blog__child">
    <div class="col medium-9 small-12 large-9">
        <div class="col-inner">
            <div class="blog__content container">
                <div class="create-time">
                    <div class="item-calendar"></div>
                    <p class="text-time" title="Thời gian tạo"><?= date('d.m.Y',strtotime(@$data['post_date'])); ?>
                        <span class="ml-3" title="Lượt xem"><i class="fa fa-eye"></i> <?=$data['post_viewed']?></span>
                        <span class="float-right">Cỡ chữ: <i title="Giảm" class="decreaseSizeBtn fa-solid fa-arrow-down-wide-short cursor"></i> <i title="Tăng" class="increaseSizeBtn fa-solid fa-arrow-up-wide-short cursor"></i></span>
                    </p>
                </div>
                <p>
<!--            <span>--><?php //=@$data['full_name']?><!--</span>-->
                </p>
                <h1 class="title limit-text-2"><?= @$data['post_title']?></h1>

                <div class="blog-avatar">
                    <?php
                    $attachments = [$data['post_meta']['image_medium'],$data['post_meta']['image_medium_large'],$data['post_meta']['image_large']];
                    $width = ['700w','1024w','1200w']; ?>
                    <img class="img__child" alt="<?= @$data['post_title']?>" src="<?php echo $attachments[2] ?>"
                         srcset="<?php foreach ($attachments as $key=>$value) {
                             echo $value.' '.$width[$key].',';} ?>">
                </div>
                <p class="introduce-blog">
                    <?= @$data['post_excerpt']?>
                </p>
                <div class="menuPost" >
                    <div id="contentCategory" class="contentCategory collapsed">
                        <div class="item-top">
                            <i class="fa-solid fa-list-ol" style="color: #ffff00;"></i>
                            <span>Mục lục bài viết</span>
                            <i class="fa-solid fa-chevron-down icon__rotate" style="color: #ffff00;"></i>
                        </div>
                        <div class="item-bottom">
<!--                            --><?php //foreach (@$contentCategory as $key => $value) { ?>
<!--                                <p class="parent"><a title="--><?php //=$value['name']?><!--" href="#--><?php //=$value['id']?><!--">--><?php //=$value['name']?><!--</a></p>-->
<!--                                --><?php //foreach ($value['children'] as $k => $v) { ?>
<!--                                    <p class="children"><a title="--><?php //=$v['name']?><!--" href="#--><?php //=$v['id']?><!--">--><?php //=$v['name']?><!--</a></p>-->
<!--                                --><?php //} } ?>
                        </div>
                    </div>
                </div>
                <div id="contentPost" class="content">
                    <p><?= @$data['post_content']?></p>
                </div>
        </div>
    </div>
    </div>

    <div class="col medium-3 small-12 large-3 more_post hide__if-mobile">
        <div class="col-inner">
            <div class="menu__top">
                    <h5 class="title__menu-flash">Mục lục</h5>
<!--                    --><?php //foreach (@$data_comment as $k => $v) { $k++;?>
<!--                        <div data-key="--><?php //echo $k; ?><!--" class="section__comment-small">-->
<!--                            <div class="badged_small-menu" data-stt="--><?php //echo $k; ?><!--">-->
<!--                                --><?php //echo $k; ?>
<!--                            </div>-->
<!--                            <h4 class="comment_title-small">-->
<!--                                <a title="--><?php //echo $v['comment_title']; ?><!--">--><?php //echo $v['comment_title']; ?><!--</a>-->
<!--                            </h4>-->
<!--                        </div>-->
<!--                    --><?php //} ?>
            </div>
            <?php
            if (!empty($same_cat_data)) {
                ?>
                <div class="other-post-title">Bài viết tương tự</div>
                <div id="post_same_cat"
                     class="row fix-li-wit posts-list other-posts-list cf <?php $option_model->posts_in_line($getconfig); ?>">
                    <?php

                    foreach ($same_cat_data as $child_key => $child_val) {
//                        echo '<!-- ';
//                        print_r( $child_val );
//                        echo ' -->';

                        //
                        $post_model->the_node($child_val, [
                            'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                    }

                    ?>
                </div>
                <?php
            }

            ?>
        </div>
    </div>
</div>

<div class="global-page-module w90">
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
<!--    <div class="padding-global-content cf ">-->
<!--        <div class="col-main-content custom-width-page-main fullsize-if-mobile">-->
<!--            <div class="col-main-padding col-page-padding"><br>-->
<!--                <div class="global-page-widget">-->
<!--                    --><?php
//                    // str_for_details_sidebar
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-sidebar-content custom-width-global-sidebar custom-width-page-sidebar fullsize-if-mobile">-->
<!--            <div class="page-right-space global-right-space">-->
<!--                --><?php
//                // str_sidebar
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>