<?php

$base_model->adds_css([
    'themes/' . THEMENAME . '/css/author.css',
], [
    'cdn' => CDN_BASE_URL,
]);
$userMetaModel = new \App\Models\UserMeta();
$customModel = new \App\Models\CustomCode();
?>

<div class="row mt-3">
    <div class="col-12">
        <h1 class="title-box-category">Đội ngũ nhân sự </h1>
        <div class="row">
            <?php foreach ($data as $k => $v) {

                $countPost = $customModel->getCountPostOfUser($v['ID']);
                ?>
                <div class="col-6 mb-3 p-3 position-relative">
                    <a  href="<?= base_url()?>tacgia/<?=$v['ID']?>" class="element__click" title="Xem chi tiết thông tin tác giả" target="_blank"> </a>
                    <div class="media d-flex">
                        <img src="<?= base_url().$v['avatar'] ?>" class="mr-3 author__avatar" alt="...">
                        <div class="media-body">
                            <h5 class="mt-0"><a href="<?= base_url()?>tacgia/<?=$v['ID']?>"><?=$v['user_nicename']?></a></h5>
                            <span class="d-block"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=$v['user_email']?></span>
                            <span class="d-block"><i class="fa fa-calendar" aria-hidden="true"></i> <?= date('d-m-Y',strtotime($v['user_birthday']))?></span>
                            <span class="limit-text-4 d-block"><i class="fa fa-file-text-o" aria-hidden="true"></i> Số bài viết: <b><?= @$countPost['count'] ?></b></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>
