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
<div class="row row-collapse section-footer-center">
    <div class="col medium-2 small-12 large-2">
        <div class="col-inner logo__footer">
            <?php
            $option_model->the_logo($getconfig);
            ?>
        </div>
        </div>
    <div class="col medium-4 small-12 large-4">
        <div class="col-inner">

            <p class="text-footer">Chủ quản: <b><?php echo $getconfig->company_name; ?></b></p>
            <p class="text-footer">Địa chỉ: <?php echo $getconfig->address; ?></p>
            <p class="text-footer">Hotline: <a title="Click để liên lạc"
                                               href="tel:<?php echo $getconfig->phone; ?>"><?php echo $getconfig->phone; ?></a>
            </p>
            <p class="text-footer">Giấy phép ĐKKD: 0109319605 </p>
            <p class="text-footer">Giấy phép MXH: 01XK02022 </p>

        </div>
    </div>
    <div class="col medium-6 small-12 large-6">
        <div class="col-inner menu__footer-item">

            <?php

            $menu_model->the_menu('footer2-menu');

            ?>
        </div>
    </div>
</div>
<div class="row section-footer-center section-footer-center-line2">
    <div class="col medium-5 small-12 large-5">
        <div class="col-inner">
            <div class="item__bottom-footer">
                <a class="banquyen" title="Điều khoản" href="">Điều khoản</a>
                <a class="huongdan" title="Hướng dẫn" href="">Hướng dẫn</a>
            </div>
        </div>
    </div>
    <div class="col medium-6 small-12 large-6">
        <div class="col-inner menu__footer-item">
            <div class="item__top-footer">
                <div class="second__top">
                    <a title="Đến trang facebook" href="<?php echo $getconfig->facebook; ?>" class="item__facebook"></a>
                    <a title="Đến trang youtube" href=<?php echo $getconfig->youtube; ?>"" class="item__youtube"></a>
                    <a title="Đến trang tiktok" href="<?php echo $getconfig->tiktok; ?>" class="item__tiktok"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-collapse s14 text-center">
    <div class="col medium-12 small-12 large-12">
        <div class="col-inner">
            <?php

            //
            $lang_model->the_web_license($getconfig);

            ?>
        </div>
    </div>
</div>
