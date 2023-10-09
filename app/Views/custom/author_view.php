<?php
$base_model->adds_css(['themes/' . THEMENAME . '/css/author.css',
], [
    'cdn' => CDN_BASE_URL,
]);
$in_cache = $user_model->key_cache('author-'.$data['ID']);

$userMetaModel = new \App\Models\UserMeta();
$dataPost = $base_model->scache($in_cache);

if ($dataPost === null) {

    $dataPost = $base_model->select('*', 'posts', array(
        // các kiểu điều kiện where
        'post_status'=>'publish',
        'post_author' => $data['ID'],
        'post_type'=> \App\Libraries\PostType::POST
    ), array(
        'limit' => 10,
    ));
    if (!empty($dataPost)) {
        $dataPost = $post_model->list_meta_post($dataPost);
    }
    $base_model->scache($in_cache, $dataPost, 300);
}


?>

<div class="row mt-3">
    <div class="col-12 col-md-8">
        <div class="info-detail-tg flexbox">
            <div class="item-news flexbox">
                <div class="thumb-art">
                    <div class="thumb thumb-1x1 thumb-circle">
                        <img src="<?= $data['avatar'] ?>" alt="<?= $data['user_nicename'] ?>">
                    </div>
                </div>
                <div class="sum-info">
                    <h3 class="author_name"><?= $data['user_nicename'] ?></h3>
                    <a href="mailto:<?= $data['user_email'] ?>" class="d-block"><i class="fa fa-envelope-o"
                                             aria-hidden="true"></i> <?= $data['user_email'] ?></a>
                    <span class="d-block"><i class="fa fa-calendar"
                                             aria-hidden="true"></i> <?= date('d-m-Y',strtotime($data['user_birthday'])) ?></span>
                    <span class="limit-text-4 d-block"><i class="fa fa-file-text-o" aria-hidden="true"></i> Số bài viết: <b><?= @$countPost ?></b></span>
                </div>
            </div>

        </div>
        <div class="text-detail-tg">
            <?= $data['description'] ?>
        </div>
        <div class="box-art-tg width_common mt20">
            <h3 class="title-box-category">Bài viết tiêu biểu </h3>
            <div class="list-news-subfolder list-art-bggray list-news-contain">
                <?php
                // lấy bài đầu tiên
                foreach ($dataPost as $k => $v) {

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
    <div class="col-12 col-md-4">

        <div class="box-category">
            <div class="box-category box-tacgia">
                <h2 class="title-box-category">Nhân sự được đọc nhiều</h2>
                <div class="list-news-subfolder">
                    <?php foreach (@$topAuthor as $k => $val){ ?>
                    <div class="item-news item-news-common">
                        <div class="thumb-art">
                            <a href="" class="thumb thumb-1x1 thumb-circle">
                                <img src="<?=base_url().$val['avatar']?>" alt="<?=$val['user_nicename']?>">
                            </a>
                        </div>
                        <h3 class="title-news">
                            <a href="<?=base_url().'tacgia/'.$val['ID']?>"><?=$val['user_nicename']?></a>
                        </h3>
                        <p class="description">
                            <i class="fa fa-eye" aria-hidden="true"></i> <span><?=$val['total']?></span>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>
