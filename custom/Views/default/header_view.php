<?php
$custom_code_model = new \App\Models\CustomCode();
if ($isMobile == true) {
    include VIEWS_CUSTOM_PATH . 'includes/header_mobile.php';
} else {

//


    ?>

    <div class="row row-collapse align-middle py-2">
        <div class="col medium-2 small-12 large-2">
            <div class="col-inner">
                <?php
                $option_model->the_logo($getconfig);
                ?>
            </div>
        </div>
        <div class="col medium-2 small-12 large-2">
            <div class="col-inner top1-menu">
                <?php
                echo $custom_code_model->get_current_day();
                ?>
            </div>
        </div>
        <div class="col medium-3 small-12 large-3">
            <div class="col-inner top-search">
                <form method="get" action="search" class="header__top">
                    <div class="itemInput">
                        <div class="itemIcon">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="elementInput">
                            <input type="search" name="s" placeholder='VD: hôn ly hôn đơn phương, tư vấn luật, tư vấn pháp luật, đơn khởi kiện, công ty luật, luật sư tư vấn'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col medium-5 small-12 large-5">
            <div class="col-inner top-user-menu cf d-flex">
                <a target="_blank" href="/" title="Đăng ký ộ công thương" class="dmca-badge">
                    <img style="height: 50px;width: 100%;" src ="<?= base_url() ?>upload/2023/09/dich-vu-thong-bao-bo-cong-thuong-removebg-preview-thumbnail.png"  alt="Đăng ký bộ công thương" />
                </a>
                <a target="_blank" href="https://www.dmca.com/Protection/Status.aspx?ID=64e71b30-ebd3-42bc-b908-4c0d404f0a0e&refurl=https://luatanhngoc.vn" title="DMCA.com Protection Status" class="dmca-badge">
                    <img style="height: 30px;width: 100%;" src ="https://images.dmca.com/Badges/DMCA_logo-grn-btn120w.png?ID=64e71b30-ebd3-42bc-b908-4c0d404f0a0e"  alt="DMCA.com Protection Status" />
                </a>
                <?php

                // nếu đã đăng nhập -> hiển thị menu profile
                if (!empty($session_data) && isset($session_data['userID']) && $session_data['userID'] > 0) {
                    // hiển thị thêm menu cho admin
                    if (isset($session_data['userLevel']) && $session_data['userLevel'] > 0) {
                        $menu_model->the_menu('top-admin-menu');
                    }

                    //
                    $menu_model->the_menu('top-profile-menu');
                } // chưa thì hiển thị menu đăng nhập/ đăng ký
                else {
                    $menu_model->the_menu('top-login-menu');
                }

                ?>
            </div>
        </div>
    </div>
    <div class="bborder">
        <div class="main-menu header__navbar">
            <div class="row row-collapse">
                <div class="col medium-12 small-12 large-12">
                    <div class="col-inner main_nav">
                        <?php
                        $menu_model->the_menu('top-nav-menu')
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-more-menu">
            <div class="row row-collapse">
                <div class="col medium-12 small-12 large-12">
                    <div class="col-inner">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu__all">
        <div class="row row-collapse">
            <div class="col">
                <div class="col-inner">
                    <h4 class="title">Tất cả chuyên mục <a href="javascript:;" class="close-menu" title="Đóng"
                                                           style="user-select: auto;">Đóng <span class="icon-close"></span></a>
                    </h4>
                    <hr>
                    <br>
                    <div class="menu__content">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>