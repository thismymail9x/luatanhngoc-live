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
            <a href="<?php echo base_url(); ?>"><img loading="lazy" class="logo"
                                                     src="<?= base_url().$getconfig->logo ?>"
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

