<!--<div class="row row-collapse footer-top-menu">-->
<!--    <div class="col medium-9 small-12 large-9">-->
<!--        <div class="col-inner">-->
<!--            --><?php
//
//            $menu_model->the_menu( 'footer1-menu' );
//
//            ?>
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col medium-3 small-12 large-3">-->
<!--        <div class="col-inner">-->
<!--            --><?php
//
//            $menu_model->the_menu( 'footer2-menu' );
//
//            ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<section id="footer">
    <img loading="lazy" class="lazyloaded" src="<?= base_url()?>upload/2023/09/logo-footer-luat-anh-ngoc.png" alt="Luật Ánh Ngọc" aria-hidden="" >
    <section class="row first-row bottom">
        <div class="col-xs-12 col-md-6 col-xl-6">
            <a href="<?php echo base_url(); ?>">
                <img loading="lazy" class="logo dark"
                                                     src="<?= base_url().$getconfig->logo ?>"
                                                     alt="logo_anhngoc_footer">
                <img loading="lazy" class="logo light"
                     src="<?= base_url().$getconfig->logofooter ?>"
                     alt="logo_anhngoc_footer">
            </a>
            <p class="phone"><a class="phone" href="tel:<?=$getconfig->phone?>"><?php echo preg_replace("/(\d{4})(\d{3})(\d{3})/", "$1.$2.$3", $getconfig->phone)?></a></p>
            <p class="text"><a class="text" href="mailto:<?=$getconfig->emailcontact?>"><?=$getconfig->emailcontact?></a></p>
            <p class="text">
                <?=$getconfig->company_name?>
            </p>
            <p class="text"><?=$getconfig->address?></p>
        </div>
        <div class="col-xs-12 col-md-6 col-xl-6 center">
            <p class="title">Liên kết</p>
            <?php
            $menu_model->the_menu('footer2-menu');

            ?>
        </div>
    </section>
    <section class="footer-bottom">
        <div class="row second-row">
            <div class="col-xs-12 col-md-12">
                                    <p class="left">© <?= date('Y') ?> <?=$getconfig->website?> Đã đăng ký Bản quyền</p>
            </div>
        </div>
    </section>
</section>
<div class="mobile_wiget">
    <div class="item">
<!--        <a href="tel:--><?php //=$getconfig->phone?><!--">-->
<!--            <i class="fa fa-mobile" aria-hidden="true"></i> Điện thoại-->
<!--        </a>-->
        <a href="<?=base_url()?>pages/lien-he" target="_blank">
            <i class="fa fa-paperclip" aria-hidden="true"></i> Liên hệ
        </a>
    </div>
</div>

<div class="wiget_contact">
    <a href="<?=base_url()?>pages/dat-lich" target="_blank" title="Tư vấn miễn phí" >
        <img  src="<?=base_url()?>upload/2023/09/tu-van-mien-phi.png" alt="Tư vấn miễn phí">
    </a>
</div>
<div class="zalo-chat-widget" data-oaid="2358543509212927618" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="" data-height=""></div>
<script src="https://sp.zalo.me/plugins/sdk.js"></script>

