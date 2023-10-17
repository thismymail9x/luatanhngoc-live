<?php

$base_model->adds_css(['themes/' . THEMENAME . '/css/author.css',
], [
    'cdn' => CDN_BASE_URL,
]);

$userMetaModel = new \App\Models\UserMeta();
?>

<div class="row mt-3">
    <div class="col-12 col-md-8">
        <h5 class="mb-2">Tài Khoản của bạn chưa được kích hoạt</h5>
        <h4>Vui lòng <a style="color: red!important;" href="<?=base_url().'pages/dat-lich'?>">Liên hệ</a> với Admin để viết bài</h4>
    </div>
    <div class="col-12 col-md-4">

        <div class="box-category">
            <div class="box-category box-tacgia">
                <h2 class="title-box-category">Tác giả được đọc nhiều</h2>
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
