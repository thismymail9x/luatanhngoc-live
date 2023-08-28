<?php

// Libraries
use App\Libraries\CommentType;
use App\Libraries\TaxonomyType;

//
$comment_model = new \App\Models\Comment();

// update lượt xem
$post_model->update_views( $data[ 'ID' ] );

?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0" nonce="JpTGkc9y"></script>
<div class="row global-post-module ">
    <div class="col medium-8 small-12 large-8">
        <div class="col-inner">
            <div class="post_section">
                <h1 data-type="<?php echo $data['post_type']; ?>" data-id="<?php echo $data['ID']; ?>"
                    class="post-details-title global-details-title global-module-title">
                    <?php
                    echo $data['post_title'];
                    ?>
                </h1>
                <div class="more__information-post">
                    <div class="fb-share-button" data-href="<?php echo $post_model->get_full_permalink($data);?>" data-layout="button" data-size="small"><a target="_blank" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    <span class="item__eye"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $data['post_viewed']; ?></span>
                </div>
                <div class="menuPost">
                    <div id="contentCategory" class="contentCategory collapsed">
                        <div class="item-top">
                            <i class="fa-solid fa-list-ol" style="color: #ffff00;"></i>
                            <span>Mục lục bài viết</span>
                            <i class="fa-solid fa-chevron-down icon__rotate" style="color: #ffff00;"></i>
                        </div>
                        <div class="item-bottom">
<!--                            --><?php //foreach (@ $data['contentCategory'] as $key => $value) { ?>
<!--                                <p class="parent"><a title="--><?//=$value['name']?><!--" href="#--><?//=$value['id']?><!--">--><?//=$value['name']?><!--</a></p>-->
<!--                                --><?php //foreach ($value['children'] as $k => $v) { ?>
<!--                                    <p class="children"><a title="--><?//=$v['name']?><!--" href="#--><?//=$v['id']?><!--">--><?//=$v['name']?><!--</a></p>-->
<!--                                --><?php //} } ?>
                        </div>
                    </div>
                </div>
                <div class="img-max-width">
                    <div class="medium global-details-content <?php echo $data['post_type']; ?>-details-content ul-default-style">
                        <?php
                        echo $data['post_content'];
                        ?>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="line__item"></div>
            <div class="top__item">
                <?php

                // html_for_fb_comment
                // lấy danh sách bình luận
                $data_comment = $base_model->select('*', $comment_model->table, array(
                    // các kiểu điều kiện where
                    //$comment_model->primaryKey => $v[ 'comment_ID' ],
                    'comment_type' => CommentType::COMMENT,
                    'comment_post_ID' => $data['ID'],
                ), array(
                    /*
                         'order_by' => array(
                         $comment_model->primaryKey => 'DESC'
                         ),
                         */
                    // hiển thị mã SQL để check
                    //'show_query' => 1,
                    // trả về câu query để sử dụng cho mục đích khác
                    //'get_query' => 1,
                    //'offset' => 2,
                    //'limit' => 1
                ));
                //print_r( $data_comment );

                //
                $stt = 1;
                foreach ($data_comment as $v) {
                    $v['comment_content'] = str_replace('data-to-srcset', 'srcset', $v['comment_content']);

                    ?>
                    <div id="<?php echo $stt; ?>" class="comment_block row row-collapse">
                        <div class="col medium-12 small-12 large-12">

                            <div class="col-inner top-menu-space10 media-body">
                                <div class="section__comment">
                                    <div class="badged_small" data-stt="<?php echo $stt; ?>">
                                        <?php echo $stt; ?>
                                    </div>
                                    <h4 class="comment_title">
                                        <a title="<?php echo $v['comment_title']; ?>"><?php echo $v['comment_title']; ?></a>
                                    </h4>
                                </div>
                                <div data-id="<?php echo $v['comment_ID']; ?>" class="comment_content s14">
                                    <?php echo $v['comment_content']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                    //
                    $stt++;
                }

                ?>
            </div>

        </div>
    </div>
    <div class="col medium-4 small-12 large-4 more_post hide__if-mobile">
        <div class="col-inner">
            <div class="menu__top">
                    <h5 class="title__menu-flash">Mục lục</h5>
                    <?php foreach ($data_comment as $k => $v) { $k++;?>
                        <div data-key="<?php echo $k; ?>" class="section__comment-small">
                            <div class="badged_small-menu" data-stt="<?php echo $k; ?>">
                                <?php echo $k; ?>
                            </div>
                            <h4 class="comment_title-small">
                                <a title="<?php echo $v['comment_title']; ?>"><?php echo $v['comment_title']; ?></a>
                            </h4>
                        </div>
                    <?php } ?>
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